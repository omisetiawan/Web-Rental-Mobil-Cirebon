<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Wisata Cirebon');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_caption')->nullable();
            $table->enum('status', ['published', 'draft', 'archived'])->default('published');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('reading_time')->default(3);
            $table->unsignedBigInteger('views_count')->default(0);

            // YOAST SEO Standards Fields
            $table->string('focus_keyword')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('seo_score')->default('ok'); // good, ok, bad
            $table->string('readability_score')->default('ok'); // good, ok, bad
            $table->boolean('is_indexed')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
