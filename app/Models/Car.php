<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand',
        'model',
        'category',
        'plate_number',
        'year',
        'price_per_day',
        'status',
        'color',
        'fuel_type',
        'transmission',
        'seat_capacity',
        'image',
        'images'
    ];

    /**
     * Get category with automatic smart detection fallback if not explicitly stored
     */
    public function getCategoryAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }

        $modelLower = strtolower($this->model . ' ' . $this->brand);
        if (str_contains($modelLower, 'alphard') || str_contains($modelLower, 'civic') || str_contains($modelLower, 'camry') || str_contains($modelLower, 'mercedes')) {
            return 'Luxury / VIP';
        }
        if (str_contains($modelLower, 'fortuner') || str_contains($modelLower, 'pajero') || str_contains($modelLower, 'hr-v') || str_contains($modelLower, 'rush') || str_contains($modelLower, 'terios')) {
            return 'SUV Premium';
        }
        if (str_contains($modelLower, 'brio') || str_contains($modelLower, 'yaris') || str_contains($modelLower, 'agya') || str_contains($modelLower, 'ayla')) {
            return 'City Car';
        }
        return 'MPV Family';
    }

    protected $casts = [
        'price_per_day' => 'integer',
        'seat_capacity' => 'integer',
        'images' => 'array'
    ];

    /**
     * Relationships
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Accessors - SIMPLIFIED & FIXED
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} ({$this->year})";
    }

    public function getCleanYearRangeAttribute(): string
    {
        return $this->cleanYearFormat($this->year);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_day, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        $statuses = [
            'available' => ['label' => '✓ Tersedia', 'class' => 'success'],
            'rented' => ['label' => '⏱ Sedang Disewa', 'class' => 'warning'],
            'maintenance' => ['label' => '🔧 Maintenance', 'class' => 'danger']
        ];

        $status = $statuses[$this->status] ?? ['label' => $this->status, 'class' => 'secondary'];

        return '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>';
    }

    /**
     * FIXED: Simple and reliable image URL accessor
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            // Approach 1: Check if it's already a full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            // Approach 2: Try Storage URL first (Laravel default)
            try {
                if (Storage::disk('public')->exists($this->image)) {
                    return Storage::disk('public')->url($this->image);
                }
            } catch (\Exception $e) {
                // Continue to next approach
            }

            // Approach 3: Try with cars/ prefix
            try {
                if (Storage::disk('public')->exists('cars/' . $this->image)) {
                    return Storage::disk('public')->url('cars/' . $this->image);
                }
            } catch (\Exception $e) {
                // Continue to next approach
            }

            // Approach 4: Try asset URL (for public storage)
            $assetPath = 'storage/' . $this->image;
            if (file_exists(public_path($assetPath))) {
                return asset($assetPath);
            }

            // Approach 5: Try with cars/ prefix in asset
            $assetCarsPath = 'storage/cars/' . $this->image;
            if (file_exists(public_path($assetCarsPath))) {
                return asset($assetCarsPath);
            }
        }

        // Smart model-based high-quality fallback for pristine UI presentation
        $name = strtolower(($this->brand ?? '') . ' ' . ($this->model ?? ''));
        if (str_contains($name, 'alphard')) {
            return 'https://images.unsplash.com/photo-1508974239320-0a029497e820?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($name, 'fortuner') || str_contains($name, 'pajero')) {
            return 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($name, 'innova')) {
            return 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($name, 'brio') || str_contains($name, 'yaris') || str_contains($name, 'agya')) {
            return 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($name, 'civic') || str_contains($name, 'camry') || str_contains($name, 'sedan')) {
            return 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($name, 'hr-v') || str_contains($name, 'rush') || str_contains($name, 'terios')) {
            return 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80';
        }

        return 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80';
    }

    /**
     * FIXED: Simple gallery URLs
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }

        $urls = [];
        $galleryImages = is_string($this->images) ? json_decode($this->images, true) : $this->images;

        if (!is_array($galleryImages)) {
            return [];
        }

        foreach ($galleryImages as $image) {
            if (!$image) continue;

            // Use the same logic as image_url
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $urls[] = $image;
                continue;
            }

            try {
                if (Storage::disk('public')->exists($image)) {
                    $urls[] = Storage::disk('public')->url($image);
                    continue;
                }
            } catch (\Exception $e) {}

            try {
                if (Storage::disk('public')->exists('cars/gallery/' . $image)) {
                    $urls[] = Storage::disk('public')->url('cars/gallery/' . $image);
                    continue;
                }
            } catch (\Exception $e) {}

            $assetPath = 'storage/' . $image;
            if (file_exists(public_path($assetPath))) {
                $urls[] = asset($assetPath);
                continue;
            }

            $assetGalleryPath = 'storage/cars/gallery/' . $image;
            if (file_exists(public_path($assetGalleryPath))) {
                $urls[] = asset($assetGalleryPath);
                continue;
            }
        }

        return $urls;
    }

    public function getGalleryCountAttribute(): int
    {
        if (!$this->images) {
            return 0;
        }

        $galleryImages = is_string($this->images) ? json_decode($this->images, true) : $this->images;
        return is_array($galleryImages) ? count($galleryImages) : 0;
    }

    /**
     * FIXED: Main image with proper fallback
     */
    public function getMainImageAttribute(): string
    {
        // Try image_url first
        if ($this->image_url) {
            return $this->image_url;
        }

        // Try first gallery image
        if (!empty($this->gallery_urls)) {
            return $this->gallery_urls[0];
        }

        // Final fallback - default car image
        return asset('images/default-car.jpg');
    }

    /**
     * Scopes
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function scopeRented(Builder $query): Builder
    {
        return $query->where('status', 'rented');
    }

    public function scopeMaintenance(Builder $query): Builder
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('brand', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhere('plate_number', 'like', "%{$search}%")
                ->orWhere('color', 'like', "%{$search}%");
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeWithImages(Builder $query): Builder
    {
        return $query->whereNotNull('image')->orWhereNotNull('images');
    }

    public function scopeWithoutImages(Builder $query): Builder
    {
        return $query->whereNull('image')->whereNull('images');
    }

    /**
     * Year Format Methods
     */
    private function cleanYearFormat($year): string
    {
        if (empty($year)) {
            $currentYear = date('Y');
            return $currentYear . ' - ' . $currentYear;
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

        $currentYear = date('Y');
        return $currentYear . ' - ' . $currentYear;
    }

    /**
     * Business Logic
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && !$this->trashed();
    }

    public function canBeRented(): bool
    {
        return $this->isAvailable() && $this->status !== 'maintenance';
    }

    public function activeBookings(): HasMany
    {
        return $this->bookings()->whereIn('status', ['pending', 'approved']);
    }

    public function hasImages(): bool
    {
        return !empty($this->image) || !empty($this->images);
    }

    public function hasGallery(): bool
    {
        return !empty($this->images) && count($this->images) > 0;
    }

    /**
     * Image Management Methods
     */
    public function deleteImage(): bool
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
            $this->update(['image' => null]);
            return true;
        }
        return false;
    }

    public function deleteGalleryImage(string $imagePath): bool
    {
        if ($this->images && in_array($imagePath, $this->images)) {
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $updatedImages = array_values(array_diff($this->images, [$imagePath]));
            $this->update(['images' => $updatedImages]);
            return true;
        }
        return false;
    }

    public function deleteAllImages(): void
    {
        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }
        if ($this->images) {
            foreach ($this->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $this->update([
            'image' => null,
            'images' => null
        ]);
    }

    /**
     * Check if car is available for given dates
     */
    public function isAvailableForDates($startDate, $endDate): bool
    {
        $conflictingBooking = $this->bookings()
            ->where('status', 'approved')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })->exists();

        return !$conflictingBooking && $this->isAvailable();
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Clean year format when creating/updating
        static::saving(function ($car) {
            $car->year = $car->cleanYearFormat($car->year);
        });

        // Delete images when car is deleted
        static::deleting(function ($car) {
            if ($car->isForceDeleting()) {
                $car->deleteAllImages();
            }
        });

        static::saved(function () {
            rescue(fn () => \Illuminate\Support\Facades\Artisan::call('sitemap:generate'));
        });

        static::deleted(function () {
            rescue(fn () => \Illuminate\Support\Facades\Artisan::call('sitemap:generate'));
        });
    }
}
