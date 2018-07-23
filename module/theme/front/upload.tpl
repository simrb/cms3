<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>

<div>

		<form id="form1" >
			<input type="file" id="file" name="smfile" ></input>
			<input type="submit" id="upfile" value="upload" ></input>
		</form>
		<div id="upload_res"></div>

</div>

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
			console.log(data);
			if (data.code == "success") {
				$("#upload_res").append("[img]" + data.data['url'] + "[/img]</br>");
			} else {
				$("#upload_res").append(data.msg + "</br>");
			}
			
        	}
	});

});

</script>
