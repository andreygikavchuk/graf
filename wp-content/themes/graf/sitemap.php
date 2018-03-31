<?php
/*
 Template Name: Карта сайта
 */
include(TEMPLATEPATH . '/header_2.php'); ?>
    <section class="page-content">
        <div class="breadcrumbs">
            <ul>
                <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>
            </ul>
        </div>
        <div class="container-fluid">
            <h1>карта сайта</h1>
            <ul class="tree">
                <li><a href="<?= get_home_url(); ?>">главная</a></li>
                <li><a href="<?= get_home_url(); ?>#page-1">о доме</a></li>
                <li><a href="<?= get_home_url(); ?>#page-2">расположение</a></li>
                <li><a href="<?= get_home_url(); ?>#page-3">инфраструктура</a></li>
                <li><a href="<?= get_home_url(); ?>#page-4">квартиры</a>


                        <?php
                        $args = array(
                            'parent' => '3',
                        );
                        $categories = get_categories($args);

                        foreach ($categories as $category) {?>

                            <p class="heading"> <?= $category->name; ?>  </p>
                    <ul>


                        <?php $posts_array = get_posts('cat=' . $category->cat_ID . '&posts_per_page=-1&order=ASC'); ?>

                        <?php $chunks = array_chunk($posts_array, 6); ?>
                        <?php foreach ($chunks as $chunk): ?>

                                <?php foreach ($chunk as $key => $post) : setup_postdata($post); ?>
                                <li><a href="<?= get_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endforeach; ?>

                        <?php endforeach; ?>


                    </ul>
                    <?php } ?>



                </li>
                <li><a href="<?= get_home_url(); ?>#page-5">застройщик</a></li>
                <li><a href="<?= get_home_url(); ?>#page-6">новости</a></li>
                <li><a href="<?= get_home_url(); ?>#page-7">контакты</a></li>

            </ul>


        </div>
    </section>

    </main>
    </div>
<?php get_footer(); ?>