<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Services\NotificationService;
use App\Notifications\SimpleNotification;
use App\Notifications\SystemNotification;
use App\Notifications\PostLikedNotification;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewFollowerNotification;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔔 Starting notification seeding...');
        
        // Get users and posts for notifications
        $users = User::all();
        $posts = Post::with('user')->get();
        $notificationService = new NotificationService();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Clear existing notifications for a fresh start
        DB::table('notifications')->truncate();
        $this->command->info('Cleared existing notifications');

        // 1. Create welcome notifications for all users
        $this->command->info('Creating welcome notifications...');
        foreach ($users as $user) {
            $user->notify(new SimpleNotification([
                'title' => 'Welcome to our platform!',
                'message' => 'Thank you for joining us, ' . $user->name . '. Explore all the amazing features we have to offer.',
                'action_url' => route('dashboard'),
                'icon' => 'user'
            ]));
        }

        // 2. Create system announcements
        $this->command->info('Creating system announcements...');
        $systemNotifications = [
            [
                'title' => 'New Feature Release',
                'message' => 'We\'ve just released a new notification system! Check it out and let us know what you think.',
                'action_url' => route('notifications.index'),
                'icon' => 'megaphone'
            ],
            [
                'title' => 'Scheduled Maintenance',
                'message' => 'We will be performing scheduled maintenance on Sunday from 2:00 AM to 4:00 AM EST. The platform may be temporarily unavailable.',
                'action_url' => route('contact.show'),
                'icon' => 'megaphone'
            ],
            [
                'title' => 'Community Guidelines Updated',
                'message' => 'We\'ve updated our community guidelines to ensure a better experience for everyone. Please take a moment to review them.',
                'action_url' => route('dashboard'),
                'icon' => 'megaphone'
            ]
        ];

        foreach ($systemNotifications as $notification) {
            foreach ($users as $user) {
                $user->notify(new SystemNotification($notification));
            }
        }

        // 3. Create post-like notifications
        if (!$posts->isEmpty()) {
            $this->command->info('Creating post-like notifications...');
            foreach ($posts->take(5) as $post) {
                $randomUser = $users->where('id', '!=', $post->user_id)->random();
                $post->user->notify(new PostLikedNotification($post, $randomUser));
            }
        }

        // 4. Create comment notifications
        if (!$posts->isEmpty()) {
            $this->command->info('Creating comment notifications...');
            $comments = Comment::with(['post.user', 'user'])->get();
            
            if ($comments->isEmpty()) {
                // Create some sample comments for notifications
                foreach ($posts->take(3) as $post) {
                    $commenter = $users->where('id', '!=', $post->user_id)->random();
                    $comment = Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $commenter->id,
                        'content' => 'This is a great post! Thanks for sharing your insights.'
                    ]);
                    
                    $post->user->notify(new NewCommentNotification($comment, $post, $commenter));
                }
            } else {
                foreach ($comments->take(5) as $comment) {
                    if ($comment->post->user_id !== $comment->user_id) {
                        $comment->post->user->notify(new NewCommentNotification($comment, $comment->post, $comment->user));
                    }
                }
            }
        }

        // 5. Create follower notifications
        $this->command->info('Creating follower notifications...');
        foreach ($users->take(5) as $user) {
            $followers = $users->where('id', '!=', $user->id)->random(min(3, $users->count() - 1));
            foreach ($followers as $follower) {
                $user->notify(new NewFollowerNotification($follower));
            }
        }

        // 6. Create some general activity notifications
        $this->command->info('Creating activity notifications...');
        $activityNotifications = [
            [
                'title' => 'Your post is trending!',
                'message' => 'Your recent post has received a lot of engagement and is now trending on the platform.',
                'action_url' => $posts->isNotEmpty() ? route('post.show', ['username' => $posts->first()->user->username, 'post' => $posts->first()->slug]) : route('dashboard'),
                'icon' => 'heart'
            ],
            [
                'title' => 'Weekly summary available',
                'message' => 'Your weekly activity summary is ready. See how your posts performed this week.',
                'action_url' => route('profile.edit'),
                'icon' => 'bell'
            ],
            [
                'title' => 'Complete your profile',
                'message' => 'Add a bio and profile picture to help others connect with you better.',
                'action_url' => route('profile.edit'),
                'icon' => 'user'
            ]
        ];

        foreach ($users->take(3) as $user) {
            foreach ($activityNotifications as $notification) {
                $user->notify(new SimpleNotification($notification));
            }
        }

        // 7. Create some unread notifications (mix of read and unread)
        $this->command->info('Setting some notifications as read...');
        $allNotifications = DB::table('notifications')->get();
        $toMarkAsRead = $allNotifications->random(min(30, $allNotifications->count()));
        
        foreach ($toMarkAsRead as $notification) {
            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['read_at' => now()->subDays(rand(1, 7))]);
        }

        // 8. Create time-distributed notifications
        $this->command->info('Creating time-distributed notifications...');
        $timeDistributedNotifications = [
            [
                'days_ago' => 1,
                'title' => 'Yesterday\'s highlights',
                'message' => 'Check out the most popular posts from yesterday that you might have missed.',
                'icon' => 'bell'
            ],
            [
                'days_ago' => 3,
                'title' => 'Friend joined the platform',
                'message' => 'Someone you might know just joined the platform. Check out their profile!',
                'icon' => 'user'
            ],
            [
                'days_ago' => 7,
                'title' => 'Weekly achievements',
                'message' => 'Congratulations! You\'ve been active for a whole week. Keep up the great work!',
                'icon' => 'heart'
            ]
        ];

        foreach ($users->take(2) as $user) {
            foreach ($timeDistributedNotifications as $notification) {
                $createdAt = now()->subDays($notification['days_ago']);
                
                DB::table('notifications')->insert([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'type' => SimpleNotification::class,
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $user->id,
                    'data' => json_encode([
                        'title' => $notification['title'],
                        'message' => $notification['message'],
                        'action_url' => route('dashboard'),
                        'icon' => $notification['icon'],
                        'type' => 'simple'
                    ]),
                    'read_at' => rand(0, 1) ? $createdAt->addHours(rand(1, 24)) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ]);
            }
        }

        // Display final statistics
        $stats = $notificationService->getNotificationStats();
        $this->command->info('');
        $this->command->info('📊 Notification Seeding Complete!');
        $this->command->info('==============================');
        $this->command->info("Total notifications created: {$stats['total_notifications']}");
        $this->command->info("Unread notifications: {$stats['unread_notifications']}");
        $this->command->info("Notifications created today: {$stats['notifications_today']}");
        $this->command->info("Notifications created this week: {$stats['notifications_this_week']}");
        $this->command->info('');
        $this->command->info('✅ Sample notifications have been created for all users!');
        $this->command->info('🔗 Visit /notifications to see them in action.');
    }
}
