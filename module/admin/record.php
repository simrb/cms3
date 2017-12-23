<?php access();


// act: add
if ($t['_a'] == "add") {
	if (($t["msg"] = record_fields_valid("add")) == "") {
		sql_query(
			"INSERT INTO record (
			uid, cid, follow, useful, content, created
			) VALUES (
			'". user_id() ."', '". $_POST["cid"] ."', '". $_POST["follow"] ."',
			'". $_POST["useful"] ."', '". $_POST["content"] ."', '". time() ."')"
		);
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
			$t["msg"] = l('updated successfully');
		}
	}
}


// act: delete
if ($t['_a'] == "del") {
	if (isset($_GET["rid"])) {
		sql_query("UPDATE record SET cid = 0 WHERE rid = '".$_GET['rid']."';");
		$t["msg"] = l('deleted successfully');
	}
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

			$t['_a']			=	"update";
		}
	}
	tmp($t);
}


function record_fields_valid ($str) {
	$reval = "";
	return $reval;
}


?>
