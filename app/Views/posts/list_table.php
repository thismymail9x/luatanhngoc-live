<?php 
 
?> 
<table class="table table-bordered table-striped with-check table-list eb-table ">
<thead>
<tr class="data-table-header cursor-pointer">
<th>Tiêu đề 
<?php echo $name_type; ?> 
</th> 
<th>Danh mục</th>
<th>Trạng thái</th> 
<th>Thao tác</th>
</tr> 
</thead>
<tbody id="admin_main_list"> 
<tr :data-id="v.ID" v-for="v in data">
</td> 
<td> 
<div><a :href="v.admin_permalink" class="bold">{{v.post_title}} <i class="fa fa-edit"></i></a></div>
<div><a :href="v.the_permalink" target="_blank" class="small blackcolor">{{v.the_permalink}} <i class="fa fa-eye"></i></a></div> 
</td>
<td :data-id="v.main_category_key" :data-taxonomy="taxonomy"  class="each-to-taxonomy">&nbsp;</td>
<td :class="'post_status post_status-' + v.post_status">{{PostType_arrStatus[v.post_status]}}</td>
<td width="100" class="text-center align-items-center justify-content-center">
   <span v-if="v.post_status == drafStatus " class="btn btn-sm btn-primary receivePost">Nhận viết</span>
</td> 
</tr> 
</tbody> 
</table>
