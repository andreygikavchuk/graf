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
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet">
</head>
<body class="static-header">
<div class="page">
    <main id="main">
        <header class="header" id="header">
            <div class="overlay">
                <div class="navigation">
                    <div class="container-fluid">
                        <nav class="nav" >
                            <?php if (get_theme_mod('theme_header_bg') != '') { // if there is a background img
                                $theme_header_bg = get_theme_mod('theme_header_bg'); // Assigning it to a variable to keep the markup clean

                                if (is_front_page()) { ?>
                                    <img src="<?= $theme_header_bg ?>" alt="">
                                <?php } else { ?>
                                    <a href="<?= get_home_url(); ?>" class="site-logo">
                                        <img src="<?= $theme_header_bg ?>" alt="">
                                    </a>
                                    <?php
                                }

                            }
                            ?>
                            <ul id="">
                                <li><a class="nav-item" href="<?= get_home_url();?>/#header">главная</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-1">о доме</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-2">расположение</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-3">инфраструктура</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-4">квартиры</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-5">застройщик</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-6">новости</a></li>
                                <li><a class="nav-item" href="<?= get_home_url();?>/#page-7">контакты</a></li>
                            </ul>
                            <div class="btn-toggle" id="btn-toggle">
                                <span class="sp-1"></span>
                                <span class="sp-2"></span>
                                <span class="sp-3"></span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>