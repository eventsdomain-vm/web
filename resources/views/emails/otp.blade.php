<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background: linear-gradient(135deg, #c0392b, #e67e22); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Email Verification</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 16px; color: #333;">Hello <strong>{{ $user->name }}</strong>,</p>
                            <p style="font-size: 16px; color: #555; line-height: 1.6;">Your One-Time Password (OTP) for email verification is:</p>
                            <div style="text-align: center; margin: 30px 0;">
                                <span style="display: inline-block; font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #c0392b; background: #fdf2f2; padding: 15px 30px; border-radius: 8px;">{{ $code }}</span>
                            </div>
                            <p style="font-size: 14px; color: #888;">This code is valid for <strong>10 minutes</strong>.</p>
                            <hr style="border: none; border-top: 1px solid #eee; margin: 25px 0;">
                            <p style="font-size: 13px; color: #999;">If you did not request this code, please ignore this email.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f8f8f8; padding: 20px; text-align: center;">
                            <p style="font-size: 13px; color: #999; margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
