/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

	var FLG = {

		init : function(){
			var self = this;
			self.searchForm.init();
			self.lightboxGallery.init();
			self.exhibition.init();
			self.artList.init();
			self.homepageSliders.init();
			self.artist.init();

			self.art.init();
			//no images

			self.misc.init();

		},

		misc : {
			init : function(){
				var self = this;


				var $inSituLink = $('.art-in-situ-link')
				var $insituImage = $('img', $inSituLink);
				$insituImage.css({
					top: -$insituImage.height()-$inSituLink.height() + 'px'

				})


				$inSituLink.hover(function () {
					$insituImage.stop(true,true).show(0).removeClass('hidden');
				}, function () {
					$insituImage.stop(true,true).delay(500).hide(0);
				});


				
				
				var $scroll = $('.scroll-pane').jScrollPane({
					showArrows: true

				});
				
				$scroll.css({opacity:1});

				var api = $scroll.data('jsp');

				var $active = $('.search-item.active');
				var offset = $active.position().left - 430


				api.scrollToX(offset);

			}

		},

		art : {
			init: function() {
				var self = this;

				//offset the image

				var $imageContainer = $('.art-image');
				var $image = $('.art-image a.view-full-size img');
				var $artDetail = $('.art-detail');

				var offset = ($imageContainer.width() - $image.width())/2;

				$artDetail.css({marginLeft:offset});
				$artDetail.removeClass('center-text');






			}
		},
		artist: {
			init: function(){
				var self = this;

				if($('.artist').length && $('.logged-in').length && $('.tabs-primary').length){

					$('.tabs-primary li').each(function(i){
						if(i == 1) {
							//var nid = $('#artistId').attr('artist-id');
							//alert(nid);
							if($('.contemporary-artist').length){
								var nid = $('#main').attr('data-artist-id');
								nid += '?field_artist_nid='+nid+'&field_category_tid=All&field_featured_on_exhibition_value=All&field_contemporary_stock_value=0';
								//?field_artist_nid=187&field_category_tid=All&field_featured_on_exhibition_value=All&field_contemporary_stock_value=0
								$(this).after('<li class="tabs-primary__tab"><a href="/admin/artist/'+nid+'" class="tabs-primary__tab-link">Order Art</a></li>')
							}else{
								
							}
							
						}
					})

				}




			}
		},

		homepageSliders : {
			init : function(){
				if(!$('.channel-selector').length) return;

				$('.channel-selector').unslider({
					dots: true,
					delay: 8000
				});
				$('.module-slideshow').unslider({
					dots: true,
					delay: 7000
				});
			}

		},

		artList : {

			init : function(){



				if($('.als-small').length) {
					var $item = $('.als-small .als-item');
					var offset = $('.als-small').data('offset')

					var upLim = $item.length - 4
					if(offset > upLim) {
						offset =  $item.length - 4
					}

					$('.als-small').als({
						visible_items: 4,
						start_from: offset
					});
				}

				if($('.als-full').length) {
					var offset = $('.als-full').data('offset');


					var $item = $('.als-full .als-item');

					var upLim = $item.length - 6
					if(offset > upLim) {
						offset =  $item.length - 6
					}



					$('.als-full').als({
						visible_items: 6,
						start_from: offset

					});
				}

				$('.view-full-size').fancybox();



			}

		},

		exhibition: {
			init : function(){
				
				var width = $(window).width();
				if(width > 1068){
					var self = this;

					var $container = $('.art-showcase');
					// initialize
					$container.masonry({
						gutter: 30,
						columnWidth: 280,
						itemSelector: '.art'
					});	
				}
				
			}

		},

		lightboxGallery : {
			init : function(){

				var self = this;
				if(!$('.lightbox-gallery').length) return;
				$(".lightbox-gallery").colorbox({rel:'lightbox-gallery'});



				$('.lightbox-individual-container').each(function(i){
					var id = $(this).data('id');
					$('.' + id,this).colorbox({rel:id});

				})

				$(document).bind('cbox_complete', function(){
					// grab the text from the link, or whatever source
					var extra = $.colorbox.element().data('extra');
					$('#cboxLoadedContent').append('<div id="extra-info">' + extra + '</div>');
				});

				$('#cboxOverlay').mouseover(function(){
					$('#extra-info').stop(true,true).fadeOut();
				}).mouseout(function(){
						$('#extra-info').stop(true,true).fadeIn();
					})
			}

		},
		searchForm : {
			init : function(){
				var $inputsToConvert = $('input.input-converter').numeric();
				var convertVariable = 2.54 //cm to inches
				var $radio = $('.inputs input');

				$('#edit-artist').chosen();



				var $selectToRadio = $('div.select-to-radio');

				$selectToRadio.each(function(i) {

					var $select = $('select',$(this).next());



					var $inputs = $('input[type="radio"]',this);

					$inputs.each(function(i){

						if($(this).val() == $select.val()) {
							$(this).attr('checked', true);

						}

					})
					$inputs.change(function(e){
						$select.val($(this).val())
					});



				});



				var $close = $('.results a.close');
				$close.click(function(e){
					e.preventDefault();
					$('#edit-reset').trigger('click');
				});

				$('#sales_status-alt').click(function(e) {
					if($(this).attr('checked')){
						$('#edit-sale-status').val('')
					}else{
						$('#edit-sale-status').val('27')
					}
				});

				$inputsToConvert.on('input', function(e) {
					var $outputInput = $('#' + $(this).data('sibling-input'));
					var value;
					if($(this).hasClass('cm')) {
						value = $(this).val()/convertVariable;
					} else {
						value = $(this).val()*convertVariable;
					}
					value = Math.round(value * 100) / 100
					$outputInput.val(value);
				});

				var $cmInputContainers = $(
					'.views-widget .form-item-height-min, ' +
					'.views-widget .form-item-height-max, ' +
					'.views-widget .form-item-width-min, ' +
					'.views-widget .form-item-width-max');

				var $inchInputContainers = $(
					'.inches .form-item-height-min, ' +
					'.inches .form-item-height-max, ' +
					'.inches .form-item-width-min, ' +
					'.inches .form-item-width-max');


				$radio.change(function(e){
					if($(this).attr('id') == 'cm') {
						$cmInputContainers.removeClass('hidden');
						$inchInputContainers.addClass('hidden');

					}else{
						$cmInputContainers.addClass('hidden');
						$inchInputContainers.removeClass('hidden');
					}
				})


				if($radio.filter(':checked').attr('id') == 'cm') {
					$cmInputContainers.removeClass('hidden');
					$inchInputContainers.addClass('hidden');

				}else{
					$cmInputContainers.addClass('hidden');
					$inchInputContainers.removeClass('hidden');
				}
			}
		}

	}

 $(window).load(function(){
	 FLG.init();
 })


})(jQuery, Drupal, this, this.document);

function gotoUrlex(){
	
	var valueex = (jQuery)('#exhibitions-pass').val();
	window.location = valueex;
	
	return true;
}
function loadTaxo(){
	
	var valueop = (jQuery)('#select-taxo').val();	
			var classShow = '.taxo-'+valueop;
			(jQuery)('.desktop-hide').hide();
			(jQuery)(classShow).show();
	
}
(jQuery)(function(){
	
		
	(jQuery)('.scroll-pane-new').jScrollPane({
		showArrows: true
	});
	var width = (jQuery)(window).width();
		
	if(width < 1052){
		
		(jQuery)('.read-more-mobile').click(function(){
			(jQuery)('.contemporary-artist .description ').toggleClass('maxheight');
			var html = (jQuery)(this).html();
			
			if(html == 'Read More'){
				(jQuery)('.read-more-mobile').html('Show Less');	
			}else{
				(jQuery)('.read-more-mobile').html('Read More');
			}
			
			
		});
		
		var valueop = (jQuery)('#select-taxo').val();
		var classShow = '.taxo-'+valueop;
		(jQuery)('.desktop-hide').hide();
		(jQuery)(classShow).show();
		
		
		(jQuery)('#select-taxo').change(function(){
			var valueop = (jQuery)(this).val();
			
			var classShow = '.taxo-'+valueop;
			(jQuery)('.desktop-hide').hide();
			(jQuery)(classShow).show();
			
		});

		
		
		(jQuery)('#block-block-2 .text-blue').append('&nbsp;');
		
		(jQuery)('#block-block-2 .text-blue').click(function(){
			(jQuery)('#edit-sale-status-wrapper').toggle();
			(jQuery)('#edit-category-wrapper').toggle();
			(jQuery)(this).toggleClass('showplus');
			
		});	
		
		
		(jQuery)('.exhibition-list h2').click(function(){
			(jQuery)(this).parent().children('.row').toggle();
			
		});	
		
		
		(jQuery)('#edit-medium-wrapper label').each(function(){
			var attr = (jQuery)(this).attr('for');
			if(attr == 'edit-medium'){
				(jQuery)(this).click(function(){
					(jQuery)('#edit-medium-wrapper .views-widget').toggle();
					(jQuery)(this).toggleClass('showplus');
					
				});
					
			}
			
		});
		
		(jQuery)('#edit-genre-wrapper label').each(function(){
			var attr = (jQuery)(this).attr('for');
			if(attr == 'edit-genre'){
				(jQuery)(this).click(function(){
					(jQuery)('#edit-genre-wrapper .views-widget').toggle();
					(jQuery)(this).toggleClass('showplus');	
				});
				
			}
			
		});
		
		(jQuery)('#edit-orientation-wrapper label').each(function(){
			var attr = (jQuery)(this).attr('for');
			if(attr == 'edit-orientation'){
				(jQuery)(this).click(function(){
					(jQuery)('#edit-orientation-wrapper .views-widget').toggle();
					(jQuery)('#edit-width-wrapper').toggle();
					(jQuery)('#edit-art-price-wrapper').toggle();
					(jQuery)('#edit-artist-wrapper').toggle();
					(jQuery)(this).toggleClass('showplus');	
				});
					
			}
			
		});
			
	}			
	
	
				
	
	
});

function showBoxFron(classxs){
	var classShow = '.' + classxs;
	(jQuery)('.module').hide();
	(jQuery)(classShow).show();
	
}

