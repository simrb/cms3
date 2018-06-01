<?php access();


// act: add
if ($t['_a'] == "add") {
	if (($t["msg"] = record_fields_valid("add")) == "") {
		$insert_id = sql_query(
			"INSERT INTO record (
			uid, cid, follow, useful, content, created
			) VALUES (
			'". user_id() ."', '". $_POST["cid"] ."', '". $_POST["follow"] ."',
			'". $_POST["useful"] ."', '". $_POST["content"] ."', '". time() ."')", 'insert_id'
		);
		tag_add_by($insert_id, $_POST['tag']);
		$t["msg"] = l('added successfully');
	}
}


// act: update
if ($t['_a'] == "update") {
	if (($t["msg"] = record_fields_valid("update")) == "") {
		sql_query("UPDATE record SET 
			uid = '". user_id() ."',
			cid = '". $_POST["cid"] ."',
			follow = '". $_POST["follow"] ."',
			useful = '". $_POST["useful"] ."',
			content = '". $_POST["content"] ."'
			 WHERE rid = '". $_POST["rid"] ."';"
		);

		// fetch data for showing later, and make sure this operating is successful
		$res = sql_query("SELECT uid,cid,follow,useful,content,created FROM record WHERE rid = '". $_POST["rid"] ."';");
		if ($res) {
			tag_update_by($_POST["rid"], $_POST['tag']);
			$t["msg"] = l('updated successfully');
		}
	}
}


// act: delete
if ($t['_a'] == "del") {
	if (isset($_GET["rid"])) {
		sql_query("UPDATE record SET cid = 0 WHERE rid = '".$_GET['rid']."';");
		tag_delete_by($_GET["rid"]);
		$t["msg"] = l('deleted successfully');
	}
}


// act: optimize
if ($t['_a'] == "optimize") {
	$cdt 			= isset($_POST['select_condition']) ? $_POST['select_condition'] : '';
	$three_month 	= time() - 60*60*24*30*3;
	$three_day 		= time() - 60*60*24*3;
	$num			= 0;

	switch ($cdt) {

		// delete records in trash
		case 'clean_trash' :
			$num = sql_query("DELETE FROM record WHERE cid=0;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete guest records three months ago
		case 'clean_guest' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND created < $three_month;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete uesless records three months ago
		case 'clean_useless' :
			$num = sql_query("DELETE FROM record WHERE useful=0 AND created < $three_month;", 'affect_num');
			$t["msg"] = l('deleted successfully') . ' for '. $num;
		break;

		// delete guest and useless three months ago
		case 'clean_guest_and_useless' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND useful=0 AND created < $three_month;", 'affect_num');
		break;

		// delete guest and useless in three days
		case 'clean_guest_and_useless_days' :
			$num = sql_query("DELETE FROM record WHERE uid=0 AND useful=0 AND created > $three_day;", 'affect_num');
		break;
	}

	$t["msg"] = l('deleted successfully') . ' for '. $num;
	$t['_v'] = "optimize";
}


// view: show
if ($t['_v'] == "show") {
	$t["category_kv"]	=	data_fetch_kv("category", "cid", "name");
//	$t["status_kv"]		=	data_fetch_kv("status", "sid", "name");

	// pagination
	$pagecurr = (isset($_REQUEST["pagecurr"]) and $_REQUEST["pagecurr"]>1) ? $_REQUEST["pagecurr"] : 1;

	$pagesize			=	$c["def_pagesize"] ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$t["res_num"]	=	0;

	// act: query
	if ($t['_a'] == "query") {
								// $_REQUEST
		$select_type		=	isset($_GET["select_type"]) ? $_GET["select_type"] : 
								(isset($_POST["select_type"]) ? $_POST["select_type"] : "exact");
		
		$select_kw_name = $select_kw =	isset($_GET["select_kw"]) ? $_GET["select_kw"] : 
								(isset($_POST["select_kw"]) ? $_POST["select_kw"] : "");

		$select_field		=	isset($_GET["select_field"]) ? $_GET["select_field"] : 
								(isset($_POST["select_field"]) ? $_POST["select_field"] : "");

		// process the sepcial fields cid, sid..
		$cid_vk				=	array_flip($t["category_kv"]);
//		$sid_vk				=	array_flip($t["status_kv"]);

		// replace the cid field name by its id, and ...
		if ($select_field == "cid") {
			$select_kw = array_key_exists($select_kw, $cid_vk) ? $cid_vk[$select_kw] : "" ;
		}

		if (($select_kw != "") and ($select_field != "")) {
			if ($select_type == "exact") {
				$sql_str = "SELECT * FROM record WHERE $select_field = '$select_kw' ";
			} else {
				$sql_str = "SELECT * FROM record WHERE $select_field like '%$select_kw%' ";
			}

			//echo $sql_str;
			$t["record_res"] =	sql_query($sql_str);
			$t["res_num"] =	mysql_num_rows($t["record_res"]);

			$pagenums		 =	ceil($t["res_num"]/$pagesize);
			$sql_str 		.=	" ORDER BY rid DESC LIMIT $pagestart, $pagesize";
			$t["record_res"] =	sql_query($sql_str);


			if ($t["res_num"] < 1) {
				$t["msg"] 	= l('no result in quering');
			} else {
				$t["url"] 	= "_a=query&select_kw=$select_kw_name&select_field=$select_field&select_type=$select_type";
			}
		} else {
			// no content in db for the sepcail field
			$t["record_res"] = '';
			$t["msg"] = l('no result in quering');
		}
	}


	// if no query act
	if (!isset($t["record_res"])) {
		$sql_str			= "SELECT * FROM record";
		$t["record_res"] 	= sql_query($sql_str);
		$t["res_num"] 		= mysql_num_rows($t["record_res"]);

		$pagenums		 	= ceil($t["res_num"]/$pagesize);
		$sql_str 			.=	" ORDER BY rid DESC LIMIT $pagestart, $pagesize";
		$t["record_res"] 	=	sql_query($sql_str);
	}

	$t["pagecurr"]			=	$pagecurr;
	$t["pagenums"]			=	$pagenums;

	tmp($t);
}


// view: edit
if ($t['_v'] == "edit") {

	$t["rid"]			=	isset($t["rid"]) ? $t["rid"] : 0;
	$t["uid"]			=	isset($t["uid"]) ? $t["uid"] : user_id();
	$t["cid"]			=	isset($t["cid"]) ? $t["cid"] : 1;
	$t["follow"]		=	isset($t["follow"]) ? $t["follow"] : 0;
	$t["useful"]		=	isset($t["useful"]) ? $t["useful"] : 0;
	$t["content"]		=	isset($t["content"]) ? $t["content"] : "";

	$t["category_kv"]	=	data_fetch_kv("category", "cid", "name");

	$t['_a']			=	$t['_a'] == "" ? "add" : $t['_a'];

	$t["rid"]			=	isset($_GET["rid"]) ? $_GET["rid"] : (isset($_POST['rid']) ? $_POST['rid'] : $t['rid']);

	$t["tag"]			=	isset($t["tag"]) ? $t["tag"] : '';


	// fill data for edit action
	if ( $t['rid'] != 0 ) {
		$res = sql_query("SELECT rid,uid,cid,follow,useful,content,created FROM record WHERE rid = '". $t['rid'] ."';");
		if ($res) {
			$row = mysql_fetch_assoc($res);
			$t["uid"]			=	$row['uid'];
			$t["cid"]			=	$row['cid'];
			$t["follow"]		=	$row['follow'];
			$t["useful"]		=	$row['useful'];
			$t["content"]		=	$row['content'];
			$t["created"]		=	$row['created'];

			$t["tag"]			=	tag_view_by($t['rid']);

			$t['_a']			=	"update";
		}
	}
	tmp($t);
}


//view: improving
if ($t['_v'] == "optimize") {
	tmp($t);
}


function record_fields_valid ($str) {
	$reval = "";
	return $reval;
}


/*
 get the tag names by rid,
 return a string by joinning the names with blank,
 otherwise is blank.
*/
function tag_view_by($rid) {
	$reval = "";

	$sql_str = "SELECT name FROM tag WHERE rid = '$rid';";

	$res	=	sql_query($sql_str);
	if (mysql_num_rows($res) > 0) {
		while( $row = mysql_fetch_array($res, MYSQL_ASSOC) ) {
			$reval .= $row['name'].' ';
		}
	}

	return $reval;
}


function tag_add_by($rid, $tag) {
	// add tag
	$tag	= trim($tag);
	$tids	= array();
	if (!empty($tag)) {
		$tag = explode(' ', $tag);

		// fetch tid from tag table, otherwise creating a new tag and return id
		foreach( $val as $tag ) {
			$res = sql_query("SELECT tid FROM tag WHERE name = '". $val ."', LIMIT 1;");

			// has exist tag
			if (mysql_num_rows($res) > 0) {
				$row = mysql_fetch_row($res);
				$tids[] = $row[0];

			// no tag
			} else {
				$tids[] = sql_query(
					"INSERT INTO tag (name) VALUES ('". $val ."');", 'insert_id'
				);
			}
		}
	}

	// add tag_assoc
	if (!empty($tids)) {
		foreach($val as $tids) {
			sql_query(
				"INSERT INTO tag_assoc (rid, tid) VALUES ('$rid', '$val');"
			);
		}
	}
}


function tag_update_by($rid, $tag) {
	// compare tag
	$old_tag = explode(' ', tag_view_by($rid));
	$new_tag = explode(' ', $tag);

	$add_tag = array_diff($new_tag, $old_tag);
	$del_tag = array_diff($old_tag, $new_tag);

	// if it has new tags
	if(!empty($add_tag)) {
		tag_add_by($rid, $add_tag);
	}

	// if it has removed tags
	if(!empty($del_tag)) {
		$tag_delete_by($rid, $del_tag);
	}
}


// delete the associations of tag and record by rid
function tag_delete_by($rid, $tag = '') {
	$num = sql_query("DELETE FROM tag_assoc WHERE rid='$rid';", 'affect_num');
}



?>
