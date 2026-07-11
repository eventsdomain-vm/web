@php
    $siteKey = \App\Models\PlatformSetting::get('recaptcha_site_key');
    $secretKey = \App\Models\PlatformSetting::get('recaptcha_secret_key');
@endphp

@if($siteKey && $secretKey)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}" data-callback="recaptchaCallback"></div>
    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
    <script>
        function recaptchaCallback(token) {
            document.getElementById('recaptchaResponse').value = token;
        }
    </script>
    @error('g-recaptcha-response')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
@endif
