<div class="row row-collapse align-middle mobile-menu default-bg mobile-fixed-menu">
    <div class="col small-2 medium-2 large-2">
        <div class="col-inner text-center">
            <button type="button" class="btn btn-light btn-mobile-menu" data-bs-toggle="modal"
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
                <a href="./guest/login" class="user__mobile"></a>
        </div>
    </div>
</div>
<div class="modal fade" id="mobileMenuModal" tabindex="-1" aria-labelledby="mobileMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <?php
                $option_model->the_logo($getconfig, 'logo_mobile', 'logo_mobile_height');
                ?>
            </div>
            <div class="modal-body mobile-show-menu">
                <div class="content__menu-mobile"></div>
                <?php
//                $menu_model->the_menu('top2-menu', 'main-nav-menu mobile-nav-menu');
                if (!empty($session_data) && isset($session_data['userID']) && $session_data['userID'] > 0) {
                    $menu_model->the_menu('top-profile-menu', 'top-login-menu');
                } else {
                    $menu_model->the_menu('top-login-menu');
                }
                ?>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Đóng</button>-->
<!--            </div>-->
        </div>
    </div>
</div>
