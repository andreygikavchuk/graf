<?php
/*
 Template Name: Новости
 */
include(TEMPLATEPATH . '/header_2.php'); ?>
<section class="page-content" id='page-6'>
    <div class="container-fluid">
        <h2>новости</h2>
        <div class="content-wrap"></div>


        <?php $news = new WP_Query(array('post_type' => 'post', 'showposts' => '6','cat' => '2')); ?>
        <?php $i=0; ?>
        <?php if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
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
                        <p><?php the_content(); ?></p>
                    </div>
                </div>
            </div>

            <?php  if ($i % 2 == 0) { ?>
                </div>
            <?php } ?>
        <?php endwhile;
        endif; ?>



        <div class="clearfix"></div>
        <div class="button">
            <a href="#" class="btn-link">
                все новости
                <i class="sprite sprite-shape-2-copy-2"></i>
            </a>
        </div>
    </div>
</section>


</main>
</div>
<?php get_footer(); ?>