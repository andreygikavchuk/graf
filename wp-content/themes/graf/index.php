<?php get_header();
/*
 Template Name: Главная страница
 */
?>
<section class="page-content" id='page-1'>
    <div class="container-fluid">
        <h2>о доме</h2>

        <div class="content-wrap">
            <?php the_field('about_info') ?>
        </div>
        <div class="tags-heading">
            <?php the_field('details_info') ?>
        </div>
        <div class="gallery">
            <?php wp_reset_postdata(); ?>

            <?php the_content(); ?>

        </div>
    </div>
</section>

<section class="page-content dark-background">
    <div class="slider" id="slider">
        <?php
        $attachments = new Attachments('attachments');
        ?>
        <?php if ($attachments->exist()) : ?>

            <?php while ($attachment = $attachments->get()) : ?>
                <div class="item">
                    <img src="<?= $attachments->url(); ?>" alt="<?= $attachments->field('title'); ?>">
                </div>


            <?php endwhile; ?>

        <?php endif; ?>

    </div>
    <div class="container-fluid">
        <h3>преимущества</h3>
        <div class="content-wrap"></div>
        <?php
        $attachments = new Attachments('advantages_attachments');

        ?>
        <?php if ($attachments->exist()) : ?>
            <?php $i = 0; ?>
            <?php while ($attachment = $attachments->get()) : ?>
                <?php
                $i = $i + 1;
                if ($i == 1) {
                    ?>
                    <div class="row">
                <?php } ?>
                <div class="col-sm-4">
                    <div class="content-item">
                        <div class="heading">
                            <div class="icon">
                                <i class="sprite"
                                   style="background-image: url('<?= $attachments->src('full'); ?>');"></i>
                            </div>
                            <div class="wrap">
                                <p class="title"><?= $attachments->field('title'); ?></p>
                                <p class="sub-title"><?= $attachments->field('caption'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($i % 3 == 0) { ?>
                    </div>  <div class="row">
                <?php } ?>
            <?php endwhile; ?>
            </div>
        <?php endif; ?>


    </div>
</section>

<section class="page-content" id='page-2'>
    <div class="container-fluid">
        <h2>расположение</h2>
        <div class="content-wrap">
            <p><?php the_field('location_of') ?></p>
        </div>
        <div class="tags-heading">
            <ul>
                <li><?= get_option('site_telephone', $default = false); ?>
                    , <?= get_option('site_telephone2', $default = false); ?></li>
                <li><?= get_option('theme_email', $default = false); ?></li>
                <li><?= get_option('address', $default = false); ?></li>
            </ul>
        </div>
        <div class="map" style="height: 355px;"></div>
    </div>
</section>

<section class="page-content light-background" id='page-3'>
    <div class="container-fluid">
        <h2>инфраструктура</h2>
        <div class="content-wrap">
            <p><?php the_field('infrastructure') ?></p>
        </div>
        <?php
        $attachments = new Attachments('infrastructure_attachments');
        ?>
        <?php if ($attachments->exist()) : ?>
        <?php $i = 0 ?>

        <?php while ($attachment = $attachments->get()) : ?>
        <?php $i = $i + 1;
        if ($i == 1) {
        ?>
        <div class="row">
            <?php } ?>
            <div class="col-sm-4">
                <div class="content-item">
                    <div class="heading">
                        <div class="icon">
                            <i class="sprite" style="background-image: url('<?= $attachments->src('full'); ?>');"></i>
                        </div>
                        <div class="wrap">
                            <p class="title"><?= $attachments->field('title'); ?></p>
                        </div>
                    </div>
                    <?= $attachments->field('caption'); ?>
                </div>
            </div>
            <?php if ($i % 3 == 0) { ?>
        </div>
        <div class="row">
            <?php } ?>
            <?php endwhile; ?>
            <?php endif; ?>


        </div>
</section>


<section class="plans" id="page-4">
    <div class="preloader" id="preloader">
<!--        <img src="assets/img/25.gif" alt="">-->
    </div>
    <div class="hide-on-load" id="hide">
        <div class="overlay-outer">
            <div class="page-content">
                <div class="container-fluid">
                    <h2>квартирьі</h2>
                    <div class="content-wrap">
                        <p><?php the_field('flats') ?>
                        </p>
                    </div>
                    <div class="tags-heading">
                        <?php the_field('flats_2') ?>
                    </div>
                    <div class="mobile-select">
                        <a class="link" href="http://graf.apartments/wp-content/uploads/2016/11/этаж.pdf">Загрузить планировки</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="build-map" id="layers">
            <div class="front">
                <div class="front"
                     style="display: block; background-image: url('http://graf.apartments/wp-content/uploads/2016/11/11111.jpg');  background-repeat: no-repeat; background-size: contain; position: relative; padding: 0px; width: 1340px; height: 1153px;">
                    <canvas
                        style="width: 1340px; height: 1153px; position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px; opacity: 1;"
                        height="1153" width="1340"></canvas>
                    <img class="front maphilighted" src="http://graf.apartments/wp-content/uploads/2016/11/11111.jpg" usemap="#front" alt=""
                         style="opacity: 0; position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px;"></div>
            </div>
            <div class="modal-overlay"></div>
        </div>

    </div>


</section>

<section class="page-content light-background" id='page-5'>
    <div class="container-fluid">
        <h2>застройщик</h2>
        <div class="content-wrap">
            <p><?php the_field('developer_info') ?></p>
        </div>
    </div>
</section>

<section class="page-content" id='page-6'>
    <div class="container-fluid">
        <h2>новости</h2>
        <div class="content-wrap"></div>
        <?php $news = new WP_Query(array('post_type' => 'post', 'showposts' => '6', 'cat' => '2')); ?>
        <?php $i = 0; ?>
        <?php if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
            <?php $i = $i + 1;
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

            <?php if ($i % 2 == 0) { ?>
                </div>
            <?php } ?>
        <?php endwhile;
        endif; ?>

        <div class="clearfix"></div>
        <div class="button">
            <a href="<?= get_category_link(2); ?>" class="btn-link">
                все новости
                <i class="sprite sprite-shape-2-copy-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="page-content contacts dark-background" id='page-7'>
    <div class="container-fluid">
        <h2>контакты</h2>
        <?php wp_reset_query(); ?>
        <div class="content-wrap">
            <p><?php the_field('contact_info') ?></p>
        </div>
        <div class="map"></div>
        <div class="row">
            <div class="col-sm-6 col-md-5 col-md-offset-1">
                <h3>Свяжитесь с нами</h3>
                <div class="contacts-item">
                    <div class="icon">
                        <i class="sprite sprite-shape-75_2"></i>
                    </div>
                    <div class="item-content">
                        <p class="phone-num"><?= get_option('site_telephone', $default = false); ?></p>
                        <p class="phone-num"><?= get_option('site_telephone2', $default = false); ?></p>
                    </div>
                </div>
                <div class="contacts-item">
                    <div class="icon">
                        <i class="sprite sprite-shape-74_2"></i>
                    </div>
                    <div class="item-content">
                        <a href="mailto:<?= get_option('theme_email', $default = false); ?>"><?= get_option('theme_email', $default = false); ?></a>
                    </div>
                </div>
                <div class="contacts-item">
                    <div class="icon">
                        <i class="sprite sprite-clock_2"></i>
                    </div>
                    <div class="item-content">
                        <p>График работы: <br>
                            <?= get_option('description', $default = false); ?>
                        </p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="contacts-item">
                    <div class="icon">
                        <i class="sprite sprite-shape-76_2"></i>
                    </div>
                    <div class="item-content">
                        <p>Присоединяйтесь к нам в <a target="_blank"
                                                      href="<?= get_option('site_facebook', $default = false); ?>">Facebook</a>
                        </p>
                    </div>
                </div>
                <div class="contacts-item">
                    <div class="icon">
                        <i class="sprite inst_logo"></i>
                    </div>
                    <div class="item-content">
                        <p>Присоединяйтесь к нам в <a target="_blank"
                                                      href="<?= get_option('site_vk', $default = false); ?>">instagram</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-5">
                <h3>или заполните форму</h3>
                <?= do_shortcode('[contact-form-7 id="42" title="Форма связи"]'); ?>
            </div>
        </div>
    </div>
</section>
</main>
</div>

<?php get_footer(); ?>
