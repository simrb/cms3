
$(document).ready( function() {

	// detail image
	hide_btn();

	$('.show-detail-body').mouseleave(function(){
		hide_btn();
	});

	$('.adm_btn').mouseover(function(){
		$(this).parent().find('.edit_btn').show();
		//$(this).parent().find('.del_btn').show();
		$(this).parent().find('.mv_btn').show();
		$(this).parent().find('.useful_btn').show();
	});

	$('.adm_btn').click(function(){
		$(this).parent().find('.edit_btn').toggle();
		//$(this).parent().find('.del_btn').toggle();
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
		//display_txt += "<input type='button' value='update' class='update_btn right' />";
		//display_txt += "<input type='button' value='cancel' class='cancel_btn' /></div>";
		display_txt += "<img src='view/img/10.png' class='update_btn right' />";
		display_txt += "<img src='view/img/9.png' class='cancel_btn' /></div>";

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
		$('.update_btn').css({'width':'20px', 'height':'20px', 'margin-right':'5px'});
		$('.cancel_btn').css({'width':'20px', 'height':'20px'});

		// set editor value
		var pre_txt = pre_btn.attr('org_val');
		display_btn.find('textarea').val(pre_txt);

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
				pre_btn.html(parse_html(pre_txt_new));
				pre_btn.attr('org_val', pre_txt_new);
				show_tip(pre_btn.find('.show-pre'), pre_btn.find('.show-user'));
				show_img();

				// update remote
				$.ajax({
					url: "index.php?_a=ajax_addpost&rid=" + rid,
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
		var hl_val = $('.menu_hl').find('a').attr('cid');

		var menu_txt = '<option value=""> -- </option>';
		$('.menu_item').find('a').each(function(i) {
			var c_val = $(this).attr('cid');
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
					url: "index.php?cid=" + valueSelected + "&_a=ajax_movepost&rid=" + rid,
				}).done(function(msg) {
					//console.log(msg);
					show_msg(msg, mv_btn);
				});
			}
		});
	});


	// useful style
	$(".show-detail-body").hover(function () {
		$(this).find(".useful_no, .re_btn, .top_btn").css('color', 'gray');
		$(this).find(".adm_btn label").css('color', 'gray');
	}, function () {
		$(this).find(".useful_no, .re_btn, .top_btn").css('color', '');
		$(this).find(".adm_btn label").css('color', '');
	});

	// useful event
	$(".useful_view").click(function () {
		var use_btn = $(this);
		var use_num	= use_btn.find('span').text();
		$.ajax({
			url: use_btn.attr('use_url'),
		}).done(function(msg) {
			if (msg != 0) {
				use_btn.find('span').text(msg);
				use_btn.removeClass('useful_no');
				use_btn.addClass('useful_hl');
				use_btn.css('color', '');
				use_btn.find('img').attr('src', 'view/img/12.png');
			}
		});
	});


	// top event
	$(".top_btn").click(function () {
		var top_btn = $(this);
		var rid = top_btn.attr('rid');
		var uid = top_btn.attr('uid');
		$.ajax({
			url: "index.php?_a=ajax_totop&rid=" + rid + "&uid=" + uid,
		}).done(function(msg) {
			if (msg != 0) {
				show_msg(msg, top_btn);
			}
		});
	});


	// menu bar for detail page
	var v_val = $(".menu_item").attr('_v');
	if (v_val == 'detail') {
		$(".menu_item").find('.menu_no').hide();
		//$(".menu_item").css('padding-bottom', '15px');
		//$(".addpost").css('float', 'right');
		//$(".addpost").hide();
		var menu_title 	= $(".show-detail-body").first().find('pre').text();
		var menu_leng	= ($(window).width() < 400) ? 12 : 30;
		menu_title = '<span class="menu_title"> >> ' + parse_menu(menu_title.substring(0,menu_leng)) + '...</span>';
		$(".menu_hl").after(menu_title);
		// console.log(menu_title);
	}


	// menu title
	$('.menu_no, .menu_hl').each(function (i) {
		$(this).find('a').attr('title', '');
	});


	// reply event
	$('.re_btn, .top_btn, .adm_btn').css('cursor', 'pointer');
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
	/*
	$('.re_btn').hover(function () {
		$(this).parent().next('pre').css({'background':'#d7e1c3', 'border':'1px solid gray'});
	}, function(){
		$(this).parent().next('pre').css({'background':'', 'border':''});
	});
	*/


	// interpret event for pre element
	$('pre, .list-body').each(function(i){
		var pre_txt = $(this).text();
		$(this).attr('org_val', pre_txt);
		$(this).html(parse_html(pre_txt));
	});
	show_tip($('.show-pre'), $('.show-user'));
	show_img();

	function show_tip(oj, uj) {
		$(oj).on('click mouseover', function(){
			if ($('.tip_box').length) {
				$('.tip_box').remove();
			} else {
				draw_pre($(this));
			}
		});

		//console.log(uj.selector); // return .show-user
		$(uj).on('click', function(){
			if ($('.tip_box').length) {
				$('.tip_box').remove();
			} else {
				draw_user($(this));
			}
		});

		$(oj).on('mouseleave mouseout', function(){
			if ($('.tip_box')) {
				$('.tip_box').remove();
			}
		});
	}

	function draw_pre (oj) {
		var rid_sign = oj.attr('href');
		// get value in local
		var rid_txt = '';
		if ($(rid_sign).length) {
			rid_txt = $(rid_sign).parent().next('pre').text();
			draw_box(rid_txt, oj);

		// if not, from remote
		} else {
			$.ajax({
				url: "index.php?_a=ajax_getpost&rid=" + rid_sign.substr(2),
			}).done(function(msg) {
				rid_txt = msg;
				draw_box(msg, oj);
			});
		}
	}

	function draw_user (oj) {
		var uid_sign = oj.attr('href');
		$.ajax({
			url: "index.php?_a=ajax_getuser&uid=" + uid_sign.substr(2),
		}).done(function(msg) {
			//console.log(msg);
			draw_box(msg, oj);
		});
	}

	function draw_box(rid_txt, oj) {
		// set value
		rid_txt = $.trim(rid_txt);
		if (rid_txt != '') {
			var tip_box = '<div class="tip_box">' + rid_txt.substring(0, 60) + '</div>';
			oj.parent().before(tip_box);

			// style
			//var tip_pos = oj.position();
			var tip_pos = oj.offset();
			var box_top = tip_pos.top + 15
			var box_left = tip_pos.left
			$('.tip_box').css({
				'position'	:	'absolute',
				'top'		:	box_top,
				'left'		:	box_left,
				'index-z'	:	99,
				'background':	'rgb(198, 228, 212)',
				'padding'	:	'5px',
				'border'	:	'1px solid gray',
			});
		}
	}

	function parse_html (txt) {
		var rev = txt;

		var regs = [
			{ reg : /</g, rep : "&lt;"},
			{ reg : />/g, rep : "&gt;"},
			//{ reg : /&/g, rep : "amp"},
			//{ reg : /"/g, rep : "quot"},
			{ reg : /b#(.*?)#/g, rep : "<b>$1</b>"},
			{ reg : /i#(.*?)#/g, rep : "<i>$1</i>"},
			{ reg : /r#([0-9]+)/g, rep : "<a href='#r$1' class='show-pre' >r#$1</a>"},
			{ reg : /u#([0-9]+)/g, rep : "<a href='#u$1' class='show-user' >u#$1</a>"},
			{ reg : /img#([a-zA-Z]+:\/\/[^\s]*)#/g, rep : "<img src='$1' />"},
			{ reg : /url#([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<a href='$1' target='_blank' >$1</a>"},
			{ reg : /url#(.*?)@([a-zA-Z]+:\/\/[^\s]*)/g, rep : "<a href='$2' target='_blank' >$1</a>"},
			{ reg : /vid#(https:\/\/www\.fantasy\.tv\/)([^\s]*)#/g, rep : "<embed src='$1$2' ></embed>"},
			{ reg : /vid2#([a-zA-Z]+:\/\/[^\s]*)#/g, rep : "<video src='$1' controls=''></video>"},
		];

		// bad tag
		var regs2 = [
			{ reg : /img#([a-zA-Z]+:\/\/[^\s]*)/g, rep : ""},
			{ reg : /url#([a-zA-Z]+:\/\/[^\s]*)/g, rep : ""},
			{ reg : /url#(.*?)@([a-zA-Z]+:\/\/[^\s]*)/g, rep : ""},
			{ reg : /vid#(https:\/\/www\.fantasy\.tv\/)([^\s]*)/g, rep : ""},
			{ reg : /vid2#([a-zA-Z]+:\/\/[^\s]*)/g, rep : ""},
		];

		$.each(regs, function(i, val){
			rev = rev.replace(val.reg, val.rep);
		});

		$.each(regs2, function(i, val){
			rev = rev.replace(val.reg, val.rep);
		});

		return rev;
	}

	function parse_menu (txt) {
		var regs = [
			{ reg : /</g, rep : "&lt;"},
			{ reg : />/g, rep : "&gt;"},
		];

		var rev = txt;
		$.each(regs, function(i, val){
			rev = rev.replace(val.reg, val.rep);
		});

		return rev;
	}

	function show_msg (msg, oj) {
		oj.parent().after('<div class="msg clear"><span>' + msg + '</span></div>');
		$('.msg span').css('float', 'right');
		$('.msg').css({
					'background':	'rgb(198, 228, 212)',
					'padding'	:	'5px',
					'border'	:	'1px solid gray',
					'height'	:	'20px',
					'width'		:	'100%',
					'color'		:	'#ef1818',
		});

		setTimeout(function () {
			$(".msg").remove();
		}, 2300);
		hide_btn();
	}

	function hide_btn () {
		$('.edit_btn').hide();
		//$('.del_btn').hide();
		$('.mv_btn').hide();
		$('.useful_btn').hide();
	}
	
	function show_img () {
		$('.show-detail pre img').css('cursor', 'pointer');
		$('.show-detail pre img').click(function () {

			if ($(this).attr('org_width')) {
				$(this).css('width', $(this).attr('org_width'));
				$(this).removeAttr('org_width');
			} else {
				$(this).attr('org_width', $(this).width());
				$(this).css('width', '100%');
				//console.log($(this).width());
			}

		});
	}


});


