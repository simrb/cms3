
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

		// cancel event
		$(".cancel_btn").click(function() {
			edit_btn.show();
			pre_btn.show();
			display_btn.remove();
		});

		// update event
		$(".update_btn").click(function() {
		});

	});


});


