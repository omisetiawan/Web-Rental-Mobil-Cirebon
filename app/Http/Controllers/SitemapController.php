<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Car;
use App\Models\Post;

class SitemapController extends Controller
{
    /**
     * Generate and serve XML sitemap dynamically in real-time from the database
     */
    public function index(): Response
    {
        $xml = $this->buildSitemapXml();

        // Also keep a static copy in public/ for web servers (Nginx/Apache)
        @file_put_contents(public_path('sitemap.xml'), $xml);

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }

    /**
     * Build the dynamic sitemap XML string directly from database & routes
     */
    public function buildSitemapXml(): string
    {
        $sitemap = Sitemap::create();

        // 1. Dynamic Core Landing Pages (using Laravel route helpers)
        $sitemap->add(Url::create(route('landing.home'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setLastModificationDate(now()));

        $sitemap->add(Url::create(route('landing.pricing'))
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setLastModificationDate(now()));

        $sitemap->add(Url::create(route('landing.about'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setLastModificationDate(now()));

        $sitemap->add(Url::create(route('landing.contact'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setLastModificationDate(now()));

        $sitemap->add(Url::create(route('landing.blog.index'))
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setLastModificationDate(now()));

        // 2. Dynamic Published Blog Posts from DB
        Post::where('status', 'published')
            ->where('is_indexed', true)
            ->orderBy('published_at', 'desc')
            ->get()
            ->each(function (Post $post) use ($sitemap) {
                $lastMod = $post->updated_at ?? $post->published_at ?? $post->created_at ?? now();
                $sitemap->add(Url::create(route('landing.blog.show', $post->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($lastMod));
            });

        // 3. Dynamic Active Fleet Cars from DB
        Car::whereNull('deleted_at')
            ->orderBy('id', 'asc')
            ->get()
            ->each(function (Car $car) use ($sitemap) {
                $lastMod = $car->updated_at ?? $car->created_at ?? now();
                $sitemap->add(Url::create(route('landing.detail', $car->id))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($lastMod));
            });

        return $sitemap->render();
    }
}
