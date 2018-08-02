
$(document).ready( function() {

	// edit link
	$(".edit_btn").click(function(e) {
		
		// default vars
		e.preventDefault();
		var edit_btn = $(this);
		var pre_btn = edit_btn.next('pre');
		var rid = pre_btn.attr('rid');
		pre_btn.hide();
		edit_btn.hide();

		// get text value from server
		var pre_txt = $(this).next().text();
		$.ajax({
			url: "?_a=ajax_getpost&rid=" + rid,
		}).done(function(msg) {
			pre_txt = msg;
			//console.log(msg);
		});

		// set the editor
		var display_txt = "<div class='clear display_btn'><textarea>" + pre_txt + "</textarea>";
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

			// send pre_txt to server
			if (pre_txt != pre_txt_new) {
				$.ajax({
					url: "?_a=ajax_addpost&rid=" + rid,
					data: {'pre_txt': pre_txt_new},
				}).done(function(msg) {
					console.log(msg);
				});
			}
		});

	});


	// deleted link
	$(".del_btn").click(function(e) {
		var reval = confirm('Are you sure ?')
		if (!reval) {
			e.preventDefault();
		}
	});


});


