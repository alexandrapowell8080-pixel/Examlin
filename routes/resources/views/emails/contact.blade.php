<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 600px; }
        .header { background: #f8f9fa; padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd; margin-bottom: 15px; }
        .data-row { margin-bottom: 10px; }
        .label { font-weight: bold; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">New Contact Form Submission</div>
        
        <div class="data-row">
            <span class="label">Name:</span> {{ $formData['name'] }}
        </div>
        <div class="data-row">
            <span class="label">Email:</span> {{ $formData['email'] }}
        </div>
        <div class="data-row">
            <span class="label">Subject:</span> {{ $formData['subject'] }}
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <div class="label" style="margin-bottom: 10px;">Message:</div>
        <div>
            {!! nl2br(e($formData['message'])) !!}
        </div>
    </div>
</body>
</html>