<!doctype html> 
<html lang="<?php 
echo (($html_lang == 'vn' || $html_lang == '') ? 'vi' : $html_lang); 
?>" data-lang="<?php echo $html_lang; ?>" data-default-lang="<?php echo SITE_LANGUAGE_DEFAULT; ?>" class="no-js no-svg" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"> 
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5681131500788092"
            crossorigin="anonymous"></script>
    <!-- Google anlatic (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WJHT5RKM95"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-WJHT5RKM95');
    </script>

    <!-- Histats.com  START  (aync)-->
    <script type="text/javascript">var _Hasync= _Hasync|| [];
        _Hasync.push(['Histats.start', '1,4805676,4,0,0,0,00010000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();</script>
    <noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4805676&101" alt="" border="0"></a></noscript>
    <!-- Histats.com  END  -->

<!--    Zalo-->
    <script async="" src="https://s.zzcdn.me/ztr/ztracker.js?id=7112644760908759040"></script>


    <!-- Google tag (gtag.js) -->
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11311324682"></script>-->
<!--    <script>-->
<!--        window.dataLayer = window.dataLayer || [];-->
<!--        function gtag(){dataLayer.push(arguments);}-->
<!--        gtag('js', new Date());-->
<!---->
<!--        gtag('config', 'AW-11311324682');-->
<!--    </script>-->

    <?php
 
require __DIR__ . '/includes/head_global.php'; 
?> 
<script> 
redirect_to_canonical('<?php echo $seo['body_class']; ?>'); 
</script> 
<?php 
if ($seo['body_class'] == 'home') { 
$lang_model->the_text('home_schema', '<!-- -->'); 
} 
if (isset($seo['dynamic_schema'])) { 
echo $seo['dynamic_schema']; 
} 
?>
    <link rel="preload" href="<?=base_url()?>themes/luatanhngoc/font/SF_Pro_Text/SF-Pro-Text-Regular.otf" as="font" type="font/otf" crossorigin="anonymous">

</head> 
<body data-session="<?php echo session_id(); ?>" class="page_light <?php echo $seo['body_class']; ?> is-<?php echo $current_user_type . ' ' . $current_user_logged; ?>">
<?php 
echo $header; 
echo $breadcrumb; 
include __DIR__ . '/includes/msg_view.php'; 
?> 
<main id="main" role="main"> 
<?php 
$theme_default_view = VIEWS_PATH . 'default/' . basename(__FILE__); 
include VIEWS_PATH . 'private_view.php'; 
?> 
</main> 
<?php 
echo $footer; 
require __DIR__ . '/includes/footer_global.php'; 
?> 
</body>
<!--<script type="text/javascript">-->
<!--    // theo dõi nút click liên hệ-->
<!--    $('.button-92').click(function () {-->
<!--        ttq.track('ClickButton');-->
<!--    })-->
<!--    // theo dõi đăng ký liên hệ-->
<!--    $('.js-delete-session').click(function () {-->
<!--        ttq.track('Contact')-->
<!--    })-->
<!--</script>-->
</html>
