<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'image_alt',
        'image_caption',
        'status',
        'published_at',
        'reading_time',
        'views_count',
        'focus_keyword',
        'seo_title',
        'meta_description',
        'canonical_url',
        'seo_score',
        'readability_score',
        'is_indexed',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_indexed' => 'boolean',
        'reading_time' => 'integer',
        'views_count' => 'integer',
    ];

    public static array $categories = [
        'Wisata Cirebon' => 'Wisata Cirebon & Sekitarnya',
        'Tips Rental' => 'Tips & Panduan Rental',
        'Panduan Otomotif' => 'Perawatan & Info Kendaraan',
        'Info Layanan' => 'Layanan & Promo RentGo',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Auto generate slug if empty
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
            
            // Auto generate Smart Focus Keyword if empty
            if (empty($post->focus_keyword)) {
                $post->focus_keyword = static::extractSmartFocusKeyword($post->title);
            }

            // Auto generate optimal SEO Title if empty
            if (empty($post->seo_title)) {
                $post->seo_title = static::generateOptimalSeoTitle($post->title, $post->focus_keyword);
            }

            // Auto generate optimal Meta Description if empty
            if (empty($post->meta_description)) {
                $post->meta_description = static::generateOptimalMetaDescription($post->content, $post->focus_keyword, $post->title);
            }

            // Auto generate Excerpt if empty
            if (empty($post->excerpt)) {
                $post->excerpt = $post->meta_description;
            }

            // Auto generate Image Alt if empty
            if (empty($post->image_alt)) {
                $post->image_alt = $post->title . ' - ' . ($post->focus_keyword ?: 'rental mobil cirebon');
            }

            // Auto calculate reading time
            if (empty($post->reading_time)) {
                $post->reading_time = static::estimateReadingTime($post->content);
            }

            // Auto calculate SEO score if not explicitly set
            if (empty($post->seo_score) || $post->seo_score === 'ok') {
                $post->seo_score = static::calculateAutoSeoScore($post);
            }

            // Manage published_at
            if ($post->status === 'published' && empty($post->published_at)) {
                $post->published_at = now();
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('content') && empty($post->reading_time)) {
                $post->reading_time = static::estimateReadingTime($post->content);
            }
            if (empty($post->focus_keyword)) {
                $post->focus_keyword = static::extractSmartFocusKeyword($post->title);
            }
            if (empty($post->seo_title)) {
                $post->seo_title = static::generateOptimalSeoTitle($post->title, $post->focus_keyword);
            }
            if (empty($post->meta_description)) {
                $post->meta_description = static::generateOptimalMetaDescription($post->content, $post->focus_keyword, $post->title);
            }
            if (empty($post->image_alt)) {
                $post->image_alt = $post->title . ' - ' . ($post->focus_keyword ?: 'rental mobil cirebon');
            }
            if ($post->isDirty('status') && $post->status === 'published' && empty($post->published_at)) {
                $post->published_at = now();
            }
        });

        static::saved(function () {
            rescue(fn () => \Illuminate\Support\Facades\Artisan::call('sitemap:generate'));
        });

        static::deleted(function () {
            rescue(fn () => \Illuminate\Support\Facades\Artisan::call('sitemap:generate'));
        });
    }

    public static function extractSmartFocusKeyword(string $title): string
    {
        $clean = strtolower($title);
        $knownPhrases = [
            'rental mobil cirebon',
            'sewa mobil cirebon',
            'wisata cirebon',
            'lepas kunci cirebon',
            'stasiun cirebon',
            'wisata kuningan ciremai',
            'wisata kuningan',
            'wisata majalengka',
            'perawatan mobil matic',
            'rental mobil avanza',
            'rental mobil innova',
            'rental mobil',
            'sewa mobil',
        ];

        foreach ($knownPhrases as $phrase) {
            if (str_contains($clean, $phrase)) {
                return $phrase;
            }
        }

        // Clean punctuation and filter stop words
        $stopWords = ['di', 'dan', 'yang', 'untuk', 'ke', 'dari', 'ini', 'itu', 'pada', 'dengan', 'oleh', 'saat', 'cara', 'tips', 'panduan', 'lengkap', 'terbaru', '2026', '2025'];
        $words = preg_split('/\s+/', preg_replace('/[^\w\s]/', '', $clean));
        $filtered = array_values(array_filter($words, fn($w) => !in_array($w, $stopWords) && strlen($w) > 2));

        if (count($filtered) >= 2) {
            return $filtered[0] . ' ' . $filtered[1];
        } elseif (count($filtered) === 1) {
            return $filtered[0];
        }

        return 'rental mobil cirebon';
    }

    public static function generateOptimalSeoTitle(string $title, ?string $keyword = null): string
    {
        $base = trim($title);
        $brand = ' - RentGo Cirebon';

        if (mb_strlen($base . $brand) <= 65) {
            return $base . $brand;
        }

        return Str::limit($base, 45, '...') . $brand;
    }

    public static function generateOptimalMetaDescription(string $content, ?string $keyword = null, ?string $title = null): string
    {
        // Replace HTML tags with spaces so headings don't stick to paragraphs
        $spaced = preg_replace('/<[^>]+>/', ' ', $content);
        $clean = trim(preg_replace('/\s+/', ' ', $spaced));
        
        $kw = $keyword ?: 'rental mobil Cirebon';

        if (empty($clean)) {
            return "Panduan terlengkap seputar {$kw} terpercaya dari RentGo Indonesia. Dapatkan armada prima, verifikasi instan, dan gratis antar stasiun Cirebon.";
        }

        // If clean content already has between 120 and 155 chars
        if (mb_strlen($clean) <= 155 && mb_strlen($clean) >= 120) {
            return $clean;
        }

        // Extract around 140 chars ending cleanly at sentence or word
        $cut = mb_substr($clean, 0, 150);
        $lastPeriod = mb_strrpos($cut, '.');
        if ($lastPeriod !== false && $lastPeriod > 95) {
            return mb_substr($cut, 0, $lastPeriod + 1);
        }

        $lastSpace = mb_strrpos($cut, ' ');
        if ($lastSpace !== false && $lastSpace > 100) {
            return mb_substr($cut, 0, $lastSpace) . '...';
        }

        return Str::limit($clean, 150, '...');
    }

    public static function calculateAutoSeoScore(Post $post): string
    {
        $wordCount = str_word_count(strip_tags($post->content));
        $hasKeywordInTitle = !empty($post->focus_keyword) && str_contains(strtolower($post->seo_title_display), strtolower($post->focus_keyword));
        $hasKeywordInDesc = !empty($post->focus_keyword) && str_contains(strtolower($post->meta_description_display), strtolower($post->focus_keyword));
        
        if ($wordCount >= 150 && ($hasKeywordInTitle || $hasKeywordInDesc)) {
            return 'good';
        }
        if ($wordCount >= 50) {
            return 'ok';
        }
        return 'bad';
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    public static function estimateReadingTime(?string $content): int
    {
        if (empty($content)) {
            return 1;
        }
        $words = str_word_count(strip_tags($content));
        return max(1, (int) ceil($words / 200));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeCategory($query, ?string $category)
    {
        if (!empty($category) && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            return $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('excerpt', 'like', "%{$term}%")
                  ->orWhere('content', 'like', "%{$term}%")
                  ->orWhere('focus_keyword', 'like', "%{$term}%");
            });
        }
        return $query;
    }

    /**
     * Get display SEO Title (with fallback to title + branding)
     */
    public function getSeoTitleDisplayAttribute(): string
    {
        if (!empty($this->seo_title)) {
            return $this->seo_title;
        }
        return $this->title . ' - RentGo Cirebon';
    }

    /**
     * Get display Meta Description (with fallback to excerpt or content)
     */
    public function getMetaDescriptionDisplayAttribute(): string
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }
        $raw = $this->excerpt ?: strip_tags($this->content);
        return Str::limit(trim(preg_replace('/\s+/', ' ', $raw)), 155);
    }

    /**
     * Get Featured Image URL with fallback
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
        }
        return asset('assets/og_image.jpg');
    }

    /**
     * Helper for Yoast SEO score pill display
     */
    public function getSeoScoreDetailsAttribute(): array
    {
        $score = strtolower($this->seo_score ?? 'ok');
        return match ($score) {
            'good' => [
                'label' => 'Baik (Good)',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'dot_class' => 'bg-emerald-500',
                'color' => '#10b981',
                'icon' => 'fa-circle-check',
            ],
            'bad' => [
                'label' => 'Perlu Perbaikan (Needs Work)',
                'badge_class' => 'bg-rose-50 text-rose-700 border-rose-200',
                'dot_class' => 'bg-rose-500',
                'color' => '#ef4444',
                'icon' => 'fa-circle-exclamation',
            ],
            default => [
                'label' => 'Cukup (OK)',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200',
                'dot_class' => 'bg-amber-500',
                'color' => '#f59e0b',
                'icon' => 'fa-circle-dot',
            ],
        };
    }
}
