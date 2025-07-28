<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Website Feedback',
            'message' => 'Great website! I love the design and functionality. The user interface is very intuitive and the content is well organized.',
            'status' => 'new',
        ]);

        Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'subject' => 'Bug Report',
            'message' => 'I found a small issue with the contact form validation. When I submit an empty form, the error messages are not displaying correctly.',
            'status' => 'new',
        ]);

        Contact::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@example.com',
            'subject' => 'Feature Request',
            'message' => 'Would it be possible to add a dark mode to the website? I spend a lot of time reading articles and it would be easier on the eyes.',
            'status' => 'read',
        ]);

        Contact::create([
            'name' => 'Sarah Wilson',
            'email' => 'sarah@example.com',
            'subject' => 'Partnership Inquiry',
            'message' => 'Hello, I represent a tech company and we would like to discuss potential partnership opportunities with your platform.',
            'status' => 'new',
        ]);
    }
}
