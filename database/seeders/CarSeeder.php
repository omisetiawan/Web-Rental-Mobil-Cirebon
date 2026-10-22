<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['brand'=>'Toyota','model'=>'Avanza','plate_number'=>'E 1234 AB','year'=>'2023','price_per_day'=>350000,'status'=>'available','color'=>'Putih','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Toyota','model'=>'Avanza','plate_number'=>'E 2345 BC','year'=>'2022','price_per_day'=>330000,'status'=>'available','color'=>'Hitam','fuel_type'=>'Bensin','transmission'=>'Manual','seat_capacity'=>7],
            ['brand'=>'Toyota','model'=>'Kijang Innova','plate_number'=>'E 4567 DE','year'=>'2023','price_per_day'=>550000,'status'=>'available','color'=>'Abu-abu','fuel_type'=>'Diesel','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Toyota','model'=>'Kijang Innova','plate_number'=>'E 5678 FG','year'=>'2021','price_per_day'=>480000,'status'=>'rented','color'=>'Silver','fuel_type'=>'Diesel','transmission'=>'Manual','seat_capacity'=>7],
            ['brand'=>'Honda','model'=>'Brio','plate_number'=>'E 6789 GH','year'=>'2023','price_per_day'=>320000,'status'=>'available','color'=>'Merah','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>5],
            ['brand'=>'Daihatsu','model'=>'Xenia','plate_number'=>'E 7890 IJ','year'=>'2022','price_per_day'=>340000,'status'=>'available','color'=>'Putih','fuel_type'=>'Bensin','transmission'=>'Manual','seat_capacity'=>7],
            ['brand'=>'Toyota','model'=>'Fortuner','plate_number'=>'E 8901 JK','year'=>'2023','price_per_day'=>850000,'status'=>'available','color'=>'Hitam','fuel_type'=>'Diesel','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Mitsubishi','model'=>'Pajero Sport','plate_number'=>'E 9012 KL','year'=>'2022','price_per_day'=>800000,'status'=>'maintenance','color'=>'Silver','fuel_type'=>'Diesel','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Suzuki','model'=>'Ertiga','plate_number'=>'E 0123 MN','year'=>'2023','price_per_day'=>350000,'status'=>'available','color'=>'Abu-abu','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Honda','model'=>'HR-V','plate_number'=>'E 1122 OP','year'=>'2023','price_per_day'=>450000,'status'=>'available','color'=>'Putih','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>5],
            ['brand'=>'Toyota','model'=>'Alphard','plate_number'=>'B 1234 RS','year'=>'2023','price_per_day'=>2500000,'status'=>'available','color'=>'Putih','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>7],
            ['brand'=>'Honda','model'=>'Civic','plate_number'=>'E 3344 TU','year'=>'2022','price_per_day'=>500000,'status'=>'rented','color'=>'Hitam','fuel_type'=>'Bensin','transmission'=>'Automatic','seat_capacity'=>5],
        ];

        foreach ($cars as $data) {
            Car::create($data);
        }
    }
}
