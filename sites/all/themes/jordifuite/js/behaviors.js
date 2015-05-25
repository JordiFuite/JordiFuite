(function ($) {
  Drupal.behaviors.slideUp = {
    attach: function (context, settings) {
      $('a').not('.menu-trigger').click(function(e) {
        if (( $(this).parents('.portfolio-column').length != 1 )
          || $(this).hasClass('menu-trigger')) {
          e.preventDefault();
          href = $(this).attr('href');
          $('#big-wrapper').slideUp(1000, function() {
            window.location = href;
          });
          if ($(window).width() < 640) {
            $('#main-menu-links').animate({height: '4px'});
          }
        }
      });
    }
  }
  Drupal.behaviors.slideDown = {
    attach: function (context, settings) {
      $('body').once('slide', function() {
        $(document).ready(function() {
          $('#big-wrapper').hide().slideDown(1000);
        });
      });
    }
  }

  Drupal.behaviors.portfolioFirst = {
    attach: function (context, settings) {
      $('body').once('popup', function() {
        var clicked = false;
        var opened = false;
        var delay = 0;
        var speed = 500;
        $('.portfolio-column a', context).bind('click', function (e) {
          e.preventDefault();
          if (!clicked) {
            clicked = true;
            $('.embed').slideUp(speed).addClass('old');
            var url = $(this).attr('href');
            if ( url.indexOf('?') > -1 ) {
              var newurl = url + '&embed=1';
            } else {
              var newurl = url + '?embed=1';
            }
            if(opened) {
              delay = 500;
              setTimeout(function () {
                $('.embed.old').remove();
              }, delay);
            } else {
              delay = 0;
            }
            $.get(newurl, function(data) {
              $(data).appendTo($('#block-system-main').parent())
              .hide()
              .delay(delay)
              .slideDown(speed);
              clicked = false;
              Drupal.attachBehaviors();
              // window.history.pushState({ id: 35 }, '', url);
            });
            opened = true;
          }
        });
      });
    }
  };
  Drupal.behaviors.menu = {
    attach: function (context, settings) {
      $('body').once('menu', function() {
        $('.menu-trigger', context).bind('click', function (e) {
          e.preventDefault;
          $('#main-menu-links').slideToggle();
          $('header').toggleClass('menu-active');
        });
        if ($(window).width() < 640) {
          if(!$('body').hasClass('responsive')) {
            $('body').addClass('responsive');
          }
        }
        $(window).resize(function() {
          if ($(window).width() > 640) {
            $('#main-menu-links').show();
            $('header').removeClass('menu-active');
            $('body').removeClass('responsive');
          }
          else {
            if(!$('body').hasClass('responsive')) {
              $('body').addClass('responsive');
              $('#main-menu-links').hide();
              $('header').removeClass('menu-active');
            }
          }
        });
      });
    }
  };
  Drupal.behaviors.slider = {
    attach: function (context, settings) {
      var interval = null;
      var speed = 7000;
      $('.slider-item').first().addClass('active');
      $('.slider-item').hide();
      $('.slider-item.active').show();
      interval = setInterval(next, speed);
      $('.next').click(function(){
        next();
        clearInterval(interval);
        interval = setInterval(next, speed)
      });

      $('.previous').click(function(){
        previous();
        clearInterval(interval);
        interval = setInterval(next, speed)
      });
    }
  };

  function next() {
    $('.slider-item.active').addClass('oldActive').removeClass('active');
    if ( $('.oldActive').is(':last-child')) {
      $('.slider-item').first().addClass('active');
    }
    else{
      $('.oldActive').next().addClass('active');
    }
    $('.oldActive').removeClass('oldActive');
    $('.slider-item').fadeOut();
    $('.active').fadeIn();
  }

  function previous() {
    $('.active').removeClass('active').addClass('oldActive');
    if ( $('.oldActive').is(':first-child')) {
      $('.slider-item').last().addClass('active');
    }
    else{
      $('.oldActive').prev().addClass('active');
    }
    $('.oldActive').removeClass('oldActive');
    $('.slider-item').fadeOut();
    $('.active').fadeIn();
  }
})(jQuery);


