/** FIle ch\u1ee9a function d\u00f9ng chung c\u1ee7a b\u1ea3ng posts*/function update_post_viewed(fview) {if (typeof post_id=="undefined"||typeof post_author=="undefined") {console.log("%c post_id OR post_author is undefined", "color: red");return false;}var k = "update_post_viewed" + post_id;var a = sessionStorage.getItem(k);if (a !== null) {if (WGR_config.cf_tester_mode > 0) {console.log("CANCEL by update-post-viewed:", a);}return false;}jQuery.ajax({type: "POST",url: "ajaxs/update_post_viewed",dataType: "json",data: {current_user_id: WGR_config.current_user_id,pid: post_id,post_author: post_author,fview: typeof fview=="number" ? fview : 1,},success: function (data) {if (WGR_config.cf_tester_mode > 0) {console.log("update-post-viewed:", data);}sessionStorage.setItem(k, Math.floor(Date.now() / 1000));},});}