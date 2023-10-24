<?php
$base_model->add_css('themes/' . THEMENAME . '/css/home.css', [
    'cdn' => CDN_BASE_URL,
]);
$base_model->add_css('themes/' . THEMENAME . '/css/our-story.css', [
    'cdn' => CDN_BASE_URL,
]);
$base_model->add_css('themes/' . THEMENAME . '/css/trial.css');
$base_model->add_css('themes/' . THEMENAME . '/plugins/aos/dist/aos.css');
$base_model->add_js('themes/' . THEMENAME . '/plugins/aos/dist/aos.js');

?>
<script>
    AOS.init({
        offset: 0,
        duration: 200,
        // delay: 200,
        once: true
    });
</script>
<?php
echo @$data['post_content'];
?>

<style>
    h2,h3 {
        margin-bottom: 0.5rem;
        color: var(--mainColor);
    }
    tbody, td, tfoot, th, thead, tr {
        border-width: 1px;
    }
    .global-page-module a {
        color: var(--mainColor) !important;
    }
</style>
