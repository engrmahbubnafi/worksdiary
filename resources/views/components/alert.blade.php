@props(['type', 'message'])

<div id="js_alert_div" {{ $attributes->merge(['class' => 'alert alert-' . $type]) }} role="alert"
    style="margin-top: -20px; text-align: center;">
    <div class="alert-text">{{ $message }}</div>
    <script>
        setTimeout(() => {
            $("#js_alert_div").remove();
        }, 10000);
    </script>
</div>
