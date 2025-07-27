<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

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
        $userName = $isAuthenticated ? Auth::user()->name : 'there';

        // Greeting responses
        if ($this->matchesPattern($lowerMessage, ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'])) {
            return $this->getGreetingResponse($userName, $isAuthenticated);
        }

        // Help responses
        if ($this->matchesPattern($lowerMessage, ['help', 'what can you do', 'assist', 'support'])) {
            return $this->getHelpResponse($isAuthenticated);
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
            return $this->getCategoryHelpResponse();
        }

        // Engagement features
        if ($this->matchesPattern($lowerMessage, ['clap', 'like', 'applause', 'appreciation', 'react'])) {
            return $this->getClapHelpResponse($isAuthenticated);
        }

        // Technical support
        if ($this->matchesPattern($lowerMessage, ['error', 'bug', 'problem', 'issue', 'not working', 'broken'])) {
            return $this->getTechnicalSupportResponse();
        }

        // Goodbye responses
        if ($this->matchesPattern($lowerMessage, ['bye', 'goodbye', 'see you', 'thanks', 'thank you'])) {
            return $this->getGoodbyeResponse($userName);
        }

        // Default response
        return $this->getDefaultResponse($userMessage, $isAuthenticated);
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
     * Get greeting response
     */
    private function getGreetingResponse(string $userName, bool $isAuthenticated): string
    {
        $greetings = [
            "Hello {$userName}! 👋 I'm your AI assistant. How can I help you today?",
            "Hi {$userName}! Great to see you. What would you like to know about?",
            "Hey {$userName}! I'm here to help with any questions about the platform."
        ];

        if (!$isAuthenticated) {
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
    private function getHelpResponse(bool $isAuthenticated): string
    {
        if ($isAuthenticated) {
            return "I'm here to help! Here's what I can assist you with:\n\n" .
                "📝 **Posts**: Create, edit, manage your posts\n" .
                "👤 **Profile**: Update your profile and settings\n" .
                "👥 **Following**: Connect with other users\n" .
                "👏 **Engagement**: Clap for posts you enjoy\n" .
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
    private function getCategoryHelpResponse(): string
    {
        return "🗂️ **Categories & Discovery**:\n\n" .
            "• **Browse by Category**: Use category tabs to filter content\n" .
            "• **Discover New Content**: Explore different topics\n" .
            "• **Follow Interests**: Find authors in your areas of interest\n" .
            "• **Organized Content**: Posts are organized by topic for easy browsing\n\n" .
            "What type of content are you interested in?";
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
     * Get technical support response
     */
    private function getTechnicalSupportResponse(): string
    {
        return "🔧 **Technical Support**:\n\n" .
            "I'm sorry you're experiencing issues! Here are some quick fixes:\n\n" .
            "• **Refresh the page** - This solves many temporary issues\n" .
            "• **Clear browser cache** - Sometimes cached data causes problems\n" .
            "• **Check your internet connection** - Ensure you're connected\n" .
            "• **Try a different browser** - This can help identify browser-specific issues\n\n" .
            "If the problem persists, please describe what specifically isn't working and I'll try to help further!";
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
    private function getDefaultResponse(string $userMessage, bool $isAuthenticated): string
    {
        $suggestions = $isAuthenticated ?
            "posts, profile management, following users, or clapping for content" :
            "browsing posts, creating an account, or learning about our platform";

        return "I understand you're asking about: \"{$userMessage}\"\n\n" .
            "I'm still learning, but I'm here to help with {$suggestions}. " .
            "Could you be more specific about what you'd like to know? For example:\n\n" .
            "• \"How do I create a post?\"\n" .
            "• \"How do I follow someone?\"\n" .
            "• \"How do I update my profile?\"\n\n" .
            "Just ask me anything! 😊";
    }
}
