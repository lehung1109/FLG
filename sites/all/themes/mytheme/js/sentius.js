'use strict';
(function (window, document, $) {
  $( document ).ready(function() {
    var $quantity_des = $('.js-quantity-des');
    var $quantity_ins = $('.js-quantity-ins');

    $quantity_des.click(function() {
      var $value = $(this).parent().find('input').val();

      if($value > 1) {
        $(this).parent().find('input').val($value - 1);
      }
    });

    $quantity_ins.click(function() {
      var $value = $(this).parent().find('input').val();
      $(this).parent().find('input').val(parseInt($value) + 1);
    });

    // remove class collapsed in filter
    // $('.views-exposed-form').find('.collapsed').removeClass('collapsed');
    if($('.js-message').length) {
      let $html = $('.js-message').html();
      $('.is-message').html($html);
    }

    // $('.views-exposed-form').find('.collapsed').removeClass('collapsed');

    // slide on product page
    var $js_slick = $('.js-slick');
    if($js_slick.length) {
      $js_slick.slick({
        mobileFirst: true,
        infinite: true,
        adaptiveHeight: true,
        prevArrow: '<a class="art-image__prev slick-prev slick-arrow" aria-label="Previous" type="a">&lt;</a>',
        nextArrow: '<a class="art-image__next slick-next slick-arrow" aria-label="Next" type="a">&gt;</a>',
        appendArrows: $('.art-image__arrow'),
        variableWidth: false,
      });

      $window.resize(function () {
        $js_slick.not('.slick-initialized').slick('resize');
      });
  
      $window.on('orientationchange', function () {
          $js_slick.not('.slick-initialized').slick('resize');
      });
    }
  });
}(this, this.document, this.jQuery));