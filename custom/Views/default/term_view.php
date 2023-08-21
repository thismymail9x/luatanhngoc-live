<?php

//
//$post_model = new\ App\ Models\ Post();

?>
<div class="row global-post-module">
    <div class="col medium-8 small-12 large-8">
        <div class="col-inner">
            <h1 data-type="<?php echo $data['taxonomy']; ?>" data-id="<?php echo $data['term_id']; ?>" class="<?php echo $data['taxonomy']; ?>-taxonomy-title global-taxonomy-title global-module-title">
                <?php
                echo $data['name'];
                ?>
            </h1>
            <br>
            <?php

            if (!empty($child_data)) {
                $child_data = $post_model->list_meta_post($child_data);

                //
            ?>
                <div id="category_main" class="row fix-li-wit posts-list main-posts-list cf <?php $option_model->posts_in_line($getconfig); ?>">
                    <?php

                    foreach ($child_data as $child_key => $child_val) {
                        //echo '<!-- ';
                        //print_r( $child_val );
                        //echo ' -->';

                        //
                        $post_model->the_node($child_val, [
                            'taxonomy_post_size' => $taxonomy_post_size,
                        ]);
                    }

                    ?>
                </div>
                <br>
                <div class="public-part-page">
                    <?php

                    echo $public_part_page;

                    ?>
                </div>
            <?php
            }
            // không có sản phẩm nào -> báo không có
            else {
                //
            }

            ?>
        </div>
    </div>
    <div class="col medium-4 small-12 large-4">
        <div class="col-inner"></div>
    </div>
</div>