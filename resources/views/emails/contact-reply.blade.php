<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reply_subject }}</title>
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

        .reply-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }

        .original-message {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>💬 Reply to Your Message</h1>
        <p>Thank you for contacting us. Here's our response to your inquiry.</p>
    </div>

    <div class="content">
        <div class="reply-box">
            <h3>Our Response</h3>
            <div style="margin-bottom: 15px;">
                {{ nl2br(e($reply_message)) }}
            </div>
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                <strong>Replied by:</strong> {{ $admin_name }}<br>
                <strong>Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
            </p>
        </div>

        <div class="original-message">
            <h4>Your Original Message</h4>
            <p><strong>Subject:</strong> {{ $contact->subject }}</p>
            <p><strong>Sent:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>
            <div style="margin-top: 10px;">
                {{ nl2br(e($contact->message)) }}
            </div>
        </div>

        <div class="footer">
            <p>If you have any follow-up questions, feel free to contact us again.</p>
            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
