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
    $('.views-exposed-form').find('.collapsed').removeClass('collapsed');

    if($('.js-message').length) {
      let $html = $('.js-message').html();
      $('.is-message').html($html);
    }
  });
}(this, this.document, this.jQuery));