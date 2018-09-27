<form id="form1" class="upload_form clear">
	<h3 class="mt0"><?=l('upload file');?></h3>
	<input type="file" id="file" name="smfile" />
	<input type="submit" id="upfile" value="<?=l('upload')?>" class="right" />
</form>
<br/>
<div><?= l('upload detail') ?></div>
<div id="upload_res" />


<script src='https://www.jqueryscript.net/demo/jQuery-Plugin-To-Copy-Any-Text-Into-Your-Clipboard-Copy-to-Clipboard/jquery.copy-to-clipboard.js' ></script>


<script>

$("#upfile").click(function(event){
	event.preventDefault();
	var formData = new FormData($("#form1")[0]);

	$.ajax({
		type: "POST",
		url:"https://sm.ms/api/upload",
        	data:formData,
        	contentType: false,
        	processData: false,
        	success: function(data) {

				//console.log(data);
				if (data.code == "success") {
					var path_txt = "img#" + data.data['url'];
					var insert_txt = "<p><input type='text' class='upload_path' data-clipboard-text='";
					insert_txt += path_txt + "' value='" + path_txt + "' />";
					insert_txt += "<img class='upload_img' src='" + data.data['url'] + "' />";
					insert_txt += "<span>  " + data.data['filename'] + "</span></p>";

					$("#upload_res").append(insert_txt);

					// style
					$('.upload_path').css({
						'margin':'5px 0', 'width':'250px', 'cursor':'pointer'
					});
					$('.upload_img').css({'width':'30px', 'height':'20px', 'margin-left':'5px'});

					// copy event
					$('.upload_path').click(function(){
						var upload_path_txt = $(this).prev().text();
						// window.clipboardData.setData('Text',upload_path_txt);
						// console.log(upload_path_txt);
						$(this).CopyToClipboard();
						$(this).css('background-color', '#d8decf');
					});

				} else {
					$("#upload_res").append(data.msg + "</br>");
				}
			
        	}
	});

});


</script>


