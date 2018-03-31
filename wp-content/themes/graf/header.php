<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/vendor/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/vendor/lightslider.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body class="main-page">
<div class="page">
    <main id="main">
        <header class="header" id="header">
            <div class="overlay">
                <div class="navigation">
                    <div class="container-fluid">
                        <nav class="nav" >
                            <?php if (get_theme_mod('theme_header_bg') != '') { // if there is a background img
                                $theme_header_bg = get_theme_mod('theme_header_bg'); // Assigning it to a variable to keep the markup clean

                                 ?>
                                    <a href="#" class="site-logo">
                                        <img src="<?= $theme_header_bg ?>" alt="">
                                    </a>
                                    <?php


                            }
                            ?>

                            <ul id="nav-list">
                                <li><a class="nav-item" href="#header">главная</a></li>
                                <li><a class="nav-item" href="#page-1">о доме</a></li>
                                <li><a class="nav-item" href="#page-2">расположение</a></li>
                                <li><a class="nav-item" href="#page-3">инфраструктура</a></li>
                                <li><a class="nav-item" href="#page-4">квартиры</a></li>
                                <li><a class="nav-item" href="#page-5">застройщик</a></li>
                                <li><a class="nav-item" href="#page-6">новости</a></li>
                                <li><a class="nav-item" href="#page-7">контакты</a></li>
                            </ul>
                            <div class="btn-toggle" id="btn-toggle">
                                <span class="sp-1"></span>
                                <span class="sp-2"></span>
                                <span class="sp-3"></span>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="content-box">
                    <div class="container-fluid">
                        <?php $custom_logo_id = get_theme_mod("custom_logo");
                        $image = wp_get_attachment_image_src($custom_logo_id, 'full');

                        if (is_front_page()) { ?>
                            <img src="<?= $image[0]; ?>" alt="">
                        <?php } else { ?>
                            <a href="#" class="img-box">
                                <img src="<?= $image[0]; ?>" alt="">
                            </a>
                        <?php }
                        ?>

                        <div class="page-heading">
                            <h1><span><?php bloginfo('name'); ?></span><?php bloginfo('description'); ?></h1>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-md-6">

                                <a class="btn btn-transparent" href="#page-1">узнать больше</a>
                            </div>
                            <div class="col-sm-6 col-sm-offset-2 col-md-6 col-md-offset-0">
                                <div class="right-position">
                                    <a class="btn btn-regular" href="<?= get_category_link(2); ?>">спец -предложение!</a>
                                    <a class="btn btn-transparent" data-toggle="modal" data-target="#myModal">связаться</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#page-1" class="nav-item scroll-down btn-sliding">
                        <i class="sprite sprite-shape-2-copy-7_2"></i>
                    </a>
                </div>
            </div>
        </header>