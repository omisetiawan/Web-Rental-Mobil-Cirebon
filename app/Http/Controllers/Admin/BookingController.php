<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Booking::with('car')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhereHas('car', function ($carQ) use ($search) {
                        $carQ->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%")
                            ->orWhere('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        $statusFilter = $request->status;
        if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'rejected', 'completed'])) {
            $query->where('status', $statusFilter);
        }

        $perPage = (int) $request->input('per_page', 15);
        $bookings = $query->paginate($perPage)->withQueryString();

        // Hitung statistik dari seluruh database
        $stats = Booking::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed
        ')->first();

        // Hitung total nilai transaksi aktif & selesai
        $revenue = Booking::whereIn('status', ['approved', 'completed'])->sum('total_price');

        return view('admin.bookings.index', compact('bookings', 'stats', 'revenue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cars = Car::where('status', 'available')->get();
        return view('admin.bookings.create', compact('cars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        try {
            // Check if car is available for the selected dates
            $existingBooking = Booking::where('car_id', $validated['car_id'])
                ->where('status', 'approved')
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                        ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                        ->orWhere(function ($q) use ($validated) {
                            $q->where('start_date', '<=', $validated['start_date'])
                                ->where('end_date', '>=', $validated['end_date']);
                        });
                })->exists();

            if ($existingBooking) {
                return back()->with('error', 'Mobil tidak tersedia untuk tanggal yang dipilih!')->withInput();
            }

            // PERBAIKAN: Hitung durasi tanpa +1 (30 Nov - 1 Dec = 1 hari)
            $start = Carbon::parse((string) $validated['start_date']);
            $end = Carbon::parse((string) $validated['end_date']);
            $duration = $start->diffInDays($end); // HAPUS +1

            // Create booking
            $booking = Booking::create(array_merge($validated, ['duration' => $duration]));

            // Update car status if approved
            if ($validated['status'] == 'approved') {
                Car::where('id', $validated['car_id'])->update(['status' => 'rented']);
            }

            Log::info('New booking created', [
                'booking_id' => $booking->id,
                'customer_name' => $validated['customer_name'],
                'car_id' => $validated['car_id'],
                'duration' => $duration,
                'total_price' => $validated['total_price'],
                'created_by' => Auth::id()
            ]);

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Booking creation failed: ' . $e->getMessage(), [
                'request_data' => $request->except('_token')
            ]);

            return redirect()->back()
                ->with('error', 'Gagal membuat booking. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): View
    {
        $booking->load('car');
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking): View
    {
        $cars = Car::all();
        $booking->load('car');
        return view('admin.bookings.edit', compact('booking', 'cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        try {
            $oldStatus = $booking->status;
            $oldCarId = $booking->car_id;

            // PERBAIKAN: Hitung durasi tanpa +1
            $start = Carbon::parse((string) $validated['start_date']);
            $end = Carbon::parse((string) $validated['end_date']);
            $duration = $start->diffInDays($end); // HAPUS +1

            $booking->update(array_merge($validated, ['duration' => $duration]));

            // Update car status based on booking status
            $this->updateCarStatus($booking, $oldStatus, $oldCarId);

            Log::info('Booking updated', [
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'duration' => $duration,
                'updated_by' => Auth::id()
            ]);

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Booking update failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'request_data' => $request->except('_token', '_method')
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memperbarui booking. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        try {
            $bookingData = [
                'id' => $booking->id,
                'customer_name' => $booking->customer_name,
                'status' => $booking->status,
                'car_id' => $booking->car_id
            ];

            // Free the car if booking was approved
            if ($booking->status == 'approved') {
                Car::where('id', $booking->car_id)->update(['status' => 'available']);
            }

            $booking->delete();

            Log::info('Booking deleted', [
                'booking_data' => $bookingData,
                'deleted_by' => Auth::id()
            ]);

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Booking deletion failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id
            ]);

            return redirect()->route('admin.bookings.index')
                ->with('error', 'Gagal menghapus booking: ' . $e->getMessage());
        }
    }

    /**
     * Update booking status quickly
     */
    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected,completed'
            ]);

            $oldStatus = $booking->status;
            $oldCarId = $booking->car_id;

            $booking->update(['status' => $request->input('status')]);

            // Update car status based on booking status
            $this->updateCarStatus($booking, $oldStatus, $oldCarId);

            Log::info('Booking status updated', [
                'booking_id' => $booking->id,
                'customer_name' => $booking->customer_name,
                'from_status' => $oldStatus,
                'to_status' => $request->input('status'),
                'updated_by' => Auth::id()
            ]);

            return back()->with('success', 'Status booking berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Booking status update failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Gagal mengupdate status booking. Silakan coba lagi.');
        }
    }

    /**
     * Helper method to update car status
     */
    private function updateCarStatus(Booking $booking, string $oldStatus, int $oldCarId): void
    {
        try {
            // If car changed, free the old car
            if ($oldCarId != $booking->car_id && $oldStatus == 'approved') {
                Car::where('id', $oldCarId)->update(['status' => 'available']);

                Log::info('Car status updated (old car freed)', [
                    'car_id' => $oldCarId,
                    'new_status' => 'available',
                    'reason' => 'booking car changed'
                ]);
            }

            // Update new car status
            if ($booking->status == 'approved') {
                Car::where('id', $booking->car_id)->update(['status' => 'rented']);

                Log::info('Car status updated (new car rented)', [
                    'car_id' => $booking->car_id,
                    'new_status' => 'rented',
                    'booking_id' => $booking->id
                ]);
            } elseif ($oldStatus == 'approved' && $booking->status != 'approved') {
                Car::where('id', $booking->car_id)->update(['status' => 'available']);

                Log::info('Car status updated (car freed)', [
                    'car_id' => $booking->car_id,
                    'new_status' => 'available',
                    'reason' => 'booking status changed from approved'
                ]);
            } elseif ($booking->status == 'completed') {
                Car::where('id', $booking->car_id)->update(['status' => 'available']);

                Log::info('Car status updated (car freed)', [
                    'car_id' => $booking->car_id,
                    'new_status' => 'available',
                    'reason' => 'booking completed'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Car status update failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'car_id' => $booking->car_id,
                'old_status' => $oldStatus
            ]);

            throw $e; // Re-throw to be handled by calling method
        }
    }

    /**
     * Calculate price based on dates and car
     */
    public function calculatePrice(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'car_id' => 'required|exists:cars,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);

            $car = Car::findOrFail($request->input('car_id'));
            $start = Carbon::parse((string) $request->input('start_date'));
            $end = Carbon::parse((string) $request->input('end_date'));

            // PERBAIKAN: Hitung hari TANPA +1 (30 Nov - 1 Dec = 1 hari)
            $days = $start->diffInDays($end); // HAPUS +1

            $totalPrice = $days * $car->price_per_day;

            Log::debug('Price calculation', [
                'car_id' => $car->id,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'days' => $days,
                'price_per_day' => $car->price_per_day,
                'total_price' => $totalPrice
            ]);

            return response()->json([
                'total_price' => $totalPrice,
                'days' => $days,
                'price_per_day' => $car->price_per_day,
                'car_info' => [
                    'brand' => $car->brand,
                    'model' => $car->model,
                    'plate_number' => $car->plate_number
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Price calculation failed: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Gagal menghitung harga. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get booking statistics for dashboard
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = Booking::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed
            ')->first();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Get booking stats failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Gagal mengambil statistik booking'
            ], 500);
        }
    }
}
