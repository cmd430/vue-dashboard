<?php

include "../Config/conf.php";
header("Content-Type: application/json");

$COUNT = 10;

$CURRENT_HISTORY = json_decode(file_get_contents("${TAUTULLI}/api/v2?apikey=${API_KEY_TAUTULLI}&cmd=get_home_stats&stats_count=${COUNT}"), true);

$HISTORY = array();

function getInbetweenStrings ($start, $end, $str) {
  $matches = array();
  $regex = "/$start([a-zA-Z0-9_]*)$end/";
  preg_match_all($regex, $str, $matches);
  return $matches[1];
}

foreach ($CURRENT_HISTORY['response']['data'][3]['rows'] as $item) {
  $newItem = array();
  $newItem['title'] = $item['title'];
  $newItem['image'] = "/static/php/Shared/image.php?rating_key=" . getInbetweenStrings("\/library\/metadata\/", "\/thumb\/", $item['grandparent_thumb'])[0] . "&type=poster";
  array_push($HISTORY, $newItem);
}

echo json_encode($HISTORY);

?>