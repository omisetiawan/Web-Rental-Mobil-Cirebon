<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display the authentic, data-driven admin dashboard.
     */
    public function index(Request $request)
    {
        // Fleet stats
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $rentedCars = Car::where('status', 'rented')->count();
        $maintenanceCars = Car::where('status', 'maintenance')->count();

        // Booking stats
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $completedBookings = Booking::where('status', 'completed')->count();

        // Revenue calculations (Real data from database)
        $grossRevenue = (float) Booking::whereIn('status', ['approved', 'completed'])->sum('total_price');
        $qualifiedOrdersCount = $approvedBookings + $completedBookings;
        $avgRentalValue = $qualifiedOrdersCount > 0
            ? ($grossRevenue / $qualifiedOrdersCount)
            : 0;

        // Vehicle Categories Breakdown for Donut Chart
        $cars = Car::all();
        $categories = [
            'MPV Family' => 0,
            'SUV Premium' => 0,
            'City Car' => 0,
            'Luxury / VIP' => 0,
        ];

        foreach ($cars as $car) {
            $cat = $car->category;
            if (isset($categories[$cat])) {
                $categories[$cat]++;
            } else {
                $categories['MPV Family']++;
            }
        }
        $categories['Luxury / Sedan'] = $categories['Luxury / VIP'];

        // Weekly Best Sellers / Top Performing Cars (100% Real from Database)
        $bestSellers = Car::withCount(['bookings as total_rented' => function ($q) {
            $q->whereIn('status', ['approved', 'completed']);
        }])
        ->orderByDesc('total_rented')
        ->take(4)
        ->get();

        // Monthly Trajectory for Chart (Past 6 Months Real Data)
        $months = [];
        $monthlyRevenue = [];
        $monthlyBookings = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            $monthlyRevenue[] = (float) Booking::whereIn('status', ['approved', 'completed'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');
            $monthlyBookings[] = Booking::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // Recent Bookings for Data Table
        $recentBookings = Booking::with('car')
            ->latest()
            ->take(6)
            ->get();

        // Recent Contacts for Inquiries list
        $recentContacts = Contact::latest()
            ->take(5)
            ->get();
        $unreadContactsCount = Contact::where('status', 'unread')->count();

        // Real Activity Feed derived from database records
        $recentActivities = collect();
        foreach ($recentBookings->take(3) as $b) {
            $carName = $b->car ? ($b->car->brand . ' ' . $b->car->model) : 'Armada Mobil';
            $badgeColor = $b->status === 'completed' ? 'success' : ($b->status === 'approved' ? 'primary' : 'warning');
            $statusLabel = $b->status === 'completed' ? 'Selesai' : ($b->status === 'approved' ? 'Disetujui' : 'Menunggu');
            $recentActivities->push([
                'title' => 'Booking #' . $b->id . ' — ' . $carName,
                'desc' => $b->customer_name . ' (' . $statusLabel . ' • Rp ' . number_format($b->total_price, 0, ',', '.') . ')',
                'time' => $b->created_at ? $b->created_at->diffForHumans() : 'Baru saja',
                'created_at' => $b->created_at,
                'icon' => 'fas fa-calendar-check',
                'color' => $badgeColor
            ]);
        }
        foreach ($recentContacts->take(3) as $c) {
            $recentActivities->push([
                'title' => 'Pesan Masuk: ' . $c->name,
                'desc' => Str::limit($c->message, 60),
                'time' => $c->created_at ? $c->created_at->diffForHumans() : 'Baru saja',
                'created_at' => $c->created_at,
                'icon' => 'fas fa-envelope',
                'color' => 'info'
            ]);
        }
        $recentActivities = $recentActivities->sortByDesc('created_at')->values();

        return view('admin.dashboard', compact(
            'totalCars',
            'availableCars',
            'rentedCars',
            'maintenanceCars',
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'completedBookings',
            'grossRevenue',
            'avgRentalValue',
            'categories',
            'bestSellers',
            'recentBookings',
            'recentContacts',
            'unreadContactsCount',
            'months',
            'monthlyRevenue',
            'monthlyBookings',
            'recentActivities'
        ));
    }
}
