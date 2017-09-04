<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$query = 'select tid from taxonomy_term_data where vid=2';
$result = db_query($query);
foreach ($result as $record) {
  $term = taxonomy_term_load($record->tid);
  dsm($term);
  $node = new stdClass();
  $node->type = 'article';
  node_object_prepare($node);
  $node->title = "From term: " . $term->name;
  $node->body = array('und' => array( array() ));
  $node->body['und'][0]['value'] = $term->description;
  $node->field_category = array('und' => array( array() ));
  $node->field_category['und'][0]['tid'] = $term->tid;
  $node->sticky = 1;
  dsm($node, 'node before creation');
  try {
    node_save($node);
  } catch (Exception $e) {
    dsm($e, 'Error');
  }
  dsm($node, 'new $node');
  $descriptions = preg_split('/([\r\n\.]|<br>|<p>)/', $term->description);
  foreach ($descriptions as $description) {
    if (!preg_match('/Article/', $description) && strlen($description) > 20) {
      break;
    }
  }
  $term->description = $description . '.';
  taxonomy_term_save($term);
}
