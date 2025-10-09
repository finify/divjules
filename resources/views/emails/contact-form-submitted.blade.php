<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            background: linear-gradient(135deg, #9333ea 0%, #4f46e5 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .field {
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #9333ea;
        }
        .field-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .field-value {
            color: #111827;
            font-size: 16px;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: #9333ea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">New Contact Form Submission</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">You have received a new message from your website</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value">{{ $contactMessage->full_name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $contactMessage->email }}" style="color: #9333ea;">{{ $contactMessage->email }}</a>
            </div>
        </div>

        @if($contactMessage->phone)
        <div class="field">
            <div class="field-label">Phone</div>
            <div class="field-value">
                <a href="tel:{{ $contactMessage->phone }}" style="color: #9333ea;">{{ $contactMessage->phone }}</a>
            </div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Country</div>
            <div class="field-value">{{ ucfirst($contactMessage->country) }}</div>
        </div>

        <div class="field">
            <div class="field-label">Interested In</div>
            <div class="field-value">{{ ucfirst(str_replace('_', ' ', $contactMessage->interest)) }}</div>
        </div>

        <div style="margin-top: 20px;">
            <div class="field-label" style="margin-bottom: 10px;">Message</div>
            <div class="message-box">{{ $contactMessage->message }}</div>
        </div>

        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/admin/contact-messages/{{ $contactMessage->id }}/edit" class="button">
                View in Admin Panel
            </a>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from your website contact form.</p>
        <p>Submitted on {{ $contactMessage->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>
