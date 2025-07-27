<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;

class CheckUserPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user-post {username} {slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if a user and post exist in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');
        $slug = $this->argument('slug');

        $this->info("Checking for username: {$username}");
        $user = User::where('username', $username)->first();

        if ($user) {
            $this->info("✓ User found: {$user->name} (ID: {$user->id})");
        } else {
            $this->error("✗ User not found with username: {$username}");
            $this->info("Available users:");
            User::select('username', 'name', 'id')->get()->each(function ($u) {
                $this->line("  - {$u->username} ({$u->name})");
            });
        }

        $this->info("Checking for post slug: {$slug}");
        $post = Post::where('slug', $slug)->first();

        if ($post) {
            $this->info("✓ Post found: {$post->title} (ID: {$post->id}, User ID: {$post->user_id})");
            $postUser = $post->user;
            if ($postUser) {
                $this->info("  Post belongs to: {$postUser->username} ({$postUser->name})");
                if ($user && $postUser->id === $user->id) {
                    $this->info("✓ User and post match!");
                } else {
                    $this->error("✗ User and post do not match!");
                }
            }
        } else {
            $this->error("✗ Post not found with slug: {$slug}");
            $this->info("Available post slugs:");
            Post::select('slug', 'title', 'user_id')->get()->each(function ($p) {
                $this->line("  - {$p->slug} ({$p->title})");
            });
        }

        return 0;
    }
}
