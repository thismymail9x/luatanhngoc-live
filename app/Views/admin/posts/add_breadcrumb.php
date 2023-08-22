<ul class="admin-breadcrumb"> 
<li><a href="admin/<?php echo $controller_slug; ?>">Danh sách 
<?php echo $name_type; ?> 
</a></li> 
<li> 
<?php 
if ($data['ID'] > 0) { 
echo $data['post_title'] . ' | '; 
?> 
Chỉnh sửa 
<?php 
} else { 
?> 
Thêm mới 
<?php 
} 
echo $name_type; 
?> 
</li> 
</ul> 
<?php 
if ($auto_update_module > 0) { 
?> 
<p class="orgcolor text-center medium show-if-end-function">* Kích hoạt chức năng tự động cập nhật bài viết để nhận các 
tính mới...</p> 
<?php 
}
