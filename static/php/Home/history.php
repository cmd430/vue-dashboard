<?php

include "../Config/conf.php";
header("Content-Type: application/json");

$COUNT = 5;

$CURRENT_HISTORY = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_home_stats&stats_count=${COUNT}"), true);

$HISTORY = array();

function getInbetweenStrings ($start, $end, $str) {
  $matches = array();
  $regex = "/$start([a-zA-Z0-9_]*)$end/";
  preg_match_all($regex, $str, $matches);
  return $matches[1];
}

foreach ($CURRENT_HISTORY['response']['data'][3]['rows'] as $item) {
  $newItem = array();
  if ($item['grandparent_thumb'] != "") {
    $newItem['media_type'] = "episode";
    $title_episode = explode(" - ", $item['title']);
    $newItem['title'] = $title_episode[0];
    $newItem['episode'] = $title_episode[1];
    $RATING_KEY = getInbetweenStrings("\/library\/metadata\/", "\/thumb\/", $item['grandparent_thumb'])[0];
    $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=poster";
  } else {
    $newItem['media_type'] = "movie";
    $newItem['title'] = $item['title'];
    $RATING_KEY = getInbetweenStrings("\/library\/metadata\/", "\/thumb\/", $item['thumb'])[0];
    $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=poster";
  }
  $newItem['last_watch'] = $item['last_watch'];
  $newItem['id'] = $item['row_id'];
  array_push($HISTORY, $newItem);
}

echo json_encode($HISTORY);

?>