
$(document).ready(function(){
	var base_url = $('span.site_url').text();

	// menu page
	$('#pageSelect').change(function(event) {
		var pageID = $(this).val();
		var permalink = $('option:selected', this).attr('data-permalink');

		$('#permalink').val(permalink);
		$('.submitMenu').attr('disabled', true);
		if( pageID != ' ') { $('.submitMenu').attr('disabled', false); }

		$('#setMenuParent').html('');
		$.ajax({
				type: 'post',
				cache: false,
				url: base_url + 'dashboard/menus/get_parent_page',
				data: {
						'pageID': pageID
				},
				dataType: 'json',
				success: function(response){
					if( response.success === 1 )
					{
						$('#setMenuParent').append(response.data);
					}
					else {
						$('#setMenuParent').html('');
					}
				}
		});

	});

	$(window).on('change','.ajax_trigger_p',function(){
	// $('.ajax_trigger_p select').on('change', function(event) {
		var pageID = $(this).val();
		var subject_id = $('option:selected', this).attr('value');
		$('#subject_ajax_output').html('');
		$.ajax({
			type: 'post',
			cache: false,
			url: base_url + 'marksheet/get_subject_by_ajax',
			data: {
					'subject_id': subject_id
			},
			dataType: 'json',
			success: function(response){
				if( response.success === 1 )
				{
					$('#subject_ajax_output').append(response.data);
				}
				else {
					$('#subject_ajax_output').html('');
				}
			}
		});
	});

	// // ajax for marks distribution
	// $('.ajax_trigger_p select').on('change', function(event) {
	// 	var subject_id = $('option:selected', this).attr('value');
	// 	var class_id = $('option:selected', '.class_ajax_trigger').attr('value');
	// 	$("#marks_distribution_output").fadeOut('slow');
	// 	$.ajax({
	// 		type: 'post',
	// 		cache: false,
	// 		url: base_url + 'marksheet/get_subject_marks_distribution',
	// 		data: {
	// 				'subject_id': subject_id,
	// 				'class_id': class_id 
	// 		},
	// 		success: function(html){
	// 			// alert(html);
	// 			$("#marks_distribution_output").html(html);	
	// 			$("#marks_distribution_output").fadeIn('slow');
	// 		}
	// 	});
	// });

	// ajax for save or update
	// $('table td > .update').hover(function(event)
	// {
	// 	// var first_ex = $('#first_ex').attr('value');
	// 		alert("palash");
	// 	// $("#marks_distribution_output").fadeOut('slow');
	// 	// $.ajax({
	// 	// 	type: 'post',
	// 	// 	cache: false,
	// 	// 	url: base_url + 'marksheet/get_subject_marks_distribution',
	// 	// 	data: {
	// 	// 			'subject_id': subject_id,
	// 	// 			'class_id': class_id 
	// 	// 	},
	// 	// 	success: function(html){
	// 	// 		// alert(html);
	// 	// 		$("#marks_distribution_output").html(html);	
	// 	// 		$("#marks_distribution_output").fadeIn('slow');
	// 	// 	}
	// 	// });
	// });


	// Ajax file upload
	$('.upload_product_image .product_image').on('change', function(e) {
		e.preventDefault();
		var url 	= base_url + 'media/do_upload';
		var image = $('.upload_product_image input#multiple_file');

		var image_data = image[0].files;
		if( image_data.length <= 0 ){
			alert('Select Image');
		}
		else {
			$('.img_preview').html('<img class="loading" src="'+ base_url + 'public/backend/img/loading/loader.gif" alt="image" />');

			var formData = new FormData();
			for( var i = 0; i < image_data.length; i++ )
			{
				var file_data = image_data[i];
				formData.append("file_data[]", file_data, file_data.name);
			}
			$.ajax({
				mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
				url: url,
				data: formData,
				processData:false,
				contentType:false,
				type: 'POST',
				success: function(data) {
					var result = $.parseJSON(data);
					if( result.status === 1 )
					{
						$('.img_preview').html("");
						// var img = '<figure><img src="'+ base_url + 'uploads/' + result.url +'" alt="image" /></figure><button type="button" class="btn btn-danger remove-product-img" data-link="'+ 'uploads/' + result.url +'" name="button">Remove</button>';
						$('.img_preview').html(result.lists);
						$('.product_image_url').val(result.url);
					}
					else{
						$('.img_preview').html('<span>'+ result.msg +'</span>');
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				},
				dataType: "html",
				async: false
			});

		}

	});

	// remove product image
	$('body').on('click', '.remove-product-img', function(){
		if( confirm('Are you sure to remove this image') ){
			var imgName = $(this).attr('data-link');
			var url 		=	base_url + 'media/do_upload';
			var selector	=	$(this);
			var imgSet		=	$('.product_image_url').val();

			var formData = new FormData();
			formData.append('imgName', imgName);
			formData.append('imgSet', imgSet);
			$.ajax({
				mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
				url: url,
				data: formData,
				processData:false,
				contentType:false,
				type: 'POST',
				success: function(data) {
					var result = $.parseJSON(data);
					if( result.status === 1 )
					{
						selector.parent('li').fadeOut('slow');
						// need to check others url
						$('.product_image_url').val(result.newImgSet);
					}
					else{
						console.log(data);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
				},
				dataType: "html",
				async: false
			});

		}
	});

	// === Sidebar navigation === //

	$('.submenu > a').click(function(e)
	{
		e.preventDefault();
		var submenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		var submenus = $('#sidebar li.submenu ul');
		var submenus_parents = $('#sidebar li.submenu');
		$('.submenu > a .has-dropdown').addClass('icon-plus');
		$('.submenu > a .has-dropdown').removeClass('icon-minus');
		if(li.hasClass('open'))
		{
			$(this).find('.has-dropdown').addClass('icon-plus');
			$(this).find('.has-dropdown').removeClass('icon-minus');

			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenu.slideUp();
			} else {
				submenu.fadeOut(250);
			}
			li.removeClass('open');
		} else
		{
			$(this).find('.has-dropdown').addClass('icon-minus');
			$(this).find('.has-dropdown').removeClass('icon-plus');

			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenus.slideUp();
				submenu.slideDown();
			} else {
				submenus.fadeOut(250);
				submenu.fadeIn(250);
			}
			submenus_parents.removeClass('open');
			li.addClass('open');
		}
	});

	var ul = $('#sidebar > ul');

	$('#sidebar > a').click(function(e)
	{
		e.preventDefault();
		var sidebar = $('#sidebar');
		if(sidebar.hasClass('open'))
		{

			sidebar.removeClass('open');
			ul.slideUp(250);
		} else
		{
			sidebar.addClass('open');
			ul.slideDown(250);
		}
	});

	// === Resize window related === //
	$(window).resize(function()
	{
		if($(window).width() > 479)
		{
			ul.css({'display':'block'});
			$('#content-header .btn-group').css({width:'auto'});
		}
		if($(window).width() < 479)
		{
			ul.css({'display':'none'});
			fix_position();
		}
		if($(window).width() > 768)
		{
			$('#user-nav > ul').css({width:'auto',margin:'0'});
            $('#content-header .btn-group').css({width:'auto'});
		}
	});

	if($(window).width() < 468)
	{
		ul.css({'display':'none'});
		fix_position();
	}

	if($(window).width() > 479)
	{
	   $('#content-header .btn-group').css({width:'auto'});
		ul.css({'display':'block'});
	}

	// === Tooltips === //
	$('.tip').tooltip();
	$('.tip-left').tooltip({ placement: 'left' });
	$('.tip-right').tooltip({ placement: 'right' });
	$('.tip-top').tooltip({ placement: 'top' });
	$('.tip-bottom').tooltip({ placement: 'bottom' });

	// === Search input typeahead === //
	$('#search input[type=text]').typeahead({
		source: ['Dashboard','Form elements','Common Elements','Validation','Wizard','Buttons','Icons','Interface elements','Support','Calendar','Gallery','Reports','Charts','Graphs','Widgets'],
		items: 4
	});

	// === Fixes the position of buttons group in content header and top user navigation === //
	function fix_position()
	{
		var uwidth = $('#user-nav > ul').width();
		$('#user-nav > ul').css({width:uwidth,'margin-left':'-' + uwidth / 2 + 'px'});

        var cwidth = $('#content-header .btn-group').width();
        $('#content-header .btn-group').css({width:cwidth,'margin-left':'-' + uwidth / 2 + 'px'});
	}

	// === Style switcher === //
	$('#style-switcher i').click(function()
	{
		if($(this).hasClass('open'))
		{
			$(this).parent().animate({marginRight:'-=190'});
			$(this).removeClass('open');
		} else
		{
			$(this).parent().animate({marginRight:'+=190'});
			$(this).addClass('open');
		}
		$(this).toggleClass('icon-arrow-left');
		$(this).toggleClass('icon-arrow-right');
	});

	$('#style-switcher a').click(function()
	{
		var style = $(this).attr('href').replace('#','');
		$('.skin-color').attr('href','css/maruti.'+style+'.css');
		$(this).siblings('a').css({'border-color':'transparent'});
		$(this).css({'border-color':'#aaaaaa'});
	});

	$('.lightbox_trigger').click(function(e) {

		e.preventDefault();

		var image_href = $(this).attr("href");

		if ($('#lightbox').length > 0) {

			$('#imgbox').html('<img src="' + image_href + '" /><p><i class="icon-remove icon-white"></i></p>');

			$('#lightbox').slideDown(500);
		}

		else {
			var lightbox =
			'<div id="lightbox" style="display:none;">' +
				'<div id="imgbox"><img src="' + image_href +'" />' +
					'<p><i class="icon-remove icon-white"></i></p>' +
				'</div>' +
			'</div>';

			$('body').append(lightbox);
			$('#lightbox').slideDown(500);
		}

	});


	$('#lightbox').live('click', function() {
		$('#lightbox').hide(200);
	});

});

$(window).load(function(){

	// nav menu activation
	// List inside list
	var pgurl = window.location.href.substr(window.location.href);
	$('#sidebar ul li.submenu ul li a').each(function(){
		if( $(this).attr("href") == pgurl ){
			$(this).parent().parent().show();
			$(this).addClass('activeItem');
			$(this).parent().parent().parent().find('.has-dropdown').addClass('icon-minus');
			$(this).parent().parent().parent().find('.has-dropdown').removeClass('icon-plus');
			$(this).parents('li.submenu').addClass('active open');
		}

	});

	// Single List
	$('#sidebar > ul > li > a').each(function(){
		if( $(this).attr("href") == pgurl ){
			$(this).parent().addClass('active open');
		}

	});

	// change text to icon
	if( $(window).width() < 480 ) {
		$('table.dataTable td.action.taskOptions button.btn-warning').html('<i class="icon icon-zoom-in"></i>');
		$('table.dataTable td.action.taskOptions button.btn-danger').html('<i class="icon icon-trash"></i>');
	}
});