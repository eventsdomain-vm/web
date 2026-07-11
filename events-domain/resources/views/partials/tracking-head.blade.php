@php
    $fbPixel = \App\Models\PlatformSetting::get('facebook_pixel_id');
    $clarityId = \App\Models\PlatformSetting::get('microsoft_clarity_id');
    $mapsKey = \App\Models\PlatformSetting::get('google_maps_api_key');
    $favicon = \App\Models\PlatformSetting::get('branding_favicon');
    $appleTouchIcon = \App\Models\PlatformSetting::get('branding_apple_touch_icon');
    $ogImage = \App\Models\PlatformSetting::get('branding_og_image');
@endphp

@if($favicon)
    <link rel="icon" type="image/x-icon" href="{{ Storage::url($favicon) }}">
@endif
@if($appleTouchIcon)
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($appleTouchIcon) }}">
@endif
@if($ogImage)
    <meta property="og:image" content="{{ Storage::url($ogImage) }}">
@endif
@if($mapsKey)
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&libraries=places" defer></script>
@endif

@if($fbPixel)
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $fbPixel }}');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $fbPixel }}&ev=PageView&noscript=1"/></noscript>
@endif

@if($clarityId)
<script>
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "{{ $clarityId }}");
</script>
@endif
