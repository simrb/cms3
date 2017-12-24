<div class="edit-form">
	<form action="?_a=<?= $t['_a'] ?>" method="post" enctype="multipart/form-data" name="upload" >
		<ul>
			<li><input type="file" name="files" class="addfile" /></li>
			<li>
				<textarea name="content" class="record_text file_input"></textarea>
				<input type="hidden" name="cid" value="<?=$t['cid']?>" />
			</li>
			<li><input type="submit" value="<?= l('submit'); ?>"></li>
			<li><br />
					<pre><?= $t['aboutpost']; ?></pre>
			</li>
		</ul>
	</form>

</div>
