# 🚗 Rental Mobil -- Laravel 12

Sistem manajemen rental mobil sederhana berbasis **Laravel 12** dengan
fitur CRUD mobil dan sistem booking offline.

## ⚙️ Fitur Utama

-   CRUD data mobil\
-   CRUD booking + perhitungan harga otomatis\
-   Status mobil (available / rented / maintenance)\
-   Status booking (pending / approved / rejected / completed)\
-   Relasi mobil--booking\
-   Tampilan admin ringan

## 📂 Struktur Database

### **1. Tabel `cars`**

``` php
Schema::create('cars', function (Blueprint $table) {
    $table->id();
    $table->string('brand');
    $table->string('model');
    $table->string('plate_number')->unique();
    $table->integer('year')->index();
    $table->decimal('price_per_day', 10, 2);
    $table->enum('status', ['available', 'rented', 'maintenance'])
        ->default('available')
        ->index();
    $table->timestamps();
});
```

### **2. Tabel `bookings`**

``` php
Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('car_id')->constrained()->restrictOnDelete();
    $table->string('customer_name');
    $table->string('customer_phone');
    $table->date('start_date');
    $table->date('end_date');
    $table->decimal('total_price', 12, 2);
    $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
        ->default('pending')
        ->index();
    $table->timestamps();
});
```

## 🛠️ Instalasi & Setup

### 1. Clone project

    git clone https://github.com/username/rental-mobil.git
    cd rental-mobil

### 2. Install dependency

    composer install
    npm install

### 3. Copy environment

    cp .env.example .env

### 4. Generate app key

    php artisan key:generate

### 5. Setup database di .env

    DB_DATABASE=rental_mobil
    DB_USERNAME=root
    DB_PASSWORD=

### 6. Jalankan migrasi

    php artisan migrate

### 7. Jalankan server

Backend:

    php artisan serve

Frontend:

    npm run dev

## 📁 Struktur Folder

    app/
     ├── Http/
     │    ├── Controllers/
     │    │     ├── CarController.php
     │    │     └── BookingController.php
    database/
     ├── migrations/
    resources/
     ├── views/
    routes/
     ├── web.php

## 📜 Lisensi

MIT License.
