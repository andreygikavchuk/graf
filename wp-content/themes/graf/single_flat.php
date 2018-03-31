<?php
include(TEMPLATEPATH . '/header_2.php'); ?>

<section class="page-content">
    <div class="breadcrumbs">
        <ul>
            <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>
        </ul>
    </div>
    <div class="top-page-preview">

        <div class="container-fluid">
            <div class="position-wrap">
                <div class="description">
                    <div class="heading">
                        <a href="<?= get_home_url(); ?>">
                            <?php $custom_logo_id = get_theme_mod("custom_logo");
                            $image = wp_get_attachment_image_src($custom_logo_id, 'full'); ?>
                            <img src="<?= $image[0]; ?>" alt="">

                            <?php if (get_theme_mod('theme_header_bg') != '') {
                                $theme_header_bg = get_theme_mod('theme_header_bg'); ?>
                                <img class="logo" src="<?= $theme_header_bg ?>" alt="">
                                <?php
                            } ?>

                        </a>
                        <h3>Квартира <?php the_title(); ?></h3>

                    </div>
                    <div class="body">
                        <?php wp_reset_postdata(); ?>
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id, "full"); ?>
                <div class="flat" style="background-image: url('<?php echo $thumb_url[0]; ?>')"></div>
            </div>
        </div>


    </div>
    <div class="slider" id="slider">
        <?php
        $attachments = new Attachments('attachments');
        ?>
        <?php if ($attachments->exist()) : ?>

            <?php while ($attachment = $attachments->get()) : ?>
                <div class="item">
                    <img src="<?= $attachments->url(); ?>" alt="">
                </div>


            <?php endwhile; ?>

        <?php endif; ?>

    </div>
</section>


</main>
</div>

<?php get_footer(); ?>
