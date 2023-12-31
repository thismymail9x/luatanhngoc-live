<?php 
?> 
<link rel="stylesheet" href="./thirdparty/Nestable/style.css" /> 
<!--[if lt IE 9]> 
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> 
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> 
<![endif]--> 
<div class="container container-edit-menu"> 
<ol class="dd-tmp-list hide-if-edit-menu"> 
<li data-class="%dd-item%" data-id="%id%" data-name="%name%" data-slug="%slug%" data-target="" data-rel="" data-custom-css="" data-new="0" data-deleted="0"> 
<div data-class="%dd-handle%">%newText%</div> 
<span data-class="%button-delete%" data-owner-id="%id%"> <i data-class="%fa-times%" aria-hidden="true"></i> </span> <span data-class="%button-edit%" data-owner-id="%id%"> <i data-class="%fa-pencil%" aria-hidden="true"></i> </span> %child_htm% 
</li> 
</ol> 
<div class="cf"> 
<div class="lf f50 fullsize-if-mobile"> 
<h3>Menu</h3> 
<div class="dd nestable hide-if-edit-menu"> 
<ol class="dd-list"> 
<li class="dd-item" data-id="1" data-name="Item 1" data-slug="item-slug-1" data-new="0" data-deleted="0"> 
<div class="dd-handle">Item 1</div> 
<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="1"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span> <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="1"> <i class="fa fa-pencil" aria-hidden="true"></i> </span> 
</li> 
<li class="dd-item" data-id="2" data-name="Item 2" data-slug="item-slug-2" data-new="0" data-deleted="0"> 
<div class="dd-handle">Item 2</div> 
<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="2"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span> <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="2"> <i class="fa fa-pencil" aria-hidden="true"></i> </span> 
</li> 
<li class="dd-item" data-id="3" data-name="Item 3" data-slug="item-slug-3" data-new="0" data-deleted="0"> 
<div class="dd-handle">Item 3</div> 
<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="3"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span> <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="3"> <i class="fa fa-pencil" aria-hidden="true"></i> </span> 
<ol class="dd-list"> 
<li class="dd-item" data-id="4" data-name="Item 4" data-slug="item-slug-4" data-new="0" data-deleted="0"> 
<div class="dd-handle">Item 4</div> 
<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="4"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span> <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="4"> <i class="fa fa-pencil" aria-hidden="true"></i> </span> 
</li> 
<li class="dd-item" data-id="5" data-name="Item 5" data-slug="item-slug-5" data-new="0" data-deleted="0"> 
<div class="dd-handle">Item 5</div> 
<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="5"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </span> <span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="5"> <i class="fa fa-pencil" aria-hidden="true"></i> </span> 
</li> 
</ol> 
</li> 
</ol> 
</div> 
<br> 
<div onclick="return restore_json_menu_in_html_menu();" class="cur greencolor bold">* Khôi phục lại mã JSON cho menu từ HTML menu (dùng khi JSON menu bị lỗi mà HTML không lỗi).</div> 
</div> 
<div class="lf f50 fullsize-if-mobile menu-edit-input"> 
<div class="left-menu-space"> 
<form class="form-inline" onSubmit="return get_json_add_menu(this);" id="menu-add"> 
<h3>Thêm menu</h3> 
<div> 
<div class="form-group"> 
<label for="addInputName">Thêm nhanh</label> 
<select id="quick_add_menu"> 
<option value="">[ Thêm nhanh menu ]</option> 
<?php 
$quick_menu_list = $post_model->get_site_inlink($data['lang_key']); 
?> 
<option ng-repeat="v in quick_menu_list" ng-value="v.value" ng-disabled="v.selectable" ng-class="v.class">{{v.text}}</option> 
</select> 
</div> 
</div> 
<div> 
<div class="form-group"> 
<label for="addInputName">Tên menu</label> 
<input type="text" class="form-control" id="addInputName" placeholder="Item name" required> 
</div> 
</div> 
<div> 
<div class="form-group"> 
<label for="addInputSlug">Đường dẫn</label> 
<input type="text" class="form-control" id="addInputSlug" placeholder="Item slug" aria-required="true" required> 
</div> 
</div> 
<div> 
<button type="submit" class="btn btn-info" id="addButton"><i class="fa fa-plus"></i> Thêm mới</button> 
</div> 
</form> 
<form class="hide-if-edit-menu" onSubmit="return get_json_edit_menu(this);" id="menu-editor"> 
<h3>Chỉnh sửa: <span id="currentEditName"></span></h3> 
<div class="form-group"> 
<label for="addInputName">Tên menu</label> 
<input type="text" class="form-control" id="editInputName" placeholder="Item name" required> 
</div> 
<div> 
<div class="form-group"> 
<label for="addInputSlug">Đường dẫn</label> 
<input type="text" class="form-control" id="editInputSlug" placeholder="Item slug" aria-required="true" required> 
</div> 
</div> 
<div> 
<button type="submit" class="btn btn-info" id="editButton"><i class="fa fa-save"></i> Cập nhật</button> 
<button type="button" onclick="$('#menu-editor').fadeOut();" class="btn btn-danger" id="editButton"><i class="fa fa-close"></i> Hủy bỏ</button> 
</div> 
</form> 
</div> 
</div> 
</div> 
<div class="output-container hide-if-edit-menu"> 
<h2 class="text-center">Output:</h2> 
<form class="form"> 
<textarea class="form-control" id="json-output" rows="5" style="width: 100%;"></textarea> 
</form> 
</div> 
</div> 
<br> 
<?php 
$base_model->add_js('admin/js/add_edit_menu_v2.js'); 
?> 
<script src="./thirdparty/Nestable/jquery.nestable.js"></script> 
<script src="./thirdparty/Nestable/jquery.nestable++.js"></script> 
<?php 
$base_model->add_js('admin/js/add_edit_menu_v2_footer.js');
