<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة من نموذج التواصل</title>
    <style>
        body {
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #1B5E20;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-right: 3px solid #2E7D32;
        }
        .message-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-right: 3px solid #2E7D32;
            line-height: 1.6;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 رسالة جديدة من نموذج التواصل</h1>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="label">👤 الاسم:</span>
                <div class="value">{{ $name }}</div>
            </div>
            
            <div class="field">
                <span class="label">📧 البريد الإلكتروني:</span>
                <div class="value">{{ $email }}</div>
            </div>
            
            <div class="field">
                <span class="label">📱 الهاتف:</span>
                <div class="value">{{ $phone }}</div>
            </div>
            
            @if($company)
            <div class="field">
                <span class="label">🏢 الشركة:</span>
                <div class="value">{{ $company }}</div>
            </div>
            @endif
            
            <div class="field">
                <span class="label">💬 الرسالة:</span>
                <div class="message-box">{{ $message }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>تم إرسال هذه الرسالة من نموذج تواصل موقع الأرز للأعمال</p>
            <p>&copy; {{ date('Y') }} الأرز للأعمال - Rice B2B</p>
        </div>
    </div>
</body>
</html>
