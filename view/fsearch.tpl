<form action="<?=$t['_a']?>" method="get" class="search_menu" target="_blank">

	<p>
		<?php if (isset($t["category_kv"])) {
			echo '<select class="search_select" name="cid">';
			echo '<option value=0 > --'. l('category') .'-- </option>';
			foreach ($t["category_kv"] as $cid => $row) {
				echo '<option value="'. $cid .'">'. $row['name'] .'</option>';
			}
			echo '</select>';
		} ?>

		<input type="submit" value="<?= l('search'); ?>" />
	</p>

	<p>
		<input type="text" value="" name="kw" id="s1" AutoComplete="off" />
		<div id="a1"></div>
	</p>


</form>

<script src="<?= view_path('js/searchtip.js') ?>"></script>
<script >
$(document).ready(function() {

    mySearchTip("a1", "s1", 'index.php?_a=ajax_tagname&kw=', "autodropmenu");
	$('#a1').click(function(){
		var val = $('#s1').val();
		var tids = sajaxReData.tid;
		window.open('index.php?tagname=' + val + '&tid=' + tids[val]);
		//alert(val);
	});

	$('#a1').css('background-color', 'white');

});


</script>

