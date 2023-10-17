<?php
$base_model->add_css('themes/' . THEMENAME . '/css/contact.css', [
    'cdn' => CDN_BASE_URL,
]);
?>
<?php
$data['post_content'] = str_replace('][/i]', '></i>', $data['post_content']);
$data['post_content'] = str_replace('[i ', '<i ', $data['post_content']);
echo $data['post_content'];
?>
<div class="global-page-module w90 contact__base">
    <div class="padding-global-content cf ">
        <div class="col-main-content custom-width-global-main custom-width-page-main fullsize-if-mobile">
            <div class="col-main-padding col-page-padding">
                <div class="lien-he contact__form">
                    <h1 class="text-center mb-3"><?= $data['post_title'] ?></h1>

                    <div class="cf eb-contact-form">
                        <div class="lf f45 fullsize-if-mobile">
                            <div class="order-2 order-xl-1 left">
                                <p class="contact_title text-color">BIỂU PHÍ TƯ VẤN QUA EMAIL/GỌI ĐIỆN QUA ZALO</p>
                                <p style="text-align: center">Tham khảo tại : <a href="<?=base_url()?>/pages/bao-gia">Bảng giá</a></p>
                                <p><strong>1. Tư vấn qua email:</strong> Hỏi đáp của Luật sư sẽ được thể hiện bằng văn
                                    bản và gửi lại qua email cho khách hàng phí dịch vụ tối thiểu là<span
                                            class="span text-color"> 300.000 VNĐ/Email</span>
                                </p>
                                <p><strong>2. Tư vấn gọi điện qua Zalo:</strong> Khách hàng liên hệ trực tiếp với Zalo
                                    của Luật sư để được tư vấn phí dịch vụ<span
                                            class="text-color"> 100.000VND/20 phút</span>
                                </p>
                                <p><strong>3. Phí tư vấn xin gửi về:</strong></p>
                                <ul>
                                    <li>Chủ tài khoản: <span class="text-color"> Nguyễn Thị Phương</span>(Giám đốc công
                                        ty)
                                    </li>
                                    <li>Số tài khoản: <span class="text-color"> 14060886868</span></li>
                                    <li>Ngân hàng Quân Đội-MB bank-Chi nhánh Thanh Xuân</li>
                                    <li>Nội dung chuyển khoản: <span class="text-color"> Tư vấn Email/Zalo + Họ và tên + Số điện thoại</span>
                                    </li>
                                    <li>Sau khi đã gửi câu hỏi và thanh toán, vui lòng liên hệ với chúng tôi qua số
                                        Hotline tiếp nhận yêu cầu tư vấn pháp luật qua email: <a href="tel:0878548558"
                                                                                                 class="text-color">0878.548.558</a>
                                        để được xác nhận yêu cầu tư vấn và xác nhận đã nhận thanh toán. Luật sư sẽ tiếp
                                        nhận và tư vấn ngay sau khi bạn xác nhận thông tin thành công.
                                </ul>

                                </p>
                                <p><strong>4. (*)Những vụ việc phức tạp, mức phí có thể thay đổi phù hợp với thực tế sẽ
                                        được các luật sư thông báo sau khi tiếp nhận yêu cầu. </strong>
                                </p>
                            </div>
                        </div>

                        <div class="lf f55 fullsize-if-mobile">
                                <div class="col">
                                    <form name="contact_form" accept-charset="utf-8" action="./contact/put" method="post"
                                          target="target_eb_iframe">
                                        <?php $base_model->csrf_field(); ?>
                                        <input type="hidden" name="to" value="comments"/>
                                        <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                                        <div class="fullsize-if-mobile form-row">
                                            <div class="form-group col-md-6">
                                                <label class="label">Họ và tên:</label>
                                                <input type="search" name="data[fullname]" class="form-control" value=""
                                                       aria-required="true" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="label">Địa chỉ email:</label>
                                                <input type="email" name="data[email]" class="form-control" value=""
                                                       aria-required="true" required>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="label">Tiêu đề:</label>
                                            <input type="search" name="data[title]" class="form-control" value=""
                                                   aria-required="true" required>
                                        </div>
                                        <div class="fullsize-if-mobile">
                                            <div class="form-group">
                                                <label class="label">Dịch vụ đăng ký:</label>
                                                <textarea name="data[content]" class="form-control" rows="7"
                                                          aria-required="true" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" value="on" name="send_my_email"/>
                                                    Gửi một bản copy thông điệp này đến email của bạn</label>
                                            </div>
                                        </div>


                                        <div class="text-center eb-contact-form button__form">
                                            <button type="submit" class="button js-delete-session">
                                                <div class="icon-button"></div>
                                                GỬI</button>
                                        </div>
                                    </form>
                                </div>


                            </div>

                    </div>

                </div>
                <br/>
                <?php
                // html_for_fb_comment
                ?>
                <br>
                <div class="global-page-widget">
                    <?php
                    // str_for_details_sidebar
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sidebar-content custom-width-global-sidebar custom-width-page-sidebar fullsize-if-mobile">
            <div class="page-right-space global-right-space">
                <?php
                // str_sidebar
                ?>
            </div>
        </div>
    </div>
</div>