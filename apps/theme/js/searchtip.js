/*
    search tip for dropmenu, for example 
    mySearchTip("drop-menu-div-id", "search-input-id", "url_str", "drop-menu-div-class-name")
    like, 
    mySearchTip("auto_div", "search_input", '?_m=record&act=ajax&field=snum&kw=', "autodropmenu");
*/

var highlightindex = -1;

function mySearchTip(auto_id, search_id, url_str, dropmenu_class) {
    
    $("#" + auto_id).addClass(dropmenu_class);

    //键盘操作
    $("#" + search_id).keyup(function(event) {
    	
        //处理键盘操作
        var myEvent = event || window.event;
        var keyCode = myEvent.keyCode;
        if (keyCode == 38 || keyCode == 40) {
            if (keyCode == 38) { //向上
                var autoNodes = $("#" + auto_id).children("div");
                if (highlightindex != -1) {
                    autoNodes.eq(highlightindex).css("background-color", "white");
                    highlightindex--;
                } else {
                    highlightindex = autoNodes.length - 1;
                }
                if (highlightindex == -1) {
                    highlightindex = autoNodes.length - 1;
                }
                autoNodes.eq(highlightindex).css("background-color", "#ebebeb");
            }
            if (keyCode == 40) { //向下
                var autoNodes = $("#" + auto_id).children("div");
                if (highlightindex != -1) {
                    autoNodes.eq(highlightindex).css("background-color", "white");
                }
                highlightindex++;
                if (highlightindex == autoNodes.length) {
                    highlightindex = 0;
                }
                autoNodes.eq(highlightindex).css("background-color", "#ebebeb");
            }
        } else if (keyCode == 13) { //回车键
            if (highlightindex != -1) {
                var comText = $("#" + auto_id).hide().children("div").eq(highlightindex).text();

                highlightindex = -1;
                $("#" + search_id).val(comText);
                if ($("#" + auto_id).is(":visible")) {
                    $("#" + auto_id).css("display", "none")
                }
                //$("#search-form").submit();
            }
            //checkInput();
        } else {
            if ($("#" + search_id).val() == "") {
                $("#" + auto_id).hide();
            } else {   //有文字输入时获取提示词
                mySearchTip_AutoComplete(auto_id, search_id, url_str);
            }
        }
    });

    //点击页面隐藏自动补全提示框
    document.onclick = function(e) {
        var e = e ? e : window.event;
        var tar = e.srcElement || e.target;
        if (tar.id != search_id) {
            if ($("#" + auto_id).is(":visible")) {
                $("#" + auto_id).css("display", "none")
            }
        }
    }
};

function mySearchTip_AutoComplete(auto_id, search_id, url_str) {

    if ($("#" + search_id).val() != "") {
        var autoNode = $("#" + auto_id); //缓存对象（弹出框）
        var carlist = new Array();
        var n = 0;
        var mylist = [];
        var maxTipsCounts = 8 // 最大显示条数
        var highlightindex = -1; //高亮设置（-1为不高亮）

        var aj = $.ajax({
            url: url_str + $("#" + search_id).val(),  
            data: {},
            type: 'get',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.error == "0") {
                    //console.log('test 3 ------ ');
                    mylist = data.info;

                    if (mylist == null) {
                        autoNode.hide();
                        return;
                    }
                    autoNode.empty(); //清空上次的记录
                    for (i in mylist) {
                        if (i < maxTipsCounts) {
                            var wordNode = mylist[i]; //弹出框里的每一条内容
                            var newDivNode = $("<div>").attr("id", i); //设置每个节点的id值

                             //设置提示框与输入框宽度一致
                            document.querySelector("#" + auto_id).style.width = $("#" + search_id).outerWidth(true) + 'px';
                            newDivNode.attr("style", "font:14px/25px arial;height:25px;padding:0 8px;cursor: pointer;");
                            newDivNode.html(wordNode).appendTo(autoNode); //追加到弹出框
                            //鼠标移入高亮，移开不高亮
                            newDivNode.mouseover(function() {
                                if (highlightindex != -1) { //原来高亮的节点要取消高亮（是-1就不需要了）
                                    autoNode.children("div").eq(highlightindex).css("background-color", "white");
                                }
                                //记录新的高亮节点索引
                                highlightindex = $(this).attr("id");
                                $(this).css("background-color", "#ebebeb");
                            });
                            newDivNode.mouseout(function() {
                                $(this).css("background-color", "white");
                            });
                            //鼠标点击文字上屏
                            newDivNode.click(function() {
                                //取出高亮节点的文本内容
                                var comText = autoNode.hide().children("div").eq(highlightindex).text();
                                highlightindex = -1;
                                //文本框中的内容变成高亮节点的内容
                                $("#" + search_id).val(comText);
                                $("#search-form").submit();
                            })

                            //如果返回值有内容就显示出来
                            if (mylist.length > 0) {
                                autoNode.show();
                            } else {
                                autoNode.hide();
                                //弹出框隐藏的同时，高亮节点索引值也变成-1
                                highlightindex = -1;
                            }
                        }
                    }
                }
            }
        });
    }
};
