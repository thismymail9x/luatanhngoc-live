<div title="Thay đổi trang thái bài viết">
    <select class="changePostStatus" :data-id="v.ID">
        <option :selected="v.post_status == key" v-for="(value, key) in PostType_arrStatus" :value="key">{{ value }}</option>
    </select>
</div>
<div >
    <span title="Tạo note cho bài viết" class="btn btn-sm " data-bs-toggle="modal" :data-whatever="v.post_title" data-bs-target="#noteModal" :data-id="v.ID" ><i class="fa fa-comment"></i></span>
    <a title="Xóa bài viết" v-if="v.post_status != PostType_DELETED && session_data == ADMIN_ROLE" :href="'admin/' + controller_slug + '/delete?id=' + v.ID + for_action" onClick="return click_a_delete_record();" class="redcolor btn btn-sm" target="target_eb_iframe"><i class="fa fa-trash"></i></a>
</div>

<div class="d-inlines" v-if="v.post_status == PostType_DELETED"> 
<div class="d-inline"><a :href="'admin/' + controller_slug + '/restore?id=' + v.ID + for_action" onClick="return click_a_restore_record();" class="bluecolor" target="target_eb_iframe"><i class="fa fa-undo"></i></a></div> 
&nbsp; 
<div class="d-inline"><a :href="'admin/' + controller_slug + '/remove?id=' + v.ID + for_action" onClick="return click_a_remove_record();" class="redcolor" target="target_eb_iframe"><i class="fa fa-remove"></i></a></div>

</div>


