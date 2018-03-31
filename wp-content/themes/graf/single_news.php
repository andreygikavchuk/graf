<?php
include(TEMPLATEPATH . '/header_2.php'); ?>
    <section class="page-content">

        <div class="breadcrumbs">
            <ul>
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' » '); ?>
            </ul>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="thumb-slider">
                        <ul id="lightSlider">
                             <?php
                            $attachments = new Attachments('attachments');
                            ?>
                            <?php if ($attachments->exist()) : ?>

                                <?php while ($attachment = $attachments->get()) : ?>
                                    <li data-thumb="<?= $attachments->url(); ?>">
                                        <img src="<?= $attachments->url(); ?>">
                                    </li>



                                <?php endwhile; ?>

                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-md-offset-1">
                    <h1><?php the_title(); ?></h1>
                    <?php wp_reset_query(); the_content();?>
                </div>
            </div>
        </div>
    </section>
 </main>
    </div>
<?php get_footer(); ?>