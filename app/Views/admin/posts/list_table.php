<?php 
 
?> 
<table class="table table-bordered table-striped with-check table-list eb-table"> 
<thead> 
<tr> 
<th><input type="checkbox" class="input-checkbox-all" /></th> 
<th>Tiêu đề 
<?php echo $name_type; ?> 
</th> 
<th>Ảnh đại diện</th> 
<th>Danh mục</th> 
<th colspan="2">Ngày tạo/ <a :href="'admin/' + controller_slug + '?order_by=post_modified'">Cập nhật cuối <i class="fa fa-sort"></i></a></th>
    <th>Trạng thái</th>
    <th>STT</th>
<th>Thao tác</th>
</tr> 
</thead> 
<tbody id="admin_main_list"> 
<tr :data-id="v.ID" v-for="v,k in data">
<td width="50" class="text-center"><input type="checkbox" :value="v.ID" class="input-checkbox-control" /> 
</td> 
<td> 
<div><a :href="v.admin_permalink" class="bold">  {{ (currentPage - 1) * post_per_page + k + 1 }}. {{v.post_title}} <i class="fa fa-edit"></i></a></div>
<div><a :href="v.the_permalink" target="_blank" class="small blackcolor">{{v.the_permalink}} <i class="fa fa-eye"></i></a>
    <br>
    <span><i class="fa fa-user"></i> {{v.user_nicename}}</span>
</div>
</td> 
<td> 
<div class="img-max-width"> 
<a :href="v.admin_permalink" class="post-admin-thumbnail"><img :src="v.thumbnail" data-class="each-to-img-src" /></a> 
</div> 
</td> 
<td :data-id="v.main_category_key" :data-taxonomy="taxonomy" :data-uri="'admin/' + controller_slug" class="each-to-taxonomy">&nbsp;</td> 
<td>{{v.post_date.substr(0, 16)}}</td>
<td>{{v.post_modified.substr(0, 16)}}</td>
    <td :class="'post_status post_status-' + v.post_status +' post_'+v.ID">{{PostType_arrStatus[v.post_status]}}</td>
    <td width="60"><input type="number" :data-id="v.ID" :value="v.menu_order" size="5" class="form-control s change-update-menu_order" /></td>
<td width="200" class="text-center">
<?php 
include ADMIN_ROOT_VIEWS . 'posts/list_action.php'; 
?> 
</td> 
</tr> 
</tbody> 
</table>
