
$(document).ready( function() {

	// edit event
	$(".edit_btn").click(function(e) {
		
		// default vars
		e.preventDefault();
		var edit_btn = $(this);
		var pre_btn = edit_btn.parent().next('pre');
		var rid = pre_btn.attr('rid');
		//pre_btn.hide();
		edit_btn.hide();

		// set the editor
		var display_txt = "<div class='clear display_btn'><textarea></textarea>";
		display_txt += "<input type='button' value='update' class='update_btn' />";
		display_txt += "<input type='button' value='cancel' class='right cancel_btn' /></div>";

		$(this).after(display_txt);
		var display_btn = edit_btn.next('.display_btn');

		// set editor style
		var display_height = pre_btn.height();
		if (parseInt(display_height) < 60) {
			display_height = 100;
		}
		display_btn.find('textarea').css({'height': display_height});

		// set editor value
		var pre_txt = $(this).next().text();
		$.ajax({
			url: "?_a=ajax_getpost&rid=" + rid,
		}).done(function(msg) {
			pre_txt = msg;
			display_btn.find('textarea').val(pre_txt);
			//console.log(msg);
		});

		// cancel event
		$(".cancel_btn").click(function() {
			edit_btn.show();
			pre_btn.show();
			display_btn.remove();
		});

		// update event
		$(".update_btn").click(function() {
			var pre_txt_new = display_btn.find('textarea').val();
			pre_btn.html(pre_txt_new);
			edit_btn.show();
			pre_btn.show();
			display_btn.remove();

			// send data to server
			if (pre_txt != pre_txt_new) {
				$.ajax({
					url: "?_a=ajax_addpost&rid=" + rid,
					data: {'pre_txt': pre_txt_new},
				}).done(function(msg) {
					//console.log(msg);
				});
			}
		});

	});


	// deleted event
	$(".del_btn").click(function(e) {
		var reval = confirm('Are you sure ?');
		if (!reval) {
			e.preventDefault();
		}
	});


	// rate event
	$(".rate_btn").click(function(e) {
		e.preventDefault();
		var rate_btn = $(this);
		var reval = prompt('rate to : ');
		var rid	= rate_btn.attr('rid');

		// post to server
		if (reval != null && reval != '') {
			$.ajax({
				url: "?_a=ajax_rateto&rid=" + rid,
				data: {'rate_val': reval},
			}).done(function(msg) {
				rate_btn.find('span').text(reval);
				//console.log(msg);
			});
		}
	});


	// menu event
	var v_val = $(".menu_item").attr('_v');
	if (v_val == 'detail') {
		$(".menu_item").find('.menu_no').hide();
		var menu_title 	= $(".show-detail-body").first().find('pre').text();
		var menu_leng	= ($(window).width() < 400) ? 12 : 30;
		menu_title = '<span class="menu_title"> >> ' + menu_title.substring(0,menu_leng) + '...</span>';
		$(".menu_hl").after(menu_title);
		// console.log(menu_title);
	}





});


