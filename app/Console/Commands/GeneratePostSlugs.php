<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Str;

class GeneratePostSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for posts that don\'t have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postsWithoutSlugs = Post::whereNull('slug')->orWhere('slug', '')->get();

        if ($postsWithoutSlugs->isEmpty()) {
            $this->info('All posts already have slugs.');
            return 0;
        }

        $this->info("Found {$postsWithoutSlugs->count()} posts without slugs. Generating...");

        foreach ($postsWithoutSlugs as $post) {
            $baseSlug = Str::slug($post->title);
            $slug = $baseSlug;
            $counter = 1;

            // Ensure slug is unique
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $post->update(['slug' => $slug]);
            $this->line("Generated slug for '{$post->title}': {$slug}");
        }

        $this->info('All post slugs generated successfully!');
        return 0;
    }
}
