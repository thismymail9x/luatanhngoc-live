<div class="row row-collapse align-middle mobile-menu default-bg mobile-fixed-menu">
    <div class="col small-2 medium-2 large-2">
        <div class="col-inner text-center">
            <button type="button" class="btn text-light btn-mobile-menu" data-bs-toggle="modal"
                    data-bs-target="#mobileMenuModal" aria-label="Menu"><i class="fa fa-bars"></i></button>
        </div>
    </div>
    <div class="col small-8 medium-8 large-8">
        <div class="col-inner">
            <?php
            $option_model->the_logo($getconfig, 'logo_mobile', 'logo_mobile_height');
            ?>
        </div>
    </div>
    <div class="col small-2 medium-2 large-2 ">
        <div class="col-inner text-center mobile_user">
            <?php if (empty($session_data)) { ?>
            <a href="./guest/login" class="user__mobile"></a>
            <?php } else {?>
            <a href="./users/logout" class="user__logout"></a>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal fade" id="mobileMenuModal" tabindex="-1" aria-labelledby="mobileMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header row row-collapse  align-middle mobile-menu">
                <div class="col small-2 medium-2 large-2">
                    <div class="col-inner text-center">
                        <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="col small-8 medium-8 large-8">
                    <div class="col-inner">
                        <?php
                        $option_model->the_logo($getconfig, 'logo_mobile', 'logo_mobile_height');
                        ?>
                    </div>
                </div>
                <div class="col small-2 medium-2 large-2 ">
                    <div class="col-inner text-center mobile_user">
                        <?php if (empty($session_data)) { ?>
                            <a href="./guest/login" class="user__mobile"></a>
                        <?php } else {?>
                            <a href="./users/logout" class="user__logout"></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-body mobile-show-menu">

                <?php
                $menu_model->the_menu('top-nav-menu')
                ?>
                <?php
                if (!empty($session_data) && isset($session_data['userID']) && $session_data['userID'] > 0) {
                    if (isset($session_data['userLevel']) && $session_data['userLevel'] > 0) {
                        $menu_model->the_menu('top-admin-menu');
                    }
                    $menu_model->the_menu('top-profile-menu');
                } else {

                    $menu_model->the_menu('top-login-menu');
                }
                ?>

            </div>

            <div class="modal-footer">
                <a target="_blank" href="/" title="Đăng ký ộ công thương" class="dmca-badge">
                    <img style="height: 50px;width: 100%;"
                         src="<?= base_url() ?>upload/2023/09/dich-vu-thong-bao-bo-cong-thuong-removebg-preview-thumbnail.png"
                         alt="Đăng ký bộ công thương"/>
                </a>
                <a target="_blank"
                   href="https://www.dmca.com/Protection/Status.aspx?ID=64e71b30-ebd3-42bc-b908-4c0d404f0a0e&refurl=https://luatanhngoc.vn"
                   title="DMCA.com Protection Status" class="dmca-badge">
                    <img style="height: 30px;width: 100%;"
                         src="https://images.dmca.com/Badges/DMCA_logo-grn-btn120w.png?ID=64e71b30-ebd3-42bc-b908-4c0d404f0a0e"
                         alt="DMCA.com Protection Status"/>
                </a></div>
        </div>
    </div>
</div>
