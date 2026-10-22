<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Contact;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        if (Booking::count() === 0) {
            $alphard = Car::where('brand', 'Toyota')->where('model', 'Alphard')->first() ?? Car::first();
            $innova = Car::where('brand', 'Toyota')->where('model', 'Kijang Innova')->first() ?? Car::first();
            $avanza = Car::where('brand', 'Toyota')->where('model', 'Avanza')->first() ?? Car::first();
            $fortuner = Car::where('brand', 'Toyota')->where('model', 'Fortuner')->first() ?? Car::first();
            $brio = Car::where('brand', 'Honda')->where('model', 'Brio')->first() ?? Car::first();
            $hrv = Car::where('brand', 'Honda')->where('model', 'HR-V')->first() ?? Car::first();

            $bookings = [
                [
                    'car_id' => $alphard->id,
                    'customer_name' => 'Bpk. Heru Prasetyo',
                    'customer_phone' => '081234567890',
                    'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                    'duration' => 3,
                    'total_price' => 7500000,
                    'status' => 'approved',
                    'created_at' => Carbon::now()->subHours(5),
                ],
                [
                    'car_id' => $innova->id,
                    'customer_name' => 'Ibu Sarah Wijaya',
                    'customer_phone' => '082198765432',
                    'start_date' => Carbon::now()->subDays(4)->format('Y-m-d'),
                    'end_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                    'duration' => 4,
                    'total_price' => 2200000,
                    'status' => 'completed',
                    'created_at' => Carbon::now()->subDays(5),
                ],
                [
                    'car_id' => $avanza->id,
                    'customer_name' => 'Bpk. Anton Nugroho',
                    'customer_phone' => '085612348765',
                    'start_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
                    'duration' => 3,
                    'total_price' => 1050000,
                    'status' => 'pending',
                    'created_at' => Carbon::now()->subHours(2),
                ],
                [
                    'car_id' => $fortuner->id,
                    'customer_name' => 'dr. Kevin Pratama',
                    'customer_phone' => '087711223344',
                    'start_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'duration' => 3,
                    'total_price' => 2550000,
                    'status' => 'approved',
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'car_id' => $brio->id,
                    'customer_name' => 'Bpk. Dedi Supriyadi',
                    'customer_phone' => '081399887766',
                    'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                    'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                    'duration' => 3,
                    'total_price' => 960000,
                    'status' => 'pending',
                    'created_at' => Carbon::now()->subHours(1),
                ],
                [
                    'car_id' => $hrv->id,
                    'customer_name' => 'Ibu Maya Anggraini',
                    'customer_phone' => '082233445566',
                    'start_date' => Carbon::now()->subDays(6)->format('Y-m-d'),
                    'end_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
                    'duration' => 4,
                    'total_price' => 1800000,
                    'status' => 'completed',
                    'created_at' => Carbon::now()->subDays(7),
                ],
            ];

            foreach ($bookings as $b) {
                Booking::create($b);
            }
        }

        if (Contact::count() === 0) {
            $contacts = [
                [
                    'name' => 'Dimas Raditya',
                    'phone' => '081298761234',
                    'email' => 'dimas.raditya@gmail.com',
                    'purpose' => 'booking',
                    'message' => 'Halo admin RentGo, apakah unit Alphard ready untuk tanggal 25 Oktober antar jemput Stasiun Kejaksan?',
                    'status' => 'unread',
                    'created_at' => Carbon::now()->subHours(2),
                ],
                [
                    'name' => 'Rina Maulida',
                    'phone' => '085712345678',
                    'email' => 'rina.m@gmail.com',
                    'purpose' => 'info',
                    'message' => 'Mohon info apakah sewa mobil Innova Zenix bisa lepas kunci dengan jaminan KTP & SIM A?',
                    'status' => 'read',
                    'created_at' => Carbon::now()->subHours(5),
                ],
                [
                    'name' => 'Hendra Gunawan (PT Bahari Cirebon)',
                    'phone' => '081388776655',
                    'email' => 'hendra@bahari.co.id',
                    'purpose' => 'partnership',
                    'message' => 'Kami membutuhkan sewa rental bulanan 3 unit mobil operasional (Avanza/Xenia) untuk kantor cabang Cirebon. Mohon kirimkan penawaran harga.',
                    'status' => 'unread',
                    'created_at' => Carbon::now()->subHours(8),
                ],
                [
                    'name' => 'Asep Saefullah',
                    'phone' => '082122334455',
                    'email' => 'asep.s@gmail.com',
                    'purpose' => 'info',
                    'message' => 'Apakah melayani drop-off sampai Bandara Kertajati Majalengka?',
                    'status' => 'replied',
                    'created_at' => Carbon::now()->subDay(),
                ],
            ];

            foreach ($contacts as $c) {
                Contact::create($c);
            }
        }
    }
}

