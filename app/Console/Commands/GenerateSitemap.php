<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Car;
use App\Models\Post;

class GenerateSitemap extends Command
{
    /**
     * Nama command untuk dijalankan di terminal
     */
    protected $signature = 'sitemap:generate {--url= : Override domain URL dasar}';

    /**
     * Deskripsi command
     */
    protected $description = 'Generate sitemap.xml otomatis dari database untuk seluruh halaman publik';

    /**
     * Eksekusi logic sitemap
     */
    public function handle(): int
    {
        $baseUrl = rtrim($this->option('url') ?: config('app.url', url('/')), '/');

        $this->info("Menghasilkan sitemap dinamis dari database (Base URL: {$baseUrl})...");

        $sitemap = Sitemap::create();
        $count = 0;

        // 1. HALAMAN STATIS UTAMA
        $coreRoutes = [
            '/' => ['priority' => 1.0, 'freq' => Url::CHANGE_FREQUENCY_DAILY],
            '/pricing' => ['priority' => 0.9, 'freq' => Url::CHANGE_FREQUENCY_DAILY],
            '/about' => ['priority' => 0.8, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/contact' => ['priority' => 0.8, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/blog' => ['priority' => 0.9, 'freq' => Url::CHANGE_FREQUENCY_DAILY],
        ];

        foreach ($coreRoutes as $path => $meta) {
            $sitemap->add(Url::create("{$baseUrl}{$path}")
                ->setPriority($meta['priority'])
                ->setChangeFrequency($meta['freq'])
                ->setLastModificationDate(now()));
            $count++;
        }

        // 2. ARTIKEL BLOG DINAMIS DARI DATABASE (Published & Indexed)
        $posts = Post::where('status', 'published')
            ->where('is_indexed', true)
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            $lastMod = $post->updated_at ?? $post->published_at ?? $post->created_at ?? now();
            $sitemap->add(Url::create("{$baseUrl}/blog/{$post->slug}")
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($lastMod));
            $count++;
        }
        $this->info("- {$posts->count()} artikel blog terpublikasi otomatis ditambahkan.");

        // 3. UNIT ARMADA MOBIL DINAMIS DARI DATABASE
        $cars = Car::whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($cars as $car) {
            $lastMod = $car->updated_at ?? $car->created_at ?? now();
            $sitemap->add(Url::create("{$baseUrl}/car/{$car->id}")
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($lastMod));
            $count++;
        }
        $this->info("- {$cars->count()} unit armada mobil otomatis ditambahkan.");

        // 4. SIMPAN FILE
        $filePath = public_path('sitemap.xml');
        $sitemap->writeToFile($filePath);

        $this->info("✅ Sitemap berhasil di-generate secara otomatis! Total: {$count} URL di {$filePath}");

        return Command::SUCCESS;
    }
}