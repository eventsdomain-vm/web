<?php
    $fbPixel = \App\Models\PlatformSetting::get('facebook_pixel_id');
    $clarityId = \App\Models\PlatformSetting::get('microsoft_clarity_id');
    $mapsKey = \App\Models\PlatformSetting::get('google_maps_api_key');
    $favicon = \App\Models\PlatformSetting::get('branding_favicon');
    $appleTouchIcon = \App\Models\PlatformSetting::get('branding_apple_touch_icon');
    $ogImage = \App\Models\PlatformSetting::get('branding_og_image');
?>

<?php if($favicon): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e(Storage::url($favicon)); ?>">
<?php endif; ?>
<?php if($appleTouchIcon): ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(Storage::url($appleTouchIcon)); ?>">
<?php endif; ?>
<?php if($ogImage): ?>
    <meta property="og:image" content="<?php echo e(Storage::url($ogImage)); ?>">
<?php endif; ?>
<?php if($mapsKey): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($mapsKey); ?>&libraries=places" defer></script>
<?php endif; ?>

<?php if($fbPixel): ?>
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo e($fbPixel); ?>');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo e($fbPixel); ?>&ev=PageView&noscript=1"/></noscript>
<?php endif; ?>

<?php if($clarityId): ?>
<script>
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "<?php echo e($clarityId); ?>");
</script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/partials/tracking-head.blade.php ENDPATH**/ ?>