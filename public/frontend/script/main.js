(function ($) {
  "use strict";
  var base_url = $('span.site_url').text();

  // ajax login on register page
  $(document).on( 'submit', 'form.register-page-login', function(e){
    e.preventDefault();
    $('.frontend-login-form').val("Loading...");
    $('.login_failed').html("");
    $.ajax({
        type: 'post',
        cache: false,
        url: base_url + '/login/ajax_attempt_login',
        data: {
            'login_string': $('#form_username').val(),
            'login_pass': $('#form_passwd').val(),
            'login_token': $('form.register-page-login [name="token"]').val()
        },
        dataType: 'json',
        success: function(response){
            $('form.register-page-login [name="token"]').val( response.token );
            //console.log(response);
            $('.frontend-login-form').val("Login");
            if(response.status == 1){
                window.location.replace(base_url+"/home");
            }else if(response.status == 0 && response.on_hold){
                // $('form').hide();
                // $('#on-hold-message').show();
                $('.login_failed').html("Login Failed");
                alert('You have exceeded the maximum number of login attempts.');
            }else if(response.status == 0 && response.count){
                alert('Failed login attempt ' + response.count + ' of ' + $('#max_allowed_attempts').val());
                $('.login_failed').html("Login Failed");
            }
        }
    });
    return false;
  });

  // update product
  $('.cart-plus-minus.cart-page').on('click', '.qtybutton', function(){
    cart_update_fragement();
  });
  $('.cart-plus-minus.cart-page').on('change', '.cart-plus-minus-box', function(){
    cart_update_fragement();
  });

  //remove cart
  $('#mini_cart').on('click','.mycart-item-edit a.item-delete', function(){
    var product_id = $(this).attr('data-product');
    var rowid = $(this).attr('data-rowID');

    $(this).parents('.mycart-item-edit').prepend('<span style="position: absolute;margin-left: 0px; display: block; margin-top: 0px;" class="loader"></span>');
    $.ajax({
      method: "POST",
      url: base_url + "pcart/update",
      data: { product_id: product_id, rowid: rowid, qty: 0 },
    }).done(function(data){
        var result = $.parseJSON(data);
        if(result.cart_success)
        {
          $('.mycart-item-edit .loader').remove();
          get_update_cart_fragment();

          setTimeout(function () {
            $('.top-mycart .top-mycart-overlay').css({
              'visibility': '',
              'transform' : ''
            });
          }, 5000);
        }
     });
  });


  // add-to-cart
	$(".product-quantity form.addToCart").submit(function(e) {
		e.preventDefault();
		// Get the product ID and the quantity
		var id = $(this).find('input[name=product_id]').val();
		var qty = $(this).find('input[name=qtybutton]').val();
		// console.log(qty);
    if( qty == 0 ) return;
    $('form.addToCart .pro-add-to-cart p input[type="submit"]').attr('value', 'Loading...');
    $('form.addToCart .pro-add-to-cart p').append('<span style="position: absolute;margin-left: 125px; display: block; margin-top: -25px;" class="loader"></span>');

    $.ajax({
      method: "POST",
      url: base_url + "pcart/add",
      data: { product_id: id, quantity: qty, ajax: '1' }
    }).done(function(data){
      var result = $.parseJSON(data);
    	if(result.cart_success)
      {
        $('form.addToCart .pro-add-to-cart p .loader').remove();
        $('form.addToCart .pro-add-to-cart p input[type="submit"]').attr('value', 'Add to Cart');
        jQuery('html, body').animate({scrollTop: 0}, 1000);
        get_update_cart_fragment();

        setTimeout(function () {
          $('.top-mycart .top-mycart-overlay').css({
            'visibility': '',
            'transform' : ''
          });
        }, 5000);

      }
		});

		return false; // Stop the browser of loading the page defined in the form "action" parameter.
	});

  function cart_update_fragement()
  {
    var product_id = $('.cart-plus-minus input.cart-plus-minus-box').attr('data-product');
    var qty = $('.cart-plus-minus input.cart-plus-minus-box').val();
    var rowid = $('.cart-plus-minus input.cart-plus-minus-box').attr('data-rowID');

    $.ajax({
      method: "POST",
      url: base_url + "pcart/update",
      data: { product_id: product_id, rowid: rowid, qty: qty },
    }).done(function(data){
        var result = $.parseJSON(data);
        if(result.cart_success)
        {
          location.reload();
        }
     });
    // alert(rowid);
  }

  function get_update_cart_fragment()
  {
    $.ajax({type: "GET", url: base_url + "pcart/update_cart_fragment"}).done(function(d){
      // alert(d);
      $('#mini_cart').html('');
      $('#mini_cart').html(d);
      $('.top-mycart .top-mycart-overlay').css({
        'visibility': 'visible',
        'transform' : 'scaleY(1)'
      });
    });
  }

  // sidebar share slider
  $('.sidebar_carosel').bxSlider({
    mode: 'vertical',
    slideWidth: 300,
    minSlides: 10,
    slideMargin:5,
  });

  /*----- New Product Carousel -----*/
  $(".new_product_carosel").owlCarousel({
    slideSpeed : 1000,
    items : 4,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [991,3],
    itemsTablet: [767,3],
    itemsMobile : [480,3],
    autoPlay: true,
    navigation: true,
    pagination: false,
    navigationText:['<i class="fa fa-angle-left owl-prev-icon"></i>','<i class="fa fa-angle-right owl-next-icon"></i>']
  });

  //TinyMCE Active code
  $('.textarea_editor_billing').wysihtml5();
  $('.textarea_editor_shipping').wysihtml5();

  //Expand Billing Address Input Field
  $("#billing_address_expand").css("display","none");
  $(".billing_address_button").click(function(){
    $("#billing_address_expand").slideToggle(300);
  });

  //Expand Shipping Address Input Field
  $("#shipping_address_expand").css("display","none");
  $(".shipping_address_button").click(function(){
    $("#shipping_address_expand").slideToggle(300);
  });

  //My Payment Data Table Active Code
  $('#customer_payment_table').DataTable();

  // active add class
  $('.tab-product-area .bestseller-sec-heading ul.product-nav > li:first-child').addClass('active');
  $('.tab-product-area .tab-pane:first-child').addClass('active');

/*---------Modal------------*/

// $('#popupModal .popup-modal-close').on('click', function () {
//     alert('ok');
//     $('#popupModal .modal-content').text('');
// });

/*---------Password Hint------------*/
$('.error.passwordError').focus(function() {
  $(this).parent().find('.alert-danger.error-msg').hide();
});
$('#popover_active').popover({
  html      : true,
  placement : "bottom",
  trigger   : 'focus',
  title     : 'Password Hint',
  content   : "<ul class='password-hint'> <li>At least 8 characters<li><li>Not more than 72 characters</li><li>One number</li><li>One lower case letter</li><li>One upper case letter</li><li>No spaces, tabs, or other unseen characters</li><li>No backslash, apostrophe or quote characters</li> </ul>"
});
/*----- left category menu-----*/
	$('.cat-toggle-heading').on( "click", function(){
		$('.left-category-menu').slideToggle(600);
	});
	$('.more-cat').on( "click", function(){
		$('.extra_menu').slideToggle(500);
		if ($(".more-cat .more-view").hasClass('open')) {
			$(".more-cat .more-view").removeClass('open');
			$(".more-cat .more-view").text('More Categories');
		} else {
			$(".more-cat .more-view").addClass('open');
			$(".more-cat .more-view").text('Close Menu');
		}
	});

/*-----fliker image-----*/
	$(".fliker_img").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	800,
		'speedOut'		:	200,
		'overlayShow'	:	false
	});

/*----- price range ui slider js -----*/
	$( "#price-range" ).slider({
		range: true,
		min: 1,
		max: 100,
		values: [ 10, 90 ],
		slide: function( event, ui ) {
			jQuery( "#slidevalue" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		}
	});
	jQuery( "#slidevalue" ).val( "$" + $( "#price-range" ).slider( "values", 0 ) +
		"      $" + $( "#price-range" ).slider( "values", 1 ) );

/*----- scroll to top -----*/
	$(window).scroll(function(){
		if ($(this).scrollTop() > 700) {
			$('.greentech-scrollertop').fadeIn(700);
		} else {
			$('.greentech-scrollertop').fadeOut(700);
		}
	});
	//Click event to scroll to top
	$('.greentech-scrollertop').on( "click", function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

/*----- main slider -----*/
	$('#mainSlider').nivoSlider({
		directionNav: true,
		animSpeed: 500,
		slices: 18,
		pauseTime: 5000,
		pauseOnHover: false,
		controlNav: false,
		prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>',
		nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
	});

/*----- home1 sidebar featured pruduct -----*/
	$(".featured-product").owlCarousel({
		slideSpeed : 1000,
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall : [991,2],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 new pruduct -----*/
	$(".new-product").owlCarousel({
		slideSpeed : 1000,
		items : 3,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [991,2],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 end of day pruduct -----*/
	$(".deal-of-day-product").owlCarousel({
		slideSpeed : 1000,
		items : 2,
		itemsDesktop : [1199,2],
		itemsDesktopSmall : [991,1],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 end of day pruduct -----*/
	$(".deal-of-day-product-h3").owlCarousel({
		slideSpeed : 1000,
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall : [991,1],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 end of day pruduct -----*/
	$(".product-carousel-1, .product-carousel-2, .product-carousel-3, .product-carousel-4, .product-carousel-5, .product-carousel-6, .product-carousel-7").owlCarousel({
		slideSpeed : 1000,
		items : 5,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [991,2],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 end of day pruduct -----*/
	$(".product-carousel-1-h3, .product-carousel-2-h3, .product-carousel-3-h3").owlCarousel({
		slideSpeed : 1000,
		items : 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [991,2],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 latest post -----*/
	$(".latest-post-area").owlCarousel({
		slideSpeed : 1000,
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall : [991,1],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- home1 latest post -----*/
	$(".client-carousel").owlCarousel({
		slideSpeed : 1000,
		items : 6,
		itemsDesktop : [1199,5],
		itemsDesktopSmall : [991,3],
		itemsTablet: [767,2],
		itemsMobile : [479,1],
		autoPlay: true,
		navigation: false,
		pagination: false,
		navigationText:['<i class="fa fa-caret-left owl-prev-icon"></i>','<i class="fa fa-caret-right owl-next-icon"></i>']
	});

/*----- sidebar best seller carousel -----*/
	$(".thubm-caro").owlCarousel({
		slideSpeed : 1000,
		items : 4,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [991,3],
		itemsTablet: [767,3],
		itemsMobile : [480,3],
		autoPlay: true,
		navigation: true,
		pagination: false,
		navigationText:['<i class="fa fa-angle-left owl-prev-icon"></i>','<i class="fa fa-angle-right owl-next-icon"></i>']
	});

/*----- about pager testimonial -----*/
	$(".what-client-say").owlCarousel({
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall : [991,1],
		itemsTablet: [767,1],
		itemsMobile : [480,1],
		autoPlay: true,
		navigation: false,
		pagination: true,
		singleItem : true,
		transitionStyle : "backSlide"
	});

/*----- elevateZoom -----*/
	$("#optima_zoom").elevateZoom({gallery:'optima_gallery', cursor: 'pointer', galleryActiveClass: "active", imageCrossfade: true, loadingIcon: ""});

		$("#optima_zoom").bind("click", function(e) {
		  var ez =   $('#optima_zoom').data('elevateZoom');
		  ez.closeAll(); //NEW: This function force hides the lens, tint and window
			$.fancybox(ez.getGalleryList());
		  return false;
		});

/*----- cart-plus-minus-button -----*/
	 $(".cart-plus-minus").append('<div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>');
	  $(".qtybutton").on("click", function() {
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
		  var newVal = parseFloat(oldValue) + 1;
		} else {
		   // Don't allow decrementing below zero
		  if (oldValue > 0) {
			var newVal = parseFloat(oldValue) - 1;
			} else {
			newVal = 0;
		  }
		  }
		$button.parent().find("input").val(newVal);
	  });

/*----- countdown -----*/
    $('[data-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');
      $this.countdown(finalDate, function(event) {
      $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Min</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Sec</p></span>'));
      });
    });

/*-----mobile menu -----*/
	$('.mobile-menu').meanmenu();

})(jQuery);
