<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts in the admin panel.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $status = $request->query('status');
        $seoScore = $request->query('seo_score');

        $query = Post::with('user')->latest();

        if (!empty($search)) {
            $query->search($search);
        }

        if (!empty($category) && $category !== 'all') {
            $query->where('category', $category);
        }

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (!empty($seoScore) && $seoScore !== 'all') {
            $query->where('seo_score', $seoScore);
        }

        $posts = $query->paginate(12)->withQueryString();

        // Calculate statistics for the top metrics cards
        $stats = [
            'total' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'seo_good' => Post::where('seo_score', 'good')->count(),
            'total_views' => Post::sum('views_count'),
        ];

        $categories = Post::$categories;

        return view('admin.posts.index', compact('posts', 'stats', 'categories', 'search', 'category', 'status', 'seoScore'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Post::$categories;
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url_input' => 'nullable|url|max:500',
            'image_alt' => 'nullable|string|max:255',
            'image_caption' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft,archived',
            'focus_keyword' => 'nullable|string|max:150',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'canonical_url' => 'nullable|url|max:255',
            'seo_score' => 'nullable|in:good,ok,bad',
            'readability_score' => 'nullable|in:good,ok,bad',
            'is_indexed' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['user_id'] = auth()->id();
        $data['is_indexed'] = $request->has('is_indexed') ? (bool) $request->input('is_indexed') : true;

        // Generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Post::generateUniqueSlug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle Image upload or URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('posts', 'public');
            $data['image'] = $path;
        } elseif (!empty($request->input('image_url_input'))) {
            $data['image'] = $request->input('image_url_input');
        }

        // Auto-Generate Yoast SEO fields if left empty by user
        if (empty($data['focus_keyword'])) {
            $data['focus_keyword'] = Post::extractSmartFocusKeyword($data['title']);
        }
        if (empty($data['seo_title'])) {
            $data['seo_title'] = Post::generateOptimalSeoTitle($data['title'], $data['focus_keyword']);
        }
        if (empty($data['meta_description'])) {
            $data['meta_description'] = Post::generateOptimalMetaDescription($data['content'], $data['focus_keyword'], $data['title']);
        }
        if (empty($data['excerpt'])) {
            $data['excerpt'] = $data['meta_description'];
        }
        if (empty($data['image_alt'])) {
            $data['image_alt'] = $data['title'] . ' - ' . $data['focus_keyword'];
        }

        // Calculate reading time
        $data['reading_time'] = Post::estimateReadingTime($data['content']);

        // Set published_at timestamp
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel "' . $post->title . '" berhasil diterbitkan dengan standar Yoast SEO!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = Post::$categories;
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_url_input' => 'nullable|url|max:500',
            'image_alt' => 'nullable|string|max:255',
            'image_caption' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft,archived',
            'focus_keyword' => 'nullable|string|max:150',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'canonical_url' => 'nullable|url|max:255',
            'seo_score' => 'nullable|in:good,ok,bad',
            'readability_score' => 'nullable|in:good,ok,bad',
            'is_indexed' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['is_indexed'] = $request->has('is_indexed') ? (bool) $request->input('is_indexed') : false;

        // Generate or normalize slug
        if (empty($data['slug'])) {
            $data['slug'] = Post::generateUniqueSlug($data['title'], $post->id);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle image upload replacement
        if ($request->hasFile('image_file')) {
            // Delete old file if stored locally in public disk
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image_file')->store('posts', 'public');
            $data['image'] = $path;
        } elseif (!empty($request->input('image_url_input'))) {
            $data['image'] = $request->input('image_url_input');
        }

        // Auto-Generate Yoast SEO fields if left empty by user
        if (empty($data['focus_keyword'])) {
            $data['focus_keyword'] = Post::extractSmartFocusKeyword($data['title']);
        }
        if (empty($data['seo_title'])) {
            $data['seo_title'] = Post::generateOptimalSeoTitle($data['title'], $data['focus_keyword']);
        }
        if (empty($data['meta_description'])) {
            $data['meta_description'] = Post::generateOptimalMetaDescription($data['content'], $data['focus_keyword'], $data['title']);
        }
        if (empty($data['excerpt'])) {
            $data['excerpt'] = $data['meta_description'];
        }
        if (empty($data['image_alt'])) {
            $data['image_alt'] = $data['title'] . ' - ' . $data['focus_keyword'];
        }

        // Calculate reading time
        $data['reading_time'] = Post::estimateReadingTime($data['content']);

        // Manage published_at
        if ($data['status'] === 'published' && empty($post->published_at)) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel "' . $post->title . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $title = $post->title;

        // Delete image file if stored locally
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel "' . $title . '" berhasil dihapus.');
    }
}
