<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price_per_day', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_day', 'desc');
                    break;
                case 'year_desc':
                    $query->orderBy('year', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $perPage = (int) $request->input('per_page', 15);
        $cars = $query->paginate($perPage)->withQueryString();

        $stats = Car::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "available" THEN 1 ELSE 0 END) as available,
            SUM(CASE WHEN status = "rented" THEN 1 ELSE 0 END) as rented,
            SUM(CASE WHEN status = "maintenance" THEN 1 ELSE 0 END) as maintenance
        ')->first();

        // Add proper year range stats
        $yearStats = $this->getYearRangeStats();
        $stats->min_year = $yearStats['min_year'];
        $stats->max_year = $yearStats['max_year'];

        $trashedCount = Car::onlyTrashed()->count();
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');

        return view('admin.cars.index', compact('cars', 'stats', 'trashedCount', 'brands'));
    }

    /**
     * Calculate proper year range from cars data
     */
    private function getYearRangeStats()
    {
        $cars = Car::all();
        $allStartYears = [];
        $allEndYears = [];

        foreach ($cars as $car) {
            $cleanYear = $this->cleanYearFormat($car->year);

            if (str_contains($cleanYear, ' - ')) {
                $years = explode(' - ', $cleanYear);
                if (count($years) === 2) {
                    $allStartYears[] = (int) trim($years[0]);
                    $allEndYears[] = (int) trim($years[1]);
                }
            } else {
                // Jika format single year
                $year = (int) trim($cleanYear);
                if ($year > 0) {
                    $allStartYears[] = $year;
                    $allEndYears[] = $year;
                }
            }
        }

        // Jika tidak ada data, gunakan tahun sekarang
        if (empty($allStartYears)) {
            $currentYear = date('Y');
            return [
                'min_year' => $currentYear,
                'max_year' => $currentYear
            ];
        }

        return [
            'min_year' => min($allStartYears),
            'max_year' => max($allEndYears)
        ];
    }

    /**
     * Clean year format from messy strings
     */
    private function cleanYearFormat($year)
    {
        if (empty($year)) {
            return date('Y') . ' - ' . date('Y');
        }

        // Remove unwanted characters, keep only numbers and hyphens
        $cleanYear = preg_replace('/[^0-9\s\-]/', '', $year);
        $cleanYear = trim($cleanYear);

        // Extract all 4-digit years
        preg_match_all('/(\d{4})/', $cleanYear, $matches);
        $years = $matches[1] ?? [];

        if (count($years) >= 2) {
            return $years[0] . ' - ' . end($years);
        } elseif (count($years) === 1) {
            return $years[0] . ' - ' . $years[0];
        }

        return date('Y') . ' - ' . date('Y'); // fallback
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'category' => 'nullable|string|in:MPV Family,SUV Premium,City Car,Luxury / VIP',
            'plate_number' => 'required|string|max:255|unique:cars',
            'year' => 'required|string|max:20',
            'price_per_day' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255|in:bensin,solar,listrik,hybrid',
            'transmission' => 'nullable|string|max:255|in:manual,automatic',
            'seat_capacity' => 'nullable|integer|min:1|max:20',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'plate_number.unique' => 'Nomor plat sudah terdaftar',
            'price_per_day.min' => 'Harga harus lebih dari 0',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'images.*.image' => 'Semua file harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'images.*.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        try {
            // Clean year format before saving
            $validated['year'] = $this->cleanYearFormat($validated['year']);

            // Handle single image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('cars', 'public');
                $validated['image'] = $imagePath;
            }

            // Handle multiple images upload
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('cars/gallery', 'public');
                }
                $validated['images'] = $imagePaths;
            }

            $car = Car::create($validated);

            Log::info('New car created', [
                'car_id' => $car->id,
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'plate_number' => $validated['plate_number'],
                'year' => $validated['year'],
                'has_image' => !empty($validated['image']),
                'has_gallery' => !empty($validated['images']),
                'created_by' => auth()->id()
            ]);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Mobil berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Car creation failed: ' . $e->getMessage(), [
                'request_data' => $request->except('_token')
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menambahkan mobil. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        // Load related bookings
        $bookings = $car->bookings()
            ->with('car')
            ->latest()
            ->paginate(10);

        return view('admin.cars.show', compact('car', 'bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'category' => 'nullable|string|in:MPV Family,SUV Premium,City Car,Luxury / VIP',
            'plate_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cars')->ignore($car->id)
            ],
            'year' => 'required|string|max:20',
            'price_per_day' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255|in:bensin,solar,listrik,hybrid',
            'transmission' => 'nullable|string|max:255|in:manual,automatic',
            'seat_capacity' => 'nullable|integer|min:1|max:20',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_image' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string'
        ], [
            'plate_number.unique' => 'Nomor plat sudah terdaftar',
            'price_per_day.min' => 'Harga harus lebih dari 0',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'images.*.image' => 'Semua file harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'images.*.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        try {
            $oldData = $car->toArray();

            // Clean year format before saving
            $validated['year'] = $this->cleanYearFormat($validated['year']);

            // Handle image removal
            if ($request->has('remove_image') && $car->image) {
                Storage::disk('public')->delete($car->image);
                $validated['image'] = null;
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($car->image) {
                    Storage::disk('public')->delete($car->image);
                }
                $imagePath = $request->file('image')->store('cars', 'public');
                $validated['image'] = $imagePath;
            }

            // Handle gallery images removal
            if ($request->has('remove_images') && $car->images) {
                $currentImages = $car->images ?? [];
                $imagesToRemove = $request->input('remove_images', []);

                foreach ($imagesToRemove as $imageToRemove) {
                    if (($key = array_search($imageToRemove, $currentImages)) !== false) {
                        Storage::disk('public')->delete($imageToRemove);
                        unset($currentImages[$key]);
                    }
                }
                $validated['images'] = array_values($currentImages);
            }

            // Handle new gallery images upload
            if ($request->hasFile('images')) {
                $currentImages = $validated['images'] ?? ($car->images ?? []);
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('cars/gallery', 'public');
                    $currentImages[] = $imagePath;
                }
                $validated['images'] = $currentImages;
            }

            $car->update($validated);

            Log::info('Car updated', [
                'car_id' => $car->id,
                'old_data' => $oldData,
                'new_data' => $validated,
                'image_updated' => $request->hasFile('image') || $request->has('remove_image'),
                'gallery_updated' => $request->hasFile('images') || $request->has('remove_images'),
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Data mobil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Car update failed: ' . $e->getMessage(), [
                'car_id' => $car->id,
                'request_data' => $request->except('_token', '_method')
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memperbarui data mobil. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        try {
            // Cek apakah mobil memiliki booking aktif
            $hasActiveBookings = $car->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->exists();

            if ($hasActiveBookings) {
                return redirect()->route('admin.cars.index')
                    ->with('error', 'Tidak dapat menghapus mobil yang memiliki booking aktif!');
            }

            $carName = $car->brand . ' ' . $car->model . ' (' . $car->plate_number . ')';

            // Delete images
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            if ($car->images) {
                foreach ($car->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Soft delete
            $car->delete();

            Log::info('Car soft deleted', [
                'car_id' => $car->id,
                'car_name' => $carName,
                'images_deleted' => true,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Mobil berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Car deletion failed: ' . $e->getMessage(), [
                'car_id' => $car->id
            ]);

            return redirect()->route('admin.cars.index')
                ->with('error', 'Gagal menghapus mobil: ' . $e->getMessage());
        }
    }

    /**
     * Quick update status - FIXED: Using POST method
     */
    public function updateStatus(Request $request, Car $car)
    {
        try {
            $request->validate([
                'status' => 'required|in:available,rented,maintenance'
            ]);

            $oldStatus = $car->status;
            $car->update(['status' => $request->status]);

            Log::info('Car status updated', [
                'car_id' => $car->id,
                'car_name' => $car->brand . ' ' . $car->model,
                'from_status' => $oldStatus,
                'to_status' => $request->status,
                'updated_by' => auth()->id()
            ]);

            return back()->with('success', 'Status mobil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Car status update failed: ' . $e->getMessage(), [
                'car_id' => $car->id,
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Gagal mengupdate status mobil. Silakan coba lagi.');
        }
    }

    /**
     * Show trashed cars
     */
    public function trashed()
    {
        $cars = Car::onlyTrashed()->latest()->paginate(10);

        // Statistik untuk trashed page
        $stats = Car::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "available" THEN 1 ELSE 0 END) as available,
            SUM(CASE WHEN status = "rented" THEN 1 ELSE 0 END) as rented,
            SUM(CASE WHEN status = "maintenance" THEN 1 ELSE 0 END) as maintenance
        ')->first();

        // Add year stats for trashed page too
        $yearStats = $this->getYearRangeStats();
        $stats->min_year = $yearStats['min_year'];
        $stats->max_year = $yearStats['max_year'];

        return view('admin.cars.trashed', compact('cars', 'stats'));
    }

    /**
     * Restore trashed car
     */
    public function restore($id)
    {
        try {
            $car = Car::withTrashed()->findOrFail($id);
            $car->restore();

            Log::info('Car restored', [
                'car_id' => $car->id,
                'car_name' => $car->brand . ' ' . $car->model,
                'restored_by' => auth()->id()
            ]);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Mobil berhasil dipulihkan!');
        } catch (\Exception $e) {
            Log::error('Car restore failed: ' . $e->getMessage(), [
                'car_id' => $id
            ]);

            return redirect()->route('admin.cars.trashed')
                ->with('error', 'Gagal memulihkan mobil: ' . $e->getMessage());
        }
    }

    /**
     * Force delete car permanently
     */
    public function forceDelete($id)
    {
        try {
            $car = Car::withTrashed()->findOrFail($id);

            // Check if car has any bookings
            if ($car->bookings()->count() > 0) {
                return redirect()->route('admin.cars.trashed')
                    ->with('error', 'Tidak dapat menghapus permanen mobil yang memiliki riwayat booking!');
            }

            $carName = $car->brand . ' ' . $car->model . ' (' . $car->plate_number . ')';

            // Delete all images
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            if ($car->images) {
                foreach ($car->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $car->forceDelete();

            Log::warning('Car permanently deleted', [
                'car_id' => $id,
                'car_name' => $carName,
                'images_deleted' => true,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('admin.cars.trashed')
                ->with('success', 'Mobil berhasil dihapus permanen!');
        } catch (\Exception $e) {
            Log::error('Car force delete failed: ' . $e->getMessage(), [
                'car_id' => $id
            ]);

            return redirect()->route('admin.cars.trashed')
                ->with('error', 'Gagal menghapus mobil permanen: ' . $e->getMessage());
        }
    }

    /**
     * Delete single image from gallery
     */
    public function deleteImage(Request $request, Car $car)
    {
        try {
            $request->validate([
                'image_path' => 'required|string'
            ]);

            $imagePath = $request->image_path;

            // Verify the image belongs to this car
            if ($car->images && in_array($imagePath, $car->images)) {
                Storage::disk('public')->delete($imagePath);

                $updatedImages = array_values(array_diff($car->images, [$imagePath]));
                $car->update(['images' => $updatedImages]);

                Log::info('Car gallery image deleted', [
                    'car_id' => $car->id,
                    'image_path' => $imagePath,
                    'deleted_by' => auth()->id()
                ]);

                return back()->with('success', 'Gambar berhasil dihapus dari galeri!');
            }

            return back()->with('error', 'Gambar tidak ditemukan!');
        } catch (\Exception $e) {
            Log::error('Car image deletion failed: ' . $e->getMessage(), [
                'car_id' => $car->id,
                'image_path' => $request->image_path
            ]);

            return back()->with('error', 'Gagal menghapus gambar: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to get image URL
     */
    private function getImageUrl($path)
    {
        if (!$path) return null;

        // Check if file exists in storage
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return null;
    }

    /**
     * Helper method to get all image URLs for a car
     */
    public function getCarImageUrls(Car $car)
    {
        $imageUrls = [];

        // Main image
        if ($car->image) {
            $imageUrls['main'] = $this->getImageUrl($car->image);
        }

        // Gallery images
        $imageUrls['gallery'] = [];
        if ($car->images) {
            foreach ($car->images as $image) {
                $imageUrls['gallery'][] = $this->getImageUrl($image);
            }
        }

        return $imageUrls;
    }

    /**
     * Temporary method to fix existing year data (run once)
     */
    public function fixYearData()
    {
        try {
            $cars = Car::all();
            $fixedCount = 0;

            foreach ($cars as $car) {
                $cleanYear = $this->cleanYearFormat($car->year);
                if ($cleanYear !== $car->year) {
                    $car->update(['year' => $cleanYear]);
                    $fixedCount++;
                }
            }

            return redirect()->route('admin.cars.index')
                ->with('success', "Data tahun berhasil dibersihkan! {$fixedCount} mobil diperbaiki.");
        } catch (\Exception $e) {
            Log::error('Year data fix failed: ' . $e->getMessage());
            return redirect()->route('admin.cars.index')
                ->with('error', 'Gagal membersihkan data tahun: ' . $e->getMessage());
        }
    }
}
