<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f5; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding:20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" max-width="480" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="padding:32px 24px; text-align:center; background-color:#2563eb;">
                            <h1 style="margin:0; color:#ffffff; font-size:22px;">Verify Your Identity</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 24px;">
                            <p style="margin:0 0 16px; color:#27272a; font-size:16px;">Hello,</p>
                            <p style="margin:0 0 24px; color:#52525b; font-size:15px; line-height:1.5;">
                                Use the following one-time password (OTP) to complete your verification.
                                This code will expire shortly, so please use it soon.
                            </p>
                            <div style="text-align:center; margin:0 0 24px;">
                                <span style="display:inline-block; letter-spacing:8px; font-size:32px; font-weight:bold; color:#111827; background-color:#f4f4f5; padding:16px 24px; border-radius:8px;">
                                    {{ $otp }}
                                </span>
                            </div>
                            <p style="margin:0; color:#71717a; font-size:13px;">
                                If you did not request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px; text-align:center; background-color:#fafafa; color:#a1a1aa; font-size:12px;">
                            &copy; {{ date('Y') }} OptimaSync. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
