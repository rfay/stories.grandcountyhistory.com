<?php

//$node = node_load(1842);
$result = db_query("SELECT nid from {node}");
foreach ($result as $node) {
  $x = 1;
  $node = node_load($node->nid);
  $body = $node->body['und']['0']['value'];
  $check = check_plain($body);
  if (empty($check) && !empty($body)) {
    // Error
    $x =1 ;
    print "\nNode $node->nid is broken\n";
    $body = utf8_decode($body);
    $node->body['und'][0]['value'] = $body;
    node_save($node);
  }
  // Do something with each $record
}
// $newtext = check_plain($node->body['und']['0']['value']);
// $body = $node->body['und']['0']['value'];
// $body = strtr($body, '�', '');
//$body = str_replace('�', '', $body);
//$body = preg_replace('/�/', '', $body);
//$body = utf8_decode($body);
//$newtext =  htmlspecialchars($body, ENT_COMPAT, 'UTF-8');
//$newtext =  htmlspecialchars($body, ENT_COMPAT, 'ISO-8859-1');
//
//$lines = explode('<BR>', $body);
//foreach ($lines as $line) {
//  $processed = check_plain($line);
//  if (empty($processed)) {
//    $bad = 1;
//  }
//}

//$newtext = htmlspecialchars_decode($newtext);
//$node->body['und']['0']['value'] = $body;
//node_save($node);
$x = 1;
