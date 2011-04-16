<?php
	mysql_connect("mysql.crocodileroullette.info","gchist","wogagu");
	mysql_select_db("gchist");
	$a = db_query("select nid from node");
	foreach ($a as $x) {
		$node = node_load($x->nid);
		mysql_query("insert into taxoAssign (name,taxo) values ('".$node->title."','".$node->field_category['und'][0]['tid']."')");
		echo("Saved taxo for ".$x->nid."\n");
	}
?>