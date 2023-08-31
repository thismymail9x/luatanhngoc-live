<?php
$custom_code_model = new \App\Models\CustomCode();
if ($isMobile == true) {
    include VIEWS_CUSTOM_PATH . 'includes/header_mobile.php';
} else {

//


    ?>

    <div class="row row-collapse align-middle">
        <div class="col medium-2 small-12 large-2">
            <div class="col-inner">
                <?php
                $option_model->the_logo($getconfig);
                ?>
            </div>
        </div>
        <div class="col medium-2 small-12 large-2">
            <div class="col-inner top1-menu">
                <?php
                echo $custom_code_model->get_current_day();
                ?>
            </div>
        </div>
        <div class="col medium-3 small-12 large-3">
            <div class="col-inner top-search">
                <form method="get" action="search">
                    <input type="search" name="s" class="form-control inputSearch" value="" placeholder="Tìm kiếm"
                           onClick="this.select();" aria-required="true" required>
                    <button type="submit" class="btn btn-primary btnSearch" aria-label="Search button"><i
                                class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="col medium-5 small-12 large-5">
            <div class="col-inner top-user-menu cf">
                <?php

                // nếu đã đăng nhập -> hiển thị menu profile
                if (!empty($session_data) && isset($session_data['userID']) && $session_data['userID'] > 0) {
                    // hiển thị thêm menu cho admin
                    if (isset($session_data['userLevel']) && $session_data['userLevel'] > 0) {
                        $menu_model->the_menu('top-admin-menu');
                    }

                    //
                    $menu_model->the_menu('top-profile-menu');
                } // chưa thì hiển thị menu đăng nhập/ đăng ký
                else {
                    $menu_model->the_menu('top-login-menu');
                }

                ?>
            </div>
        </div>
    </div>
    <div class="bborder">
        <div class="main-menu header__navbar">
            <div class="row row-collapse">
                <div class="col medium-12 small-12 large-12">
                    <div class="col-inner main_nav">
                        <?php
                        $menu_model->the_menu('top-nav-menu')
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-more-menu">
            <div class="row row-collapse">
                <div class="col medium-12 small-12 large-12">
                    <div class="col-inner">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu__all">
        <div class="row row-collapse">
            <div class="col">
                <div class="col-inner">
                    <h4 class="title">Tất cả chuyên mục <a href="javascript:;" class="close-menu" title="Đóng"
                                                           style="user-select: auto;">Đóng <span class="icon-close"></span></a>
                    </h4>
                    <hr>
                    <br>
                    <div class="menu__content">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>