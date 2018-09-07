//$.mobile.page.prototype.options.domCache = false;
//$.mobile.autoInitializePage = false;

$(document).bind("pagecreate", function(e) {  
    $( "input, textarea, select", e.target ).attr( "data-" + $.mobile.ns + "role", "none" );
    $( "a", e.target ).attr( "data-" + $.mobile.ns + "ajax", "false" ); 
});


$(document).ready( function() {

	// remove default style of form
	$("form").attr("data-ajax", "false");
	$("input").attr("data-role", "none");
	$("select").attr("data-role", "none");

	// submit event
	$(".vaild-form").submit(function(e) {
		var arrText= new Array();
		var txt_btn = $(this).find('textarea');

		if (txt_btn.length > 0) {
			arrText.push(txt_btn.val());
		}

		$('input[type=text]').each(function(){
			arrText.push($(this).val());
		});

		$.each(arrText, function( index, value ) {
			var text_val = $.trim(value);
			if (!text_val) {
				e.preventDefault();
				alert('Do not allow null values.');
				return false;
				//console.log(text_val);
			}
		});
	});

	// msg event
	var msg_txt = $('#msg').text();
	if (msg_txt != '') {
		$('#msg').css({
					'background':	'rgb(198, 228, 212)',
					'padding'	:	'5px',
					'border'	:	'1px solid gray',
		});
	}
	setTimeout(function () {
		//$("#msg").css('margin', '15px 0');
		$("#msg").remove();
	}, 6000);

	// validate code
	var vcode_img = $('.vcode_img');
	if (vcode_img.length > 0) {
		vcode_img.css("cursor", "pointer");
		vcode_img.attr("src", "?_m=admin&_f=user&_v=getvcode");
	}


});


