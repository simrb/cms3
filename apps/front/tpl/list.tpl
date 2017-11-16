<div class="show-list"> 


	<?php
		if ($t["record_res"]) {
			while($row = mysql_fetch_array($t["record_res"])) {

				echo "<div class='show-list-body'>";
				//echo "<label>" . $row['created'] . "</label>";

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

				echo "<h3><a href='?_v=detail&rid=" . $row['rid'];
				echo "' target='_self'>" . utf8_substr($row['content'], 0 , $len) . "</a></h3>";
				echo "<p>" . utf8_substr($row['content'], $len, 102) . "</p>";
				//echo "<p>" . mb_strstr($row['content'], '\r') . "</p>";
				echo "</div>";
			}
		}
	?>


</div>


<div class="show-pagination">

	<?php
		if ($t["pagenums"] > 0) {
			for ($i=0; $i < $t["pagenums"]; $i++) {
				$j = $i + 1;
				echo '<span> <a href="?_r=front&pagecurr='.$j.'&cid='.$t['cid'];
				echo '">'.$j.'</a> </span>';
			}
		}

	?>

</div>
