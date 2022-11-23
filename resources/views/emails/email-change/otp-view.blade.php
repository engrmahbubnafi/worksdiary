<div style="padding-left: 30px; padding-top: 30px;">
    Hi, <br><br>

    Your One Time Password (OTP) is: <h1>{{ $otp }}</h1>

    This OTP is valid for {{ Str::timeFormat(config('auth.password_timeout', 10800)) }}. Please do not share this OTP
    with anyone for security reasons. <br><br>

    Thanks, <br><br>

    WorksDiary
</div>
