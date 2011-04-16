<?php
	$names = Array();
	$names[] = "Moffat Road";
	$names[] = "Train Legends of the Moffat Road";
	$names[] = "The Train Comes to Fraser";
	$names[] = "The Flood that built the Moffat Tunnel";



	$dest = 43;
	$nstr = "";
	$first = 1;
	foreach ($names as $x) {
		if (!$first) {
			$nstr .= " OR ";
		}
		$nstr .= "title LIKE '%$x%'";
		$first = 0;
	}
	
	$query = "SELECT nid from node where $nstr";
	$a = db_query($query);
	foreach($a as $x) {
		$node = node_load($x->nid);
		$node->field_category = Array("und" => Array(0 => array('tid' => $dest)));
		echo("\nSetting ".$node->title." to parent taxonomy item ".$dest);
		node_save($node);
	}
?>
		
