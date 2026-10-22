<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $currentCategory = $request->query('category', 'all');

        $query = Post::published()
            ->with('user')
            ->search($search)
            ->category($currentCategory)
            ->latest('published_at');

        // Top hero: Featured spotlight post + 4 Latest posts (Always present across pagination)
        $featuredPost = null;
        $latestPosts = collect();

        if (empty($search)) {
            $featuredPost = Post::published()->with('user')->latest('published_at')->first();
            
            $latestPosts = Post::published()
                ->with('user')
                ->when($featuredPost, function ($q) use ($featuredPost) {
                    return $q->where('id', '!=', $featuredPost->id);
                })
                ->latest('published_at')
                ->take(4)
                ->get();
        }

        // Exclude featured post from the grid when displayed in the hero spotlight
        $posts = (clone $query)
            ->when($featuredPost, function ($q) use ($featuredPost) {
                return $q->where('id', '!=', $featuredPost->id);
            })
            ->paginate(6)
            ->withQueryString();

        // Get category list with counts of published posts
        $categories = collect(Post::$categories)->mapWithKeys(function ($label, $key) {
            $count = Post::published()->where('category', $key)->count();
            return [$key => [
                'name' => $key,
                'label' => $label,
                'count' => $count
            ]];
        });

        $totalPublished = Post::published()->count();

        return view('landing.blog.index', compact(
            'posts',
            'featuredPost',
            'latestPosts',
            'categories',
            'currentCategory',
            'search',
            'totalPublished'
        ));
    }

    /**
     * Display the specified blog post with full Yoast SEO synchronization.
     */
    public function show(string $slug)
    {
        $post = Post::published()
            ->with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count safely using session throttle
        $viewSessionKey = 'post_viewed_' . $post->id;
        if (!Session::has($viewSessionKey)) {
            $post->increment('views_count');
            Session::put($viewSessionKey, now()->toDateTimeString());
        }

        // Fetch related posts (same category first, excluding current post)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $filler = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($filler);
        }

        return view('landing.blog.show', compact('post', 'relatedPosts'));
    }
}
