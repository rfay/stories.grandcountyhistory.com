<?php

	function truncate_tags($string) {
		$string = preg_replace("/<p\b[^>]*>/i","<p>",$string);
		$string = preg_replace("/<br\b[^>]*>/i","<br />",$string);
		$string = preg_replace("/<span\b[^>]*>/i","<span>",$string);
		return $string;
	}
		
	mysql_connect("mysql.crocodileroullette.info","gchist","wogagu");
	mysql_select_db("gchist");
	$query = "SELECT Sheet1.DesktopHtml, Sheet1.ModuleID, dn_modules.ModuleTitle from Sheet1 LEFT JOIN (dn_modules) on (Sheet1.ModuleID = dn_modules.ModuleID)";
	$a = mysql_query($query);
	$fails = Array();
	$images = Array();
	while ($row = mysql_fetch_assoc($a)) {
		$node = new stdClass();
		$node->type = "article";
		node_object_prepare($node);
		$node->uid = 1;
		$node->title = $row["ModuleTitle"];
		$node->language = LANGUAGE_NONE;
		$content = html_entity_decode($row["DesktopHtml"],ENT_QUOTES);
		$file = rand(0,10000);
		file_put_contents("$file",$content);
		shell_exec("tidy -m --show-body-only yes $file");
		$content = file_get_contents($file);
		unlink($file);
		$replace = Array("\n","’","—","…","“","”");
		$replacements = Array(" ","'","-","...","\"","\"");
		$content = str_replace($replace,$replacements,$content);
		$node->body[$node->language][0]['value'] = $content;
		$node->body[$node->language][0]['format'] = 'full_html';
		$q = mysql_query("select taxo from taxoAssign where name='".$row["ModuleTitle"]."'");
		while ($j = mysql_fetch_assoc($q)) {
			if ($j["taxo"]) {
				$node->field_category = Array("und" => Array(0 => array('tid' => $j["taxo"])));
			}
		}
		$b = "select dn_settings.FileID from html_tabs LEFT JOIN (image_tabs, dn_settings) on image_tabs.TabID = html_tabs.TabID and image_tabs.ModuleID = dn_settings.ModuleID where html_tabs.ModuleID = '".$row["ModuleID"]."'";
		$q = mysql_query($b);
		while ($i = mysql_fetch_assoc($q)) {
			if ($i["FileID"]) {
				echo("found file: ".$i["FileID"]."\n");
				$uri = "/home/markle12/gchist.crocodileroullette.info/tmp_image/".$i["FileID"].".jpg";
				$file = new stdClass();
				$file->uid = 1;
				$file->filename = $i["FileID"].".jpg";
				$file->uri = $uri;
				$file->filemime = file_get_mimetype($uri);
				$file->status = 1;
				$dest = file_default_scheme() . "://";				
				$file = file_copy($file,$dest);
				$images[] = $uri;
				$node->field_image['und'][0] = (array)$file;
			}
		}
		try {
		node_save($node);
		} catch (PDOException $err) {
			$fails[] = $row["ModuleID"];
		}
	}	
	print_r($images);
	echo("\n");
	print_r($fails);
?> 
