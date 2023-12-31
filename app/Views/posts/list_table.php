<?php 
 
?> 
<table class="table table-bordered table-striped with-check table-list eb-table ">
<thead>
<tr class="data-table-header cursor-pointer">
<th>STT</th>
<th>Tiêu đề 
<?php echo $name_type; ?> 
</th> 
<th>Danh mục</th>
<th>Trạng thái</th> 
<th>Thao tác</th>
</tr> 
</thead>
<tbody id="admin_main_list"> 
<tr :data-id="v.ID" v-for="(v, k) in data">
</td>
    <td>
        {{ (currentPage - 1) * post_per_page + k + 1 }}
    </td>
<td> 
<div><a :href="v.admin_permalink" class="bold">{{v.post_title}} <i class="fa fa-edit"></i></a></div>
<div><a :href="v.the_permalink" target="_blank" class="small blackcolor">{{v.the_permalink}} <i class="fa fa-eye"></i></a></div>
    <div class="text-primary"><i class="fa fa-user"></i> {{v.user_nicename}}</div>

</td>
<td :data-id="v.main_category_key" :data-taxonomy="taxonomy"  class="each-to-taxonomy">&nbsp;</td>
<td :class="'post_status post_status-' + v.post_status">{{PostType_arrStatus[v.post_status]}}</td>
<td width="120" class="text-center align-items-center justify-content-center">
   <span v-if="v.post_status == draftStatus " title="Nhận bài viết" :class="'btn btn-sm btn-primary receivePost receivePost_'+v.ID"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span>
    <span v-if="v.post_author == v.last_comment || v.last_comment == 0" title="Tạo note cho bài viết" class="ml-2 btn btn-sm btn-secondary" data-bs-toggle="modal" :data-whatever="v.post_title" data-bs-target="#noteModal" :data-id="v.ID" ><i class="fa fa-comment"></i></span>
    <span v-if="v.post_author != v.last_comment && v.last_comment != 0" title="Có phản hồi mới" class="ml-2 btn btn-sm btn-warning" data-bs-toggle="modal" :data-whatever="v.post_title" data-bs-target="#noteModal" :data-id="v.ID" ><i class="fa fa-exclamation" aria-hidden="true"></i></span>
    <span v-if="v.post_status == privateStatus " title="Yêu cầu duyệt bài" :class="'btn btn-sm btn-success sendAccept sendAccept'+v.ID"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
</td>
</tr> 
</tbody> 
</table>
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Viết ghi chú cho bài viết</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" class="input_post_id">
                    <div class="form-group">
                        <label for="message-note" class="col-form-label">Nội dung:</label>
                        <textarea class="form-control" id="message-note"></textarea>
                    </div>
                </form>
                <p>Danh sách</p>
                <div class="list__note">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary saveNote">Lưu</button>
            </div>
        </div>
    </div>
</div>

