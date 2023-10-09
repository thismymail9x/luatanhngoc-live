
<div class="row global-profile-main">
    <?php

    //
//    if ( $isMobile == true ) {
//        // nạp menu tổng (bản mobile)
//        include __DIR__ . '/users_mobile_menu.php';
//    } else {
        ?>
    <div class="col small-12 medium-2 large-2 global-profile-menu">
        <?php
        // nạp menu tổng
        include __DIR__ . '/users_menu.php';
        ?>
    </div>
<!--    --><?php
//    }
//
//    ?>
    <div class="col small-12 medium-10 large-10 global-profile-content">
        <?php

        echo $main;

        ?>
    </div>
</div>
