
<div>
    <span v-if="v.post_status == PostType_PENDING" :data-title="v.post_title" title="Duyệt bài viết" :class="'ml-2 btn btn-sm btn-warning changePostStatus changePostStatus_'+v.ID" :data-id="v.ID" ><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
<!--    <span v-if="v.post_status == PostType_PENDING" :data-title="v.post_title" title="Check thông số bài viết" :class="'ml-2 btn btn-sm btn-primary checkPostInformation checkPostInformation_'+v.ID" :data-id="v.ID" ><i class="fa fa-info-circle" aria-hidden="true"></i></span>-->
    <span v-if="v.post_author != v.last_comment || v.last_comment == 0" title="Tạo note cho bài viết" class="ml-2 btn btn-sm btn-light" data-bs-toggle="modal" :data-whatever="v.post_title" data-bs-target="#noteModal" :data-id="v.ID" ><i class="fa fa-comment"></i></span>
    <span v-if="v.post_author == v.last_comment" title="Tác giả mới phản hồi" class="ml-2 btn btn-sm btn-success" data-bs-toggle="modal" :data-whatever="v.post_title" data-bs-target="#noteModal" :data-id="v.ID" ><i class="fa fa-exclamation" aria-hidden="true"></i></span>
    <a title="Xóa bài viết" v-if="v.post_status != PostType_DELETED && session_data == ADMIN_ROLE" :href="'admin/' + controller_slug + '/delete?id=' + v.ID + for_action" onClick="return click_a_delete_record();" class="redcolor btn btn-sm" target="target_eb_iframe"><i class="fa fa-trash"></i></a>
    <span v-if="v.post_status == PostType_PUBLIC" :data-title="v.post_title" title="Cập nhật lại KPI" :class="'ml-2 btn btn-sm changePostSalary changePostSalary_'+v.ID" :data-id="v.ID" ><i class="fa fa-money" aria-hidden="true"></i></span>
</div>

<div class="d-inlines" v-if="v.post_status == PostType_DELETED"> 
<div class="d-inline"><a :href="'admin/' + controller_slug + '/restore?id=' + v.ID + for_action" onClick="return click_a_restore_record();" class="bluecolor" target="target_eb_iframe"><i class="fa fa-undo"></i></a></div> 
&nbsp; 
<div class="d-inline"><a :href="'admin/' + controller_slug + '/remove?id=' + v.ID + for_action" onClick="return click_a_remove_record();" class="redcolor" target="target_eb_iframe"><i class="fa fa-remove"></i></a></div>

</div>


