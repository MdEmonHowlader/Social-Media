<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }

        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }

        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🔔 New Contact Message</h1>
        <p>You have received a new contact message from your website.</p>
    </div>

    <div class="content">
        <div class="message-box">
            <h3>Contact Details</h3>
            <p><strong>Name:</strong> {{ $contact->name }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Subject:</strong> {{ $contact->subject }}</p>
            <p><strong>Received:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>

            <h3>Message</h3>
            <div style="background: #fff; padding: 15px; border-radius: 6px; border: 1px solid #ddd;">
                {{ nl2br(e($contact->message)) }}
            </div>
        </div>

        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn">View & Reply in Admin Panel</a>

        <div class="footer">
            <p>This is an automated notification from your contact form.</p>
            <p>Please do not reply to this email directly. Use the admin panel to respond.</p>
        </div>
    </div>
</body>

</html>
