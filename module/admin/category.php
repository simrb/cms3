<?php access();

$t['tpl_layout'] 	= 'admin/tpl/layout';
$t['tpl_name'] 		= 'admin/tpl/category';

// act: add
if ($t['_a'] == "add") {
	if (isset($_POST["category_name"])) {
		sql_query("INSERT INTO category (name,follow,number) VALUES ('". $_POST["category_name"] ."',
			'". $_POST["follow"] ."', '". $_POST["number"] ."');");
		$t["msg"] = l("added successfully");
	} else {
		$t["msg"] = l("failed to add");
	}
}

// act: update
if ($t['_a'] == "update") {
	if (isset($_POST["cid"])) {
		sql_query("UPDATE category SET name = '". $_POST["category_name"] ."',
					follow = '". $_POST["follow"] ."', number = '". $_POST["number"] .
					"' WHERE cid = '".$_POST["cid"]."';");

		$res = sql_query("SELECT cid, name, follow, number FROM category WHERE cid = '". $_POST["cid"] ."';");
		if ($res) {
			$t["msg"] 			= 	l("updated successfully");
			//$t['_a']			=	"update";
		}
	}
}

// act: delete
if ($t['_a'] == "del") {
	if (isset($_GET["cid"])) {
		sql_query("DELETE FROM category WHERE cid='". $_GET["cid"] ."';");
		$t["msg"] = l("deleted successfully");
	}
}

// view: show
if ($t['_v'] == "show") {
	// pagination
	$pagecurr			=	(isset($_GET["pagecurr"]) and $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagesize			=	$c["def_pagesize"] ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$t["res_num"]		=	0;

	$sql_str			= 	"SELECT * FROM category";
	$t["category_res"] 	= 	sql_query($sql_str);
	$t["res_num"] 		= 	mysql_num_rows($t["category_res"]);

	$pagenums		 	= 	ceil($t["res_num"]/$pagesize);
	$sql_str 			.=	" LIMIT $pagestart, $pagesize";
	$t["category_res"] 	=	sql_query($sql_str);

	$t["pagecurr"]		=	$pagecurr;
	$t["pagenums"]		=	$pagenums;

	tmp($t);
}

// view: edit
if ($t['_v'] == "edit") {
	$t["cid"]			=	isset($t["cid"]) ? $t["cid"] : 0;
	$t["category_name"]	=	isset($t["category_name"]) ? $t["category_name"] : "";
	$t["follow"]		=	isset($t["follow"]) ? $t["follow"] : 0;
	$t["number"]		=	isset($t["number"]) ? $t["number"] : 0;
	$t['_a']			=	$t['_a'] == "" ? "add" : $t['_a'];

	// edit data
	if (isset($_GET["cid"])) {
		$res = sql_query("SELECT cid, name, follow, number 
			FROM category WHERE cid = '". $_GET["cid"] ."';");

		if ($res) {
			$row = mysql_fetch_assoc($res);
			$t["cid"]			=	$row['cid'];
			$t["category_name"]	=	$row['name'];
			$t["follow"]		=	$row['follow'];
			$t["number"]		=	$row['number'];
			$t['_a']			=	"update";
		}
	}
	tmp($t);
}


?>
