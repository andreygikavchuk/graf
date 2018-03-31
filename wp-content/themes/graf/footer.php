<footer id="footer">
    <div class="top-line">
        <div class="container-fluid">
            <div class="subscribe">
                <div class="modal-form">
                    <?= do_shortcode('[contact-form-7 id="65" title="Форма рассылки новостей"]'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-line">
        <div class="container-fluid">
            <p>2016 © Граф. Клубный дом. Все права защищены</p>
            <a href="<?= get_permalink(119); ?>">Карта сайта</a>
        </div>
    </div>
</footer>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery-1.11.3.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery.easing.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/paraxify.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery.singlePageNav.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/owl.carousel.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/lightslider.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/imageMapResizer.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery.maphilight.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/select2.full.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtemUdSiLNXa5tHpmyRavyzVwTrFZVc_A&callback=initMap" async
        defer></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/app.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_popup" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">свяжитесь с нами</h3>
            </div>
            <div class="modal-content-wrap">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contacts-item">
                            <div class="icon">
                                <i class="sprite sprite-shape-75_2"></i>
                            </div>
                            <div class="item-content">
                                <p class="phone-num"><?= get_option('site_telephone', $default = false); ?></p>
                                <p class="phone-num"><?= get_option('site_telephone2', $default = false); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="contacts-item">
                            <div class="icon">
                                <i class="sprite sprite-shape-74_2"></i>
                            </div>
                            <div class="item-content">
                                <a href="mailto:<?= get_option('theme_email', $default = false); ?>"><?= get_option('theme_email', $default = false); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="modal-text">Или закажите звонок и наш менеджер свяжется с Вами в ближайшее время!</p>
                <div class="modal-form">
                    <?= do_shortcode('[contact-form-7 id="225" title="СВЯЖИТЕСЬ С НАМИ"]') ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="myModal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_popup" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Спасибо!</h3>
            </div>
            <div class="modal-content-wrap">
                <p class="modal-text">Вы отправили сообщение. Вскоре с вами свяжется наш менеджер.</p>
                <a class="modal-link close_popup" href="#">Перейти на Главную</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close_popup" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Спасибо!</h3>
            </div>
            <div class="modal-content-wrap">
                <p class="modal-text">Вы оформили рассылку новостей о Клубном Доме Graf.</p>
                <a class="modal-link close_popup" href="#">Перейти на Главную</a>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in"></div>

<?php wp_footer(); ?>
</body>
</html>
