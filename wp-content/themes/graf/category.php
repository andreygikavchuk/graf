<?php

include(TEMPLATEPATH . '/header_2.php'); ?>
<section class="page-content" id='page-6'>
    <div class="breadcrumbs">
        <ul>
            <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' » '); ?>
        </ul>
    </div>
    <div class="container-fluid">
        <h2 class="text-center"><?php single_cat_title(); ?></h2>
       
        <?php while ( have_posts() ) : the_post(); ?>
            <?php $i=$i+1;
            if ($i % 2 != 0) {
                ?>
                <div class="row">
            <?php } ?>
            <div class="col-sm-6">
                <div class="news-item">
                    <a href="<?= get_permalink(); ?>" class="image">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <div class="description">
                        <p class="date"><?= get_the_date('d.m.Y'); ?></p>
                        <p class="heading"><?php the_title(); ?></p>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                </div>
            </div>

            <?php  if ($i % 2 == 0) { ?>
                </div>
            <?php } ?>
        <?php endwhile;?>



        <div class="clearfix"></div>

        <div class="pagination">
        <?php if (function_exists("pagination")) {
            pagination($custom_query->max_num_pages);
        } ?>
            </div>

    </div>
</section>


</main>
</div>
<?php get_footer(); ?>