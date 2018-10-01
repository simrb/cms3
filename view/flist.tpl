<div class="show-list"> 


	<?php
		if ($t["record_res"]) {
			while($row = mysql_fetch_array($t["record_res"])) {

				echo "<div class='show-list-body'>";

				$def_len = 27;
				$len 	 = mb_strpos($row['content'], "\r",0,'utf-8');
				if (!$len) {
					$len = mb_strpos($row['content'], "\n",0,'utf-8');
					if (!$len) {
						$len = $def_len;
					}
				}

				if (!$len || $len > $def_len) {
					$len = $def_len;
				}
				
				// if gbk string, reduce 2 multiple
				/*if (is_gbk($row['content'])) {
					$len = ceil($len/2);
				}*/
				
				//var_dump($len);

				//echo "<label>" . date('Y-m-d H:i:s', $row['created']) . "</label>";
				echo "<h3><a href='" . front_link('detail', $row['rid']);
				echo "' target='_self'>" . parse_html(utf8_substr($row['content'], 0 , $len)) . "</a></h3>";

				echo "<p><span class='list-body'>" . parse_html(utf8_substr($row['content'], $len, 102))  .
				//		"</span> <a  href='" .front_link('detail', $row['rid']). "' > >> </a>";
						"</span> <a  href='" .front_link('detail', $row['rid']). "' ><img src='view/img/14.png' /></a>";

				$cmt_tip = recordlog($row['rid'], 'replies');
				if (intval($cmt_tip) > 0) {
					echo "<span class='list-cmt-tip'>". $cmt_tip ."</span>";
				}

				echo "</p><div class='clear'></div></div>";
			}
		}
	?>


</div>


<div class="show-pagination">

	<?php
		if ($t["pagenums"] > 0) {
			for ($i=0; $i < $t["pagenums"]; $i++) {
				$j = $i + 1;
				$pg_hl = $j == $t['pagecurr'] ? 'pg_hl' : '';
				echo '<span class="'.$pg_hl.'"><a href="'. front_link('list', $t['cid'], $j).
					'">'.$j.'</a></span>';
			}
		}

	?>

</div>
