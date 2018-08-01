
$(document).ready( function() {

	$(".edit_btn").click(function(e) {
		
		// default vars
		e.preventDefault();
		var edit_btn = $(this);
		var pre_btn = edit_btn.next('pre');
		pre_btn.hide();
		edit_btn.hide();

		// set the editor
		var pre_txt = $(this).next().text();
		var display_txt = "<div class='clear display_btn'><textarea>" + pre_txt + "</textarea>";
		display_txt += "<input type='button' value='update' class='update_btn' />";
		display_txt += "<input type='button' value='cancel' class='right cancel_btn' /></div>";

		$(this).after(display_txt);
		var display_btn = edit_btn.next('.display_btn');

		// set height of editor
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
			var rid = pre_btn.attr('rid');
			pre_txt = display_btn.find('textarea').val();
			pre_btn.html(pre_txt);
			edit_btn.show();
			pre_btn.show();
			display_btn.remove();

			// send pre_txt to server
			$.ajax({
				url: "?_a=ajax_addpost&rid=" + rid,
				data: {'pre_txt': pre_txt},
			}).done(function(msg) {
				//console.log(msg);
			});
		});
		// end

	});


});


