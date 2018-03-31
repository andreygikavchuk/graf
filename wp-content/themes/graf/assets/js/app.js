var resizeTimer;
var app = {

    $body: $('body'),
    $header: $('#header'),
    $footer: $('#footer'),
    $main: $('#main'),
    headerHeight: $(window).width() < 992 ? 53: 78,
    windowHeight: $(window).height(),
    mapHeight: $('.plans').height(),

    keepFooter: function(){
        var footerHeight = app.$footer.outerHeight();
        app.$footer.css('marginTop', -footerHeight + 'px');
        app.$main.css('paddingBottom', footerHeight + 'px');
    },

    fullSizeHeader: function(){
        if($('body').hasClass('main-page')){
            app.$header.find('.overlay').css('height', app.windowHeight + 'px');
        }
    },

    mobileNav: function(){
        var $btn = $('#btn-toggle');
        $btn.on('click', function(){
            $(this).toggleClass('active');
            app.$header.find('ul').toggleClass('open');
        });
    },

    fixHeader: function(){
        var isFixed = false;
        var position = $(window).scrollTop();
        if(!isFixed && position >= app.windowHeight - app.headerHeight){
            app.$header.addClass('fixed-top');
            isFixed = true;
        }else{
            app.$header.removeClass('fixed-top');
            isFixed = false;
        }
    },

    buildMap:{

        $front: $('.front'),
        $map: $('map'),
        $canvas: $('canvas'),

        init: function(){
            if(app.buildMap.$map.length){
                app.buildMap.$map.imageMapResize();
                app.buildMap.$front.maphilight({
                    stroke: false,
                    fillOpacity: 0.6
                });
            }
        },

        reInit: function(){
            $('canvas').remove();
            $('#layers').find('.front').removeClass('maphilighted');
            $('#layers').find('.front').removeAttr('style');
            app.buildMap.init();

        }


    },

    selectInit: function(){
        if($('select').length){
            $('select').select2();
        }
    },

    changeFloor: function(){
        var info = {};
        isVisible = false;
        var $target = $('area');
        var $box = $('#layers').find('.modal-overlay');
        var $btn = $('#floor-target');
        var $window = $('.link-window');
        var $flors = $window.find('.heading-label').find('span');
        var $total = $window.find('.total-number').find('span');
        var $free = $window.find('.free-number').find('span');
        $target.hover(function(){
            isVisible = true;
            info = JSON.parse($(this).attr('data-info'));
            $flors.html(info.floor);
            $total.html(info.total);
            $free.html(info.free);
        }, function(){
            isVisible = false;
        });
        $(window).on('mousemove', function(e){
            if(isVisible){
                $window.show();
                $window.css({
                    'position': 'absolute',
                    'top': e.pageY + 'px',
                    'left': e.pageX + 'px'
                });
            }
            if(!isVisible){
                $window.hide();
            }
        });
        $target.on('click', function (e){
            app.floorLoad(info.floor, $window);
            e.preventDefault();
            return false;
        });
        // $target.on('click', function(e){
        // var info = JSON.parse($(this).attr('data-info'));
        // $flors.html(info.floor);
        // $total.html(info.total);
        // $free.html(info.free);
        // $btn.attr('href', info.floor);
        // $window.css({
        //     'position': 'absolute',
        //     'top': e.pageY + 'px',
        //     'left': e.pageX + 'px'
        // });
        //     $window.fadeIn(500);
        //     $box.fadeIn(500, function(){
        //         isOpen = true;
        //     });
        //     e.preventDefault();
        // });
        // $box.on('click',function (e){
        //     if(e.target.className == "modal-overlay"){
        //         $box.fadeOut(500, function(){
        //             isOpen = false;
        //         });
        //         $window.fadeOut(500, function(){
        //             $window.removeAttr('style');
        //         });
        //     }
        // });
        $(document).on('click', '.back-to', function(e){
            e.preventDefault();
            $('#hide').show();
            $('#base-layout').hide();
            $('.modal-overlay').hide();
            app.buildMap.reInit();
        });

    },

    changePlan: function(active){
        var $nav = $('#map-nav');
        var $itemsWrap = $('.map-container');
        var $headingsWrap = $('.floor-heading');
        $nav.find('li').removeClass('active');
        $nav.find('li').eq(active-1).addClass('active');
        showActive(active);
        $nav.find('a').on('click', function(e){
            e.preventDefault()
            $nav.find('li').removeClass('active');
            $(this).parent().addClass('active');
            showActive($(this).attr('href'));
        });
        function showActive(activeItem){
            $headingsWrap.find('.heading-item').each(function(i){
                if($(this).attr('data-heading') == activeItem){
                    $(this).fadeIn(300);
                }else{
                    $(this).hide();
                }
            });
            $itemsWrap.find('.map-item').each(function(i){
                if($(this).attr('data-item') == activeItem){
                    $(this).fadeIn(300);
                }else{
                    $(this).hide();
                }
            });
        }
    },

    floorLoad: function(number, $modal){
        var $preloader = $('#preloader');
        var $hidden = $('#hide');
        if(!$('#base-layout').length){
            $.ajax({
                url: 'inc/floor-base.html',
                dataType: 'html',
                cache: false,
                beforeSend: function(){
                    $('.plans').css('min-height', app.mapHeight - 350 + 'px');
                    $preloader.fadeIn(300);
                    $modal.removeAttr('style');
                },
                success: function(data){
                    $hidden.hide();
                    $preloader.fadeOut(300, function(){
                        $('.plans').append(data);
                        app.changePlan(number);
                        app.planHover();
                    });
                }
            });
        }else{
            $('#hide').hide();
            $('#base-layout').show();
            $('.modal-overlay').hide();
            $('.link-window').removeAttr('style');
            app.changePlan(number);
        }
    },

    planHover: function(){
        var info = {};
        var status = '';
        var isVisible = false;
        var $svg = $('svg');
        var $tmp = "<div class='flat-window'>" +
            "<div class='heading-label free'><span></span>свободно</div>" +
            "<div class='heading-label booked'><span></span>продано</div>" +
            "<p class='name'>Квартира <span>" +
            "<p class='rooms'>Комнат <span>" +
            "<p class='area'>Площадь <span> кв.м" +
            "</div>"
        var $modal = $('.test');
        $svg.each(function(i){
            $(this).find('g').each(function(){
                if($(this).attr('data-status') == "open"){
                    $(this).children().attr('class','open');
                }
                if($(this).attr('data-status') == "closed"){
                    $(this).children().attr('class','closed');
                }
            });
        });
        $svg.find('g').hover(function(e){
            isVisible = true;
            info = JSON.parse($(this).attr('data-info'));
            status = $(this).attr('data-status')
        }, function(e){
            isVisible = false;
        });
        $(document).on('mousemove', function(e){
            var coords = getCoordinates(e);
            if(isVisible == true){
                if(!$('.flat-window').length){
                    $('body').append($tmp);
                }
                if(status == 'closed'){
                    $('.flat-window').addClass('closed');
                }else{
                    $('.flat-window').removeClass('closed');
                }
                $('.flat-window').css({
                    'top': coords[1] + 'px',
                    'left': coords[0] + 'px'
                });
                $('.flat-window').find('.name').children().html(info.name);
                $('.flat-window').find('.rooms').children().html(info.rooms);
                $('.flat-window').find('.area').children().html(info.area);
            }
            if(isVisible == false){
                $('body').find('.flat-window').remove();
            }
        })
        function getCoordinates(e){
            return [e.pageX, e.pageY];
        }
    },

    gallery: function(){
        var $gallery = $('#lightSlider')
        if($gallery.length){
            $gallery.lightSlider({
                gallery: true,
                item: 1,
                loop:true,
                slideMargin: 0,
                thumbItem: 3,
                responsive : [
                    {
                        breakpoint: 991,
                        settings: {
                            thumbItem: 2,
                        }
                    }],
                onSliderLoad: function(e){
                    $(e[0]).next().find('.lSPrev').append('<i class="sprite sprite-shape-2-copy-8_2">');
                    $(e[0]).next().find('.lSNext').append('<i class="sprite sprite-shape-2-copy_2">');
                }
            });
        }
    },

    pageScroll: function(){
        var hash = location.hash;
        setTimeout(function(){
            if(!hash == ''){
                var offset = $(hash).offset().top;
                $('html, body').animate({
                    scrollTop: offset - app.headerHeight
                },400);
            }
        },700)
        $('#nav-list').singlePageNav({
            offset: app.headerHeight,
            beforeStart: function(){
                $('#btn-toggle').removeClass('active');
                app.$header.find('ul').removeClass('open');
            }
        });
    },

    createMap: function(){
        var $wraps = document.querySelectorAll('.map');
        var styleArray = [{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}];

        var locations = [{
            lat: 46.465897,
            lng: 30.762100,
            marker: 'wp-content/themes/graf/assets/img/marker-dark.png',
            label: 'Трасса Здоровья'
        },{
            lat: 46.468293,
            lng: 30.761905,
            marker: 'wp-content/themes/graf/assets/img/marker-dark.png',
            label: 'Пляж Отрада'
        },{
            lat: 46.467421,
            lng: 30.752787,
            marker: 'wp-content/themes/graf/assets/img/marker-dark.png',
            label: 'Театр Музкомедии'
        },{
            lat: 46.465673,
            lng: 30.756797,
            marker: 'wp-content/themes/graf/assets/img/large-marker.png',
        }];

        var marker;

        google.maps.Marker.prototype.setLabel = function(label) {
            this.label = new MarkerLabel({
                map: this.map,
                marker: this,
                text: label
            });
            this.label.bindTo('position', this, 'position');
        };

        var MarkerLabel = function(options) {
            if(typeof options.text !== 'undefined'){
                this.setValues(options);
                this.span = document.createElement('span');
                this.span.className = 'map-marker-label';
            }
        };

        MarkerLabel.prototype = $.extend(new google.maps.OverlayView(), {
            onAdd: function() {
                this.getPanes().overlayImage.appendChild(this.span);
                var self = this;
                this.listeners = [
                    google.maps.event.addListener(this, 'position_changed', function() {
                        self.draw();
                    })
                ];
            },
            draw: function() {
                var text = String(this.get('text'));
                var position = this.getProjection().fromLatLngToDivPixel(this.get('position'));
                this.span.innerHTML = text;
                this.span.style.left = (position.x) + 'px';
                this.span.style.top = (position.y) + 'px';
            }
        });


        for(var i = 0; i < $wraps.length; i++){
            var mapOptions = {
                zoom: 16,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                scrollwheel: false,
                draggable: $(window).width() > 991 ? true : false,
                center: new google.maps.LatLng(46.466880, 30.762177),
                styles: styleArray
            };

            var map = new google.maps.Map($wraps[i], mapOptions);

            if(i == 0){
                for(var n = 0; n < locations.length; n++){
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[n].lat, locations[n].lng),
                        map: map,
                        label: locations[n].label,
                        icon: locations[n].marker
                    });
                    marker.set("id", n);
                }
                if($(window).width() < 767){
                    map.set('zoom', 14);
                }
            }

            if(i == 1){
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(46.482579, 30.724227),
                    map: map,
                    icon:'wp-content/themes/graf/assets/img/map-marker.png'
                });
                map.set('zoom', 11);
            }
        }
    },

    slider: function(){
        var $slider = $('#slider');
        if($slider.length){
            $slider.owlCarousel({
                singleItem: true,
                navigation: true,
                autoHeight : true,
                navigationText: ['<i class="sprite sprite-shape-2-copy-8_2">','<i class="sprite sprite-shape-2-copy_2">']
            });
        }
    },

    init: function(){
        this.fullSizeHeader();
        this.keepFooter();
        this.fixHeader();
        this.mobileNav();
        this.pageScroll();
        this.createMap();
        this.slider();
        this.gallery();
        this.selectInit();
        this.changeFloor()
        app.buildMap.init();
        this.$body.addClass('loaded');

        $('.btn-sliding').on('click', function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            $('#nav-list').find('a').each(function(){
                if($(this).attr('href') == href){
                    console.log('sdfbsdfbsdfbsdf');
                    $(this).trigger('click');
                }
            });
        });
    }

}

$(window).on('load', function(){
    app.init();

    $(window).on('scroll', function(){
        app.fixHeader();
    });

    $(window).on('resize', function(e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            app.windowHeight = $(window).height();
            app.headerHeight = $(window).width() < 992 ? 0 : 78;
            app.keepFooter();
            app.fullSizeHeader()
            app.pageScroll();
            app.createMap();
            app.buildMap.reInit();
            app.mapHeight = $('.plans').height();
        },  300);
    });

});
