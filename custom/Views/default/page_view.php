<?php
$base_model->add_css('themes/' . THEMENAME . '/css/home.css', [
    'cdn' => CDN_BASE_URL,
]);

?>
<div class="global-page-module w90"> 
<div class="padding-global-content cf "> 
<div class="col-main-content custom-width-global-main custom-width-page-main fullsize-if-mobile"> 
<div class="col-main-padding col-page-padding"> 
<h1 data-type="<?php echo $data['post_type']; ?>" data-id="<?php echo $data['ID']; ?>" class="mb-3">
<?php 
echo $data['post_title']; 
?> 
</h1> 
<div class="img-max-width global-details-content <?php echo $data['post_type']; ?>-details-content ul-default-style">
<?php 
echo $data['post_content']; 
?> 
</div> 
<br /> 
<?php 
?> 
<br> 
<div class="global-page-widget"> 
<?php 
?> 
</div> 
</div> 
</div> 
<div class="col-sidebar-content custom-width-global-sidebar custom-width-page-sidebar fullsize-if-mobile"> 
<div class="page-right-space global-right-space"> 
<?php 
?> 
</div> 
</div> 
</div> 
</div>
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
