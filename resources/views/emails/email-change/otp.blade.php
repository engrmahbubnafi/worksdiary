@component('mail::message')
    # @lang('Your One Time Password (OTP) is: ' . $data['data']['otp'])

    @lang('This OTP is valid for') {{ Str::timeFormat(config('auth.password_timeout', 10800)) }}. @lang('Please do not share this OTP with anyone for security reasons.')


    @lang('Thanks'),
    @lang('WorksDiary')
@endcomponent
