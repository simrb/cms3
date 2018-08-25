
$(document).ready( function() {

	/*
	// show and hide event for editor button
	$('.edit_btn').hide();
	$('.del_btn').hide();
	$('.mv_btn').hide();
	$('.useful_btn').hide();
	*/

	hide_btn();

	$('.show-detail-body').mouseleave(function(){
		hide_btn();
	});

	$('.adm_btn').mouseover(function(){
		$(this).parent().find('.edit_btn').show();
		$(this).parent().find('.del_btn').show();
		$(this).parent().find('.mv_btn').show();
		$(this).parent().find('.useful_btn').show();
	});

	$('.adm_btn').click(function(){
		$(this).parent().find('.edit_btn').toggle();
		$(this).parent().find('.del_btn').toggle();
		$(this).parent().find('.mv_btn').toggle();
		$(this).parent().find('.useful_btn').toggle();
	});


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
		display_txt += "<input type='button' value='update' class='update_btn right' />";
		display_txt += "<input type='button' value='cancel' class='cancel_btn' /></div>";

		$(this).after(display_txt);
		var display_btn = edit_btn.next('.display_btn');

		// set editor style
		var display_height = pre_btn.height();
		if (parseInt(display_height) < 60) {
			display_height = 100;
		}
		display_btn.find('textarea').css({'height': display_height});
		display_btn.find('textarea').css({'margin-bottom': '10px'});
		display_btn.css({'margin-bottom': '20px'});

		// set editor value
		//var pre_txt = $(this).next().text();
		var pre_txt = pre_btn.attr('org_val');
		$.ajax({
			url: "?_a=ajax_getpost&rid=" + rid,
		}).done(function(msg) {
			//pre_txt = msg;
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
			edit_btn.show();
			pre_btn.show();
			display_btn.remove();

			// update value
			if (pre_txt != pre_txt_new) {
				// update local
				pre_btn.html(show_bbcode(pre_txt_new));
				pre_btn.attr('org_val', pre_txt_new);

				// update remote
				$.ajax({
					url: "?_a=ajax_addpost&rid=" + rid,
					data: {'pre_txt': pre_txt_new},
				}).done(function(msg) {
					//console.log(msg);
					show_msg(msg, edit_btn);
				});
			}

		});

	});


	// move event
	$(".mv_btn").click(function(e) {
		e.preventDefault();
		var mv_btn = $(this);
		var pre_btn = mv_btn.parent().next('pre');
		var rid = pre_btn.attr('rid');
		var hl_val = $('.menu_hl').find('a').attr('href');

		var menu_txt = '<option value=""> -- </option>';
		$('.menu_item').find('a').each(function(i) {
			var c_val = $(this).attr('href');
			if (c_val == hl_val) {
				menu_txt +=  '<option selected=selected value="' + c_val + '">' + $(this).text() + '</option>';
			} else {
				menu_txt +=  '<option value="' + c_val + '">' + $(this).text() + '</option>';
			}
		});
		menu_txt += '<option value=""> -- </option>';

		var display_txt = '<div class="right mv_txt"><select>' + menu_txt + '</select>';
		display_txt += "</div>";

		// insert text
		mv_btn.parent().before(display_txt);
		$('.mv_txt').css('padding', '0 5px');

		// option change
		$('.mv_txt').find('select').change(function () {
			var optionSelected = $(this).find("option:selected");
     		var valueSelected  = optionSelected.val();
     		var textSelected   = optionSelected.text();
			//console.log(valueSelected + ' ' + textSelected);

			// move record
			$(this).parent().remove();

			// send change to server
			if (valueSelected != '' && valueSelected != hl_val) {
				$.ajax({
					url: valueSelected + "&_a=ajax_movepost",
					data: {'rid': rid},
				}).done(function(msg) {
					console.log(msg);
					show_msg(msg, mv_btn);
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


	// useful event
	$(".useful_btn").click(function(e) {
		e.preventDefault();
		var useful_btn = $(this);
		var reval = prompt('set to : ');
		var rid	= useful_btn.attr('rid');

		// post to server
		if (reval != null && reval != '') {
			$.ajax({
				url: "?_a=ajax_useful&rid=" + rid,
				data: {'useful_val': reval},
			}).done(function(msg) {
				//useful_btn.find('span').text(reval);
				//console.log(msg);
				show_msg(msg, useful_btn);
			});
		}
	});


	// menu event
	var v_val = $(".menu_item").attr('_v');
	if (v_val == 'detail') {
		$(".menu_item").find('.menu_no').hide();
		$(".menu_item").css('padding-bottom', '15px');
		//$(".addpost").css('float', 'right');
		//$(".addpost").hide();
		var menu_title 	= $(".show-detail-body").first().find('pre').text();
		var menu_leng	= ($(window).width() < 400) ? 12 : 30;
		menu_title = '<span class="menu_title"> >> ' + menu_title.substring(0,menu_leng) + '...</span>';
		$(".menu_hl").after(menu_title);
		// console.log(menu_title);
	}


	// reply event
	$('.re_btn').css('cursor', 'pointer');
	$('.re_btn').click(function () {
		var re_val = $(this).attr('reply_sign');
		var re_txt = $('.reply_txt');
		//if (re_txt.val() != '') {
		//	re_val = ' ' + re_val;
		//}
		re_txt.val(re_txt.val() + re_val + ' ');
		re_txt.focus();
		//console.log(re_val);
	});
	$('.re_btn').hover(function () {
		$(this).parent().next('pre').css('background', '#d7e1c3');
	}, function(){
		$(this).parent().next('pre').css('background', '');
	});


	// redisplay pre-txt event
	$('pre, .list-body').each(function(i){
		var pre_txt = $(this).text();
		$(this).attr('org_val', pre_txt);
		$(this).html(show_bbcode(pre_txt));
	});


	function show_bbcode (txt) {
		var regs = [
		//	{ reg : /b#(.*)#/g, rep : "<b>$1</b>"},
			{ reg : /r#([0-9]+)/g, rep : "<a href='#r$1' class='show-pre' >r#$1</a>"},
			{ reg : /u#([0-9]+)/g, rep : "<a href='#u$1' class='show-user' >u#$1</a>"},
			{ reg : /img#([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<img src='$1' />"},
			{ reg : /url#([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<a href='$1' target='_blank' >$1</a>"},
			{ reg : /emb#([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<embed src='$1' />"},
			{ reg : /vid#([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<video src='$1' controls=''></video>"},
		];

		var rev = txt;
		$.each(regs, function(i, val){
			rev = rev.replace(val.reg, val.rep);
		});
		return rev;
	}

	function show_msg (msg, oj) {
		oj.parent().after('<div class="msg clear"><span>' + msg + '</span></div>');
		$('.msg').css('background-color', '#d2e8ed');
		$('.msg').css('color', '#ef1818');
		$('.msg span').css('float', 'right');
		$('.msg').css('padding', '2px 5px');
		$('.msg').css('width', '100%');
		$('.msg').css('height', '20px');
		setTimeout(function () {
			$(".msg").remove();
		}, 2000);
		hide_btn();
	}

	function hide_btn () {
		$('.edit_btn').hide();
		$('.del_btn').hide();
		$('.mv_btn').hide();
		$('.useful_btn').hide();
	}


});


