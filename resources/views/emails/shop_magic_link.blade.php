<!DOCTYPE html>
<html>
<head>
    <title>Magic Link for Login</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px;">
        <div style="text-align: center;">
            <img src="{{url('/images/logo.png')}}" alt="MyBill Logo" style="max-width: 200px; height: auto;">
        </div>
        <div style="padding: 40px; text-align: center; background-color: #ffffff;">
            <h2 style="color: #333333; font-size: 24px; margin-bottom: 20px;">Welcome to MyBill</h2>
            <p style="color: #666666; font-size: 16px; line-height: 24px;">Click the button below to log in to your account.</p>
            <a href="https://auth.mybill1.com?action={{$action}}&token={{$token}}" style="display: inline-block; color: #ffffff; background-color: #f90082; padding: 12px 24px; margin-top: 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Log In</a>
            <p style="color: #666666; font-size: 14px; line-height: 20px; margin-top: 20px;">If you did not request this email, please ignore it.</p>
        </div>
        <div style="text-align: center; padding: 20px; background-color: #f4f4f4; border-top: 1px solid #dddddd;">
            <p style="color: #666666; font-size: 12px;">&copy; {{ date('Y') }} MyBill. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
