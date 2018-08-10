<h3><?=l('upload file');?></h3>

<form id="form1" class="upload_form">
	<input type="file" id="file" name="smfile" />
	<input type="submit" id="upfile" value="upload" class="right" />
</form>
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
					var path_txt = "[img]" + data.data['url'] + "[/img]";
					var insert_txt = "<p><input type='text' class='upload_path' data-clipboard-text='";
					insert_txt += path_txt + "' value='" + path_txt + "' /></p>";

					$("#upload_res").append(insert_txt);

					// style
					$('.upload_path').css('margin', '5px 0');
					$('.upload_path').css('width', '250px');

					// copy event
					$('.upload_path').click(function(){
						var upload_path_txt = $(this).prev().text();
						// window.clipboardData.setData('Text',upload_path_txt);
						// console.log(upload_path_txt);
						$(this).CopyToClipboard();
					});

				} else {
					$("#upload_res").append(data.msg + "</br>");
				}
			
        	}
	});

});


</script>


