// load the file list 
// Example
// put the file_input class to textarea
// 		<textarea name="content" class="file_input" >default value</textarea>
// and then, set the file_list to a div
//		<div class="file_list"></div>
// finailly, join the js file
//		<script type="text/javascript" src="<?= path_res('admin/file.js') ?>"></script>

// $.getScript("file.js");


$(document).ready(function() {
    file_load(1);
});


function file_load(pagecurr) {

    // load the content of file list
    var file_list_html      = "";
    var file_list_url       = "?_r=admin_file_ajaxfilelist";
    var upload_file_path    = "data/upload/";
    var pagecurr            = pagecurr;

    $.ajax({
        url: (file_list_url + "&pagecurr=" + pagecurr),  
        data: {},
        type: 'get',
        cache: false,
        dataType: 'json',
        reval: "",
        success: function(data) {
            //alert(data.info);
            //console.log('aa');

            if (data.error == "0") {
                //var file_list = data.info;
                for (i in data.info) {
                    file_list_html += "<img src='" + upload_file_path + data.info[i] + "' />";
                }
            }

            var pagepre     = parseInt(data.page[0]) - 1;
            var pagenext    = parseInt(data.page[0]) + 1;
            if (pagepre < 1) {
                pagepre = 1;
            };
            if (pagenext > parseInt(data.page[1])) {
                pagenext = data.page[1];
            };
            //console.log(pagepre);

            // add the file sidebar
            file_list_html += "<div class='file_pagebar'>";
            file_list_html += "<a href='#' class='jumpage' pagenum='"+ pagepre +"' >pre</a> ";
            file_list_html += " [ " + data.page[0] + " / " + data.page[1] + " ] ";
            file_list_html += " <a href='#' class='jumpage' pagenum='"+ pagenext +"' >next</a></div></br>";

            //console.log(data.page);

        }
    }).done(function(){
        // fill the file content
        $(".file_list").html(file_list_html);
        $(".file_list img").css("width", "30px").css("height", "30px")
        .css("margin-right", "10px").css("cursor", "pointer");

        // insert img to textarea
        $(".file_list img").click(function(){
            var srcstr = $(this).attr("src");

            $(".file_input").insertContent("[img]" + srcstr + "[/img]");
        });

        $(".file_pagebar .jumpage").click(function(){
            var pagecurr_new = $(this).attr("pagenum");
            if (parseInt(pagecurr) != parseInt(pagecurr_new)) {
                file_load(pagecurr_new);
            };
        });

    });


}


// add a insertContent function for inserting the something to textarea
$(function() {
    (function($) {
        $.fn.extend({
            insertContent : function(myValue, t) {
                var $t = $(this)[0];
                if (document.selection) { // ie
                    this.focus();
                    var sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                    sel.moveStart('character', -l);
                    var wee = sel.text.length;
                    if (arguments.length == 2) {
                        var l = $t.value.length;
                        sel.moveEnd("character", wee + t);
                        t <= 0 ? sel.moveStart("character", wee - 2 * t
                                - myValue.length) : sel.moveStart(
                                "character", wee - t - myValue.length);
                        sel.select();
                    }
                } else if ($t.selectionStart
                        || $t.selectionStart == '0') {
                    var startPos = $t.selectionStart;
                    var endPos = $t.selectionEnd;
                    var scrollTop = $t.scrollTop;
                    $t.value = $t.value.substring(0, startPos)
                            + myValue
                            + $t.value.substring(endPos,
                                    $t.value.length);
                    this.focus();
                    $t.selectionStart = startPos + myValue.length;
                    $t.selectionEnd = startPos + myValue.length;
                    $t.scrollTop = scrollTop;
                    if (arguments.length == 2) {
                        $t.setSelectionRange(startPos - t,
                                $t.selectionEnd + t);
                        this.focus();
                    }
                } else {
                    this.value += myValue;
                    this.focus();
                }
			}
    	})
    })(jQuery);
});
