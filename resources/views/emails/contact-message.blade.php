<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.New Contact Message') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="color: #333; margin-top: 0;">{{ __('messages.New Contact Message') }}</h2>
    </div>

    <div style="background-color: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <p><strong>{{ __('form.Name') }}:</strong> {{ $contactMessage->name }}</p>
        <p><strong>{{ __('form.Email') }}:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
        <p><strong>{{ __('common.Date') }}:</strong> {{ $contactMessage->created_at->format('d.m.Y H:i') }}</p>
        
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
            <p><strong>{{ __('form.Message') }}:</strong></p>
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; white-space: pre-wrap;">{{ $contactMessage->message }}</div>
        </div>
    </div>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666; text-align: center;">
        <p>{{ __('messages.This is an automated message from the contact form.') }}</p>
    </div>
</body>
</html>

