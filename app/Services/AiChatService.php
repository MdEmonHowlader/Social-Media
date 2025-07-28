<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AiChatService
{
    /**
     * Generate AI response based on user message
     */
    public function generateResponse(string $userMessage): string
    {
        $lowerMessage = strtolower(trim($userMessage));

        // Context-aware responses based on authentication status
        $isAuthenticated = Auth::check();
        /** @var User|null $user */
        $user = Auth::user();
        $isAdmin = $isAuthenticated && $user instanceof User && $user->isAdmin();
        $userName = $isAuthenticated && $user ? $user->name : 'there';

        // Admin-specific queries (only for admins)
        if ($isAdmin) {
            // Admin dashboard queries
            if ($this->matchesPattern($lowerMessage, ['dashboard', 'admin dashboard', 'stats', 'statistics', 'overview'])) {
                return $this->getAdminDashboardResponse();
            }

            // User management queries
            if ($this->matchesPattern($lowerMessage, ['users', 'user management', 'manage users', 'user list', 'total users'])) {
                return $this->getUserManagementResponse();
            }

            // Category management queries
            if ($this->matchesPattern($lowerMessage, ['manage categories', 'category management', 'add category', 'edit category', 'delete category'])) {
                return $this->getCategoryManagementResponse();
            }

            // Contact management queries
            if ($this->matchesPattern($lowerMessage, ['contacts', 'contact management', 'manage contacts', 'contact messages', 'contact replies'])) {
                return $this->getContactManagementResponse();
            }

            // Image management queries
            if ($this->matchesPattern($lowerMessage, ['images', 'image management', 'manage images', 'upload images', 'admin images'])) {
                return $this->getImageManagementResponse();
            }

            // Notification management queries
            if ($this->matchesPattern($lowerMessage, ['notifications', 'send notifications', 'notification management', 'broadcast', 'announcement'])) {
                return $this->getNotificationManagementResponse();
            }

            // Admin system queries
            if ($this->matchesPattern($lowerMessage, ['admin features', 'admin help', 'what can I do as admin', 'admin capabilities'])) {
                return $this->getAdminHelpResponse();
            }
        }

        // Greeting responses
        if ($this->matchesPattern($lowerMessage, ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'])) {
            return $this->getGreetingResponse($userName, $isAuthenticated, $isAdmin);
        }

        // Help responses
        if ($this->matchesPattern($lowerMessage, ['help', 'what can you do', 'assist', 'support'])) {
            return $this->getHelpResponse($isAuthenticated, $isAdmin);
        }

        // Post-related queries
        if ($this->matchesPattern($lowerMessage, ['post', 'create post', 'write', 'publish', 'article', 'blog'])) {
            return $this->getPostHelpResponse($isAuthenticated);
        }

        // Profile-related queries
        if ($this->matchesPattern($lowerMessage, ['profile', 'account', 'settings', 'edit profile', 'update profile'])) {
            return $this->getProfileHelpResponse($isAuthenticated);
        }

        // Following/followers queries
        if ($this->matchesPattern($lowerMessage, ['follow', 'following', 'followers', 'connect', 'network'])) {
            return $this->getFollowHelpResponse($isAuthenticated);
        }

        // Authentication queries
        if ($this->matchesPattern($lowerMessage, ['login', 'sign in', 'register', 'sign up', 'account', 'password'])) {
            return $this->getAuthHelpResponse($isAuthenticated);
        }

        // Categories and browsing
        if ($this->matchesPattern($lowerMessage, ['category', 'categories', 'browse', 'explore', 'discover', 'find'])) {
            return $this->getCategoryHelpResponse($isAdmin);
        }

        // Engagement features
        if ($this->matchesPattern($lowerMessage, ['clap', 'like', 'applause', 'appreciation', 'react'])) {
            return $this->getClapHelpResponse($isAuthenticated);
        }

        // Comments queries
        if ($this->matchesPattern($lowerMessage, ['comment', 'comments', 'commenting', 'reply', 'discussion'])) {
            return $this->getCommentsHelpResponse($isAuthenticated);
        }

        // Notifications queries
        if ($this->matchesPattern($lowerMessage, ['notification', 'notifications', 'alerts', 'updates'])) {
            return $this->getNotificationsHelpResponse($isAuthenticated, $isAdmin);
        }

        // Technical support
        if ($this->matchesPattern($lowerMessage, ['error', 'bug', 'problem', 'issue', 'not working', 'broken'])) {
            return $this->getTechnicalSupportResponse($isAdmin);
        }

        // Goodbye responses
        if ($this->matchesPattern($lowerMessage, ['bye', 'goodbye', 'see you', 'thanks', 'thank you'])) {
            return $this->getGoodbyeResponse($userName);
        }

        // Default response
        return $this->getDefaultResponse($userMessage, $isAuthenticated, $isAdmin);
    }

    /**
     * Check if message matches any of the patterns
     */
    private function matchesPattern(string $message, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_contains($message, $pattern)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get admin dashboard response
     */
    private function getAdminDashboardResponse(): string
    {
        return "🎛️ **Admin Dashboard Overview**:\n\n" .
            "• **Access Dashboard**: Go to `/admin/dashboard` or click Admin in navigation\n" .
            "• **User Statistics**: View total users, admins, and new registrations\n" .
            "• **Content Stats**: See total posts, categories, and engagement metrics\n" .
            "• **Contact Messages**: Monitor new contact submissions\n" .
            "• **Image Library**: Check total uploaded admin images\n" .
            "• **System Health**: Overview of platform activity\n\n" .
            "The dashboard provides real-time statistics and quick access to all admin features!";
    }

    /**
     * Get user management response
     */
    private function getUserManagementResponse(): string
    {
        return "👥 **User Management**:\n\n" .
            "• **View All Users**: Browse complete user list with roles\n" .
            "• **Admin Privileges**: Grant or revoke admin access\n" .
            "• **User Statistics**: See total users vs admins\n" .
            "• **User Activity**: Monitor user engagement and posts\n" .
            "• **Account Management**: Handle user account issues\n\n" .
            "💡 **Pro Tip**: Use the artisan command `php artisan user:make-admin {email}` to promote users!";
    }

    /**
     * Get category management response
     */
    private function getCategoryManagementResponse(): string
    {
        return "🗂️ **Category Management**:\n\n" .
            "• **Create Categories**: Add new content categories\n" .
            "• **Edit Categories**: Update existing category names\n" .
            "• **Delete Categories**: Remove unused categories (only if no posts)\n" .
            "• **View Statistics**: See post count per category\n" .
            "• **Organize Content**: Help users find relevant content\n\n" .
            "📍 **Access**: Admin → Categories or `/admin/categories`\n\n" .
            "Categories help organize and filter content for better user experience!";
    }

    /**
     * Get contact management response
     */
    private function getContactManagementResponse(): string
    {
        return "📧 **Contact Management**:\n\n" .
            "• **View Messages**: See all contact form submissions\n" .
            "• **Status Management**: Mark as new, read, replied, or closed\n" .
            "• **Reply System**: Respond directly to user inquiries\n" .
            "• **Search & Filter**: Find messages by status, name, or content\n" .
            "• **Email Integration**: Automatic email replies to users\n\n" .
            "📍 **Access**: Admin → Contacts or `/admin/contacts`\n\n" .
            "Stay connected with your community and provide excellent support!";
    }

    /**
     * Get image management response
     */
    private function getImageManagementResponse(): string
    {
        return "🖼️ **Image Management**:\n\n" .
            "• **Upload Images**: Add images for admin use (up to 10MB)\n" .
            "• **Organize by Category**: Sort images into categories\n" .
            "• **Edit Metadata**: Update titles, descriptions, and alt text\n" .
            "• **Search Images**: Find images by title or description\n" .
            "• **Delete Images**: Remove unused images from storage\n\n" .
            "📍 **Access**: Admin → Images or `/admin/images`\n\n" .
            "Supported formats: JPEG, PNG, JPG, GIF, SVG";
    }

    /**
     * Get notification management response
     */
    private function getNotificationManagementResponse(): string
    {
        return "🔔 **Notification Management**:\n\n" .
            "• **Send Announcements**: Broadcast to all users\n" .
            "• **System Notifications**: Important platform updates\n" .
            "• **User Targeting**: Send to specific user groups\n" .
            "• **Notification History**: Track sent notifications\n" .
            "• **Delivery Stats**: Monitor notification engagement\n\n" .
            "📍 **Access**: Admin → Notifications or `/admin/notifications/send`\n\n" .
            "Keep your community informed with important updates and announcements!";
    }

    /**
     * Get admin help response
     */
    private function getAdminHelpResponse(): string
    {
        return "🛡️ **Admin Capabilities**:\n\n" .
            "**🎛️ Dashboard**: Real-time platform statistics\n" .
            "**👥 Users**: Manage user accounts and permissions\n" .
            "**🗂️ Categories**: Create and organize content categories\n" .
            "**📧 Contacts**: Handle user inquiries and support\n" .
            "**🖼️ Images**: Upload and manage admin image library\n" .
            "**🔔 Notifications**: Send announcements to users\n" .
            "**📊 Analytics**: Monitor platform health and usage\n\n" .
            "As an admin, you have full access to all platform features and management tools!";
    }

    /**
     * Get greeting response
     */
    private function getGreetingResponse(string $userName, bool $isAuthenticated, bool $isAdmin = false): string
    {
        if ($isAdmin) {
            $greetings = [
                "Hello Admin {$userName}! 👑 I'm your AI assistant with full platform access. How can I help you manage the platform today?",
                "Hi {$userName}! Great to see you in the admin panel. What administrative task can I assist you with?",
                "Hey Admin {$userName}! I'm here to help with user management, content moderation, and all admin features."
            ];
        } elseif ($isAuthenticated) {
            $greetings = [
                "Hello {$userName}! 👋 I'm your AI assistant. How can I help you today?",
                "Hi {$userName}! Great to see you. What would you like to know about?",
                "Hey {$userName}! I'm here to help with any questions about the platform."
            ];
        } else {
            $greetings = [
                "Hello! 👋 Welcome to our platform. I'm your AI assistant. How can I help you today?",
                "Hi there! I'm here to help you navigate our platform. What would you like to know?",
                "Hey! Welcome! I can help you with posts, profiles, and general platform questions."
            ];
        }

        return $greetings[array_rand($greetings)];
    }

    /**
     * Get help response
     */
    private function getHelpResponse(bool $isAuthenticated, bool $isAdmin = false): string
    {
        if ($isAdmin) {
            return "I'm here to help with everything! Here's what I can assist you with:\n\n" .
                "🛡️ **Admin Features**:\n" .
                "• Dashboard and statistics\n" .
                "• User and category management\n" .
                "• Contact and image management\n" .
                "• Notification system\n\n" .
                "👤 **Regular Features**:\n" .
                "• Posts, profiles, and following\n" .
                "• Comments and engagement\n" .
                "• Categories and browsing\n\n" .
                "Just ask me anything - I have access to all platform features!";
        } elseif ($isAuthenticated) {
            return "I'm here to help! Here's what I can assist you with:\n\n" .
                "📝 **Posts**: Create, edit, manage your posts\n" .
                "👤 **Profile**: Update your profile and settings\n" .
                "👥 **Following**: Connect with other users\n" .
                "👏 **Engagement**: Clap for posts you enjoy\n" .
                "💬 **Comments**: Participate in discussions\n" .
                "🔔 **Notifications**: Stay updated with alerts\n" .
                "🗂️ **Categories**: Browse posts by topic\n\n" .
                "Just ask me anything specific!";
        } else {
            return "I can help you with:\n\n" .
                "📖 **Browsing**: Explore posts and profiles\n" .
                "🔐 **Getting Started**: Sign up or log in\n" .
                "ℹ️ **Platform Info**: Learn how everything works\n" .
                "🗂️ **Categories**: Discover content by topic\n\n" .
                "Ready to join? I can guide you through registration!";
        }
    }

    /**
     * Get post-related help
     */
    private function getPostHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "📝 **Post Management Help**:\n\n" .
                "• **Create Post**: Click the 'Create Post' button in the navigation\n" .
                "• **Add Content**: Write your title, content, and select a category\n" .
                "• **Edit Posts**: Visit your profile to edit existing posts\n" .
                "• **Delete Posts**: Use the edit menu to remove posts\n" .
                "• **Categories**: Choose from available categories to organize your content\n\n" .
                "Need help with a specific post feature?";
        } else {
            return "To create and manage posts, you'll need to sign up for an account first. Once registered, you can:\n\n" .
                "• Write and publish posts\n" .
                "• Organize content by categories\n" .
                "• Edit and manage your content\n" .
                "• Build your audience\n\n" .
                "Would you like help getting started with registration?";
        }
    }

    /**
     * Get profile-related help
     */
    private function getProfileHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "👤 **Profile Management**:\n\n" .
                "• **Edit Profile**: Go to Profile → Settings to update your information\n" .
                "• **Change Password**: Update your password in the security section\n" .
                "• **View Your Posts**: Check your profile to see all your published content\n" .
                "• **Followers**: See who's following you and who you're following\n" .
                "• **Public Profile**: Your profile is visible to other users\n\n" .
                "What would you like to update?";
        } else {
            return "Create an account to get your own profile! With a profile you can:\n\n" .
                "• Showcase your posts and expertise\n" .
                "• Build a following of interested readers\n" .
                "• Connect with other users\n" .
                "• Track your content's performance\n\n" .
                "Ready to create your profile?";
        }
    }

    /**
     * Get following-related help
     */
    private function getFollowHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "👥 **Following & Networking**:\n\n" .
                "• **Follow Users**: Visit any profile and click 'Follow'\n" .
                "• **Discover Content**: Following helps personalize your feed\n" .
                "• **View Followers**: Check your profile to see your followers\n" .
                "• **Following List**: See who you're following in your profile\n" .
                "• **Unfollow**: Click 'Unfollow' on any profile you're following\n\n" .
                "Building connections helps you discover great content!";
        } else {
            return "Following is a great way to stay updated with your favorite authors! To follow users, you'll need to:\n\n" .
                "• Create an account first\n" .
                "• Browse user profiles\n" .
                "• Click 'Follow' on profiles you like\n" .
                "• Build your network of interesting content creators\n\n" .
                "Want to get started with an account?";
        }
    }

    /**
     * Get authentication help
     */
    private function getAuthHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "🔐 **Account Management**:\n\n" .
                "You're already logged in! You can:\n" .
                "• Update your password in Profile Settings\n" .
                "• Manage your account information\n" .
                "• Log out using the dropdown menu\n\n" .
                "Is there something specific you'd like to change?";
        } else {
            return "🔐 **Getting Started**:\n\n" .
                "• **Sign Up**: Create a new account to start posting\n" .
                "• **Log In**: Access your existing account\n" .
                "• **Reset Password**: Forgot your password? Use the reset link\n" .
                "• **Email Verification**: Check your email after signing up\n\n" .
                "Ready to join our community?";
        }
    }

    /**
     * Get category help
     */
    private function getCategoryHelpResponse(bool $isAdmin = false): string
    {
        $response = "🗂️ **Categories & Discovery**:\n\n" .
            "• **Browse by Category**: Use category tabs to filter content\n" .
            "• **Discover New Content**: Explore different topics\n" .
            "• **Follow Interests**: Find authors in your areas of interest\n" .
            "• **Organized Content**: Posts are organized by topic for easy browsing\n";

        if ($isAdmin) {
            $response .= "• **Admin Access**: Manage categories at `/admin/categories`\n";
        }

        $response .= "\nWhat type of content are you interested in?";

        return $response;
    }

    /**
     * Get clap/engagement help
     */
    private function getClapHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "👏 **Clapping & Engagement**:\n\n" .
                "• **Show Appreciation**: Clap for posts you enjoy\n" .
                "• **Support Authors**: Claps help authors know their content is valued\n" .
                "• **Easy to Use**: Just click the clap button on any post\n" .
                "• **Track Engagement**: See how many claps your posts receive\n\n" .
                "Spread the love with claps! 👏";
        } else {
            return "👏 **Engagement Features**:\n\n" .
                "Clapping is our way of showing appreciation for great content! To clap for posts, you'll need to:\n\n" .
                "• Create an account\n" .
                "• Log in to your account\n" .
                "• Browse posts and click the clap button\n\n" .
                "Ready to start engaging with the community?";
        }
    }

    /**
     * Get comments help response
     */
    private function getCommentsHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "💬 **Comments & Discussions**:\n\n" .
                "• **Join Conversations**: Comment on any post to share your thoughts\n" .
                "• **Engage with Authors**: Connect directly with content creators\n" .
                "• **Build Community**: Foster meaningful discussions\n" .
                "• **Get Notifications**: Receive alerts when others reply to your comments\n" .
                "• **Manage Comments**: Edit or delete your own comments\n\n" .
                "Comments help build a vibrant community around great content!";
        } else {
            return "💬 **Comments & Discussions**:\n\n" .
                "Comments allow for rich discussions around posts! To participate, you'll need to:\n\n" .
                "• Create an account first\n" .
                "• Log in to your account\n" .
                "• Browse posts and join conversations\n" .
                "• Share your thoughts and insights\n\n" .
                "Ready to join the discussion?";
        }
    }

    /**
     * Get notifications help response
     */
    private function getNotificationsHelpResponse(bool $isAuthenticated, bool $isAdmin = false): string
    {
        if ($isAdmin) {
            return "🔔 **Notifications (Admin)**:\n\n" .
                "**📨 Send Notifications**: Broadcast announcements to all users\n" .
                "**📊 Manage System**: Control platform-wide notifications\n" .
                "**📋 Monitor Activity**: Track notification delivery and engagement\n\n" .
                "**📱 Personal Notifications**: Also receive all regular user notifications\n" .
                "• New followers and comments\n" .
                "• Post engagement alerts\n" .
                "• Platform activity updates\n\n" .
                "Access admin notifications at `/admin/notifications/send`";
        } elseif ($isAuthenticated) {
            return "🔔 **Notifications & Updates**:\n\n" .
                "• **Stay Informed**: Get notified about new followers\n" .
                "• **Engagement Alerts**: Know when someone claps for your posts\n" .
                "• **Comment Notifications**: See when others comment on your content\n" .
                "• **System Updates**: Receive important platform announcements\n" .
                "• **Manage Preferences**: Control what notifications you receive\n\n" .
                "Check your notifications in the top navigation bar!";
        } else {
            return "🔔 **Notifications & Updates**:\n\n" .
                "Once you create an account, you'll receive notifications for:\n\n" .
                "• New followers and engagement\n" .
                "• Comments on your posts\n" .
                "• Important platform updates\n" .
                "• Community announcements\n\n" .
                "Stay connected with your audience and the platform!";
        }
    }

    /**
     * Get technical support response
     */
    private function getTechnicalSupportResponse(bool $isAdmin = false): string
    {
        $response = "🔧 **Technical Support**:\n\n" .
            "I'm sorry you're experiencing issues! Here are some quick fixes:\n\n" .
            "• **Refresh the page** - This solves many temporary issues\n" .
            "• **Clear browser cache** - Sometimes cached data causes problems\n" .
            "• **Check your internet connection** - Ensure you're connected\n" .
            "• **Try a different browser** - This can help identify browser-specific issues\n";

        if ($isAdmin) {
            $response .= "• **Check server logs** - Monitor Laravel logs for errors\n" .
                "• **Database status** - Verify database connectivity\n" .
                "• **Admin tools** - Use dashboard for system diagnostics\n";
        }

        $response .= "\nIf the problem persists, please describe what specifically isn't working and I'll try to help further!";

        return $response;
    }

    /**
     * Get goodbye response
     */
    private function getGoodbyeResponse(string $userName): string
    {
        $goodbyes = [
            "Goodbye {$userName}! Thanks for chatting. Feel free to come back anytime! 👋",
            "See you later {$userName}! I'm always here when you need help. 😊",
            "Thanks for the chat {$userName}! Have a great day and happy posting! ✨"
        ];

        return $goodbyes[array_rand($goodbyes)];
    }

    /**
     * Get default response
     */
    private function getDefaultResponse(string $userMessage, bool $isAuthenticated, bool $isAdmin = false): string
    {
        if ($isAdmin) {
            $suggestions = "admin dashboard, user management, categories, contacts, images, notifications, or any regular platform features";
        } elseif ($isAuthenticated) {
            $suggestions = "posts, profile management, following users, comments, notifications, or clapping for content";
        } else {
            $suggestions = "browsing posts, creating an account, or learning about our platform";
        }

        return "I understand you're asking about: \"{$userMessage}\"\n\n" .
            "I'm still learning, but I'm here to help with {$suggestions}. " .
            "Could you be more specific about what you'd like to know? For example:\n\n" .
            "• \"How do I create a post?\"\n" .
            "• \"How do I follow someone?\"\n" .
            "• \"How do I update my profile?\"\n" .
            ($isAdmin ? "• \"How do I manage users?\"\n• \"How do I send notifications?\"\n" : "") .
            "\nJust ask me anything! 😊";
    }
}
