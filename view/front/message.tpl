<div class="edit-form edit-form-login show-user">
	<form action="?_v=settings&_a=settings" method="post">
		<ul>
			<li>
				<a href="?_v=message"><h3 class="user-msg black"><?= l('user message'); ?></h3></a>
				<a href="?_v=settings"><h3 class="user-info gray1"><?= l('user info'); ?></h3></a>
			</li>

			<li class='clear user-msg-body'>
				<?php
					$msg_type = array(0 => l('reply'), 1 => l('reply'), 2 => l('like'));
					if ($t['msg_res']) {
						while($row = mysql_fetch_assoc($t['msg_res'])) {
							echo '<p>'. timeago($row['created']) .', '.
								'<a class="show-user" href="#u'.$row['fromuid']. '" >u#'.$row['fromuid']. '</a> '. 
								$msg_type[$row['msg_type']] .',  '. $row['content'];

							// link of jumping
							if ($row['follow'] == 0) {
								echo '<a target="_blank" href="?_v=detail&rid='. $row['rid'] .'"> >> </a></p>';
							} else {
								echo '<a target="_blank" href="?_v=detail&rid='. $row['follow'] .'#r'. $row['rid'] .'"> >> </a></p>';
							}
						}
					} else {
						echo '<p>'. l('nothing') .'</p>';
					}
				?>
			</li>

			<li>
			</li>

		</ul>

	</form>
</div>
