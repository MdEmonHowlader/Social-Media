<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class FixPostImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:fix-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix broken post images by removing references to missing files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking post images...');

        $posts = Post::whereNotNull('image')->get();
        $brokenCount = 0;
        $fixedCount = 0;

        foreach ($posts as $post) {
            if ($post->image && !Storage::disk('public')->exists($post->image)) {
                $this->warn("Post ID {$post->id}: Image not found - {$post->image}");
                $brokenCount++;

                // Option to fix by setting image to null
                if ($this->confirm("Remove broken image reference for post '{$post->title}'?")) {
                    $post->update(['image' => null]);
                    $fixedCount++;
                    $this->info("Fixed post ID {$post->id}");
                }
            }
        }

        $this->info("Scan complete!");
        $this->info("Total posts with images: {$posts->count()}");
        $this->info("Broken image references: {$brokenCount}");
        $this->info("Fixed references: {$fixedCount}");

        return Command::SUCCESS;
    }
}
