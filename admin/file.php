<?php access();


// initialing upload folder if it hasn`t existed
if(!is_dir(UPLOAD_PATH)) {
    exit('no file '. UPLOAD_PATH);
}


// act: ajax, get the search tip
if ($t['_a'] == 'ajaxfilelist') {

	$arr = array('info'=> array(), 'error'=>0);
/*	
	$arr = array('info'=> array('cc', 'cc1', 'cccccc3'), 'error'=>0 );
	ajax_json($arr);
	exit;
*/

	// pagination
	$pagecurr			=	(isset($_GET["pagecurr"]) and $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagesize			=	9 ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$filenums			=	0;

	$sql_str			= 	"SELECT path FROM file";
	$res 				= 	sql_query($sql_str);
	$filenums 			= 	mysql_num_rows($res);

	$pagenums		 	= 	ceil($filenums/$pagesize);
	$sql_str 			.=	" ORDER BY fid DESC LIMIT $pagestart, $pagesize";
	$res 				= 	sql_query($sql_str);
	$arr['page'] 		= 	array($pagecurr, $pagenums);

	if (mysql_num_rows($res) > 0) {
		while ($row = mysql_fetch_assoc($res)) {
			array_push($arr['info'], $row['path']);
		}
	}
	
	ajax_json($arr);
}


// act: add
if ($t['_a'] == "add") {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$t["msg"]			= "";

// 		print_r(get_upload_files());
// 		exit;
		foreach (get_upload_files() as $key => $file) {
// 			exit(print_r($file));

			if ($file['name']) {
				$name 	= substr($file['name'], 0, strrpos($file['name'], '.'));
				$type 	= strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
				$path 	= date("ymdHis") . $key . user_id() . "." . $type;
			
				if(!is_uploaded_file($file['tmp_name'])) {
					$t["msg"] = l('no file');
				 	break;
				}

				if(!in_array($type, $c['img_allow_types'])) {
					$t["msg"] = l('wrong type');
					break;
				}

				if($c['img_max_size'] < $file["size"]) {  
					$t["msg"] = l('file too big');
					break;
				}  

				process_image ($file['tmp_name'], $c['img_max_width'], $c['img_max_height']);
				if(!move_uploaded_file($file['tmp_name'], UPLOAD_PATH.$path)){
					$t["msg"] = l('a error in removing file');
					break;
				}

				// write to db
				sql_query("INSERT INTO file (uid, name, path, type, created) VALUES ('". user_id() 
				."','". $name ."','". $path ."','". $type ."','". time() ."');");

			}

		}

		$t["msg"] = $t["msg"] == "" ? l('added successfully') : $t["msg"];
	} else {
		$t["msg"] = l('failed to add');
	}
}


// act: delete
if ($t['_a'] == "del") {
	if (isset($_GET["fid"])) {
		// remove file
		$res = sql_query("SELECT path FROM file WHERE fid='". $_GET["fid"] ."' LIMIT 1;");
		$file = mysql_fetch_assoc($res);
		if (file_exists(UPLOAD_PATH.$file['path'])) {
			unlink(UPLOAD_PATH.$file['path']);
		}

		// delete from db
		sql_query("DELETE FROM file WHERE fid='". $_GET["fid"] ."';");
		$t["msg"] = l('deleted successfully');
	}
}


// view: show
if ($t['_v'] == "show") {

	// pagination
	//$pagecurr			=	(isset($_GET["pagecurr"]) and $_GET["pagecurr"]>1) ? $_GET["pagecurr"] : 1 ;
	$pagecurr = (isset($_REQUEST["pagecurr"]) and $_REQUEST["pagecurr"]>1) ? $_REQUEST["pagecurr"] : 1;
	$pagesize			=	$c["def_pagesize"] ;
	$pagenums			=	0 ;
	$pagestart			=	($pagecurr - 1)*$pagesize ;
	$t["res_num"]		=	0;

	$sql_str			= 	"SELECT * FROM file";
	$t["file_res"] 		= 	sql_query($sql_str);
	$t["res_num"] 		= 	mysql_num_rows($t["file_res"]);

	$pagenums		 	= 	ceil($t["res_num"]/$pagesize);
	$sql_str 			.=	" ORDER BY fid DESC LIMIT $pagestart, $pagesize";
	$t["file_res"] 		=	sql_query($sql_str);

	$t["pagecurr"]		=	$pagecurr;
	$t["pagenums"]		=	$pagenums;

	tpl($t);
}


// view: edit
if ($t['_v'] == "edit") {
	tpl($t);
}


function ajax_json ($data) {
	echo json_encode($data);
	exit;
}


// return the file with an index array
function get_upload_files () {
    foreach($_FILES as $file) {
        $num = count($file['name']);

        if ($num == 1) {
            $files[] = $file;
        } else {
            for ($i=0; $i < $num; $i++) { 
                $files[$i]['name']		=	$file['name'][$i];
                $files[$i]['type']		=	$file['type'][$i];
                $files[$i]['tmp_name']	=	$file['tmp_name'][$i];
                $files[$i]['error']		=	$file['error'][$i];
                $files[$i]['size']		=	$file['size'][$i];
            }
        }
    }
    return $files;
}


function process_image($im, $maxwidth, $maxheight) {
	$path = $im;

    $img = getimagesize($im);
    switch ($img[2]) {
        case 1:
            $im = @imagecreatefromgif($im);
            break;
        case 2:
            $im = @imagecreatefromjpeg($im);
            break;
        case 3:
            $im = @imagecreatefrompng($im);
            break;
    }

	$exif	= exif_read_data($path);
	if(!empty($exif['Orientation'])) {
		switch($exif['Orientation']) {
			case 8:
				$im = imagerotate($im,90,0);
				break;
			case 3:
				$im = imagerotate($im,180,0);
				break;
			case 6:
				$im = imagerotate($im,-90,0);
				break;
		}
	}

    $pic_width = imagesx($im);
    $pic_height = imagesy($im);
    $resizewidth_tag = false;
    $resizeheight_tag = false;
    if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
        if ($maxwidth && $pic_width > $maxwidth) {
            $widthratio = $maxwidth / $pic_width;
            $resizewidth_tag = true;
        }

        if ($maxheight && $pic_height > $maxheight) {
            $heightratio = $maxheight / $pic_height;
            $resizeheight_tag = true;
        }

        if ($resizewidth_tag && $resizeheight_tag) {
            if ($widthratio < $heightratio)
                $ratio = $widthratio;
            else
                $ratio = $heightratio;
        }


        if ($resizewidth_tag && !$resizeheight_tag)
            $ratio = $widthratio;
        if ($resizeheight_tag && !$resizewidth_tag)
            $ratio = $heightratio;
        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;

        if (function_exists("imagecopyresampled")) {
            $newim = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
        } else {
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
        }

        imagejpeg($newim, $path);
        imagedestroy($newim);
    } else {
        imagejpeg($im, $path);
    }
}


?>
