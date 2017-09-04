<?php
	$q = "select nid from node";
	$result = db_query($q);
	foreach ($result as $n) {
		node_delete($n->nid);
		echo("Deleted node ".$n->nid."\n");
	}
?>