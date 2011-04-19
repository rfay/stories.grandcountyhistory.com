<?php
	$a = db_query("select nid from node");
	foreach($a as $x) {
		$node = node_load($x->nid);
		$content = $node->body["und"][0]['value'];
		$node->body["und"][0]['value'] = str_replace("\n","",$content);
		echo("Saving node ".$x->nid."\n");
		node_save($node);
	}
?>
