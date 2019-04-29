<?php

include "../Config/conf.php";
header("Content-Type: application/json");

$COUNT = 9;

$TV_HISTORY = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_history&section_id=2"), true);
$MOVIE_HISTORY = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_history&section_id=1"), true);

$HISTORY = array();

function getInbetweenStrings ($start, $end, $str) {
  $matches = array();
  $regex = "/$start([a-zA-Z0-9_]*)$end/";
  preg_match_all($regex, $str, $matches);
  return $matches[1];
}

foreach ($TV_HISTORY['response']['data']['data'] as $item) {
  if ($item['state'] !== 'playing' && $item['percent_complete'] >= 80) {
    $newItem = array();
    $newItem['media_type'] = "episode";
    $title_episode = explode(" - ", $item['full_title']);
    $newItem['title'] = $title_episode[0];
    $newItem['episode_title'] = $title_episode[1];

    $season = $item['parent_media_index'];
    if (strlen($season) == 1) {
      $newItem['season'] = '0' . $season;
    } else {
      $newItem['season'] = $season;
    }
    $episode = $item['media_index'];
    if (strlen($episode) == 1) {
      $newItem['episode'] = '0' . $episode;
    } else {
      $newItem['episode'] = $episode;
    }
    $newItem['image'] = "${IMAGE_PROXY}?rating_key=${item['grandparent_rating_key']}&type=poster";
    $newItem['last_watch'] = $item['stopped'];
    $newItem['user'] = $item['friendly_name'];
    $newItem['id'] = $item['id'];
    array_push($HISTORY, $newItem);
  }
}
foreach ($MOVIE_HISTORY['response']['data']['data'] as $item) {
  if ($item['state'] !== 'playing' && $item['percent_complete'] >= 80) {
    $newItem = array();
    $newItem['media_type'] = "movie";
    $newItem['title'] = $item['title'];
    $RATING_KEY = getInbetweenStrings("\/library\/metadata\/", "\/thumb\/", $item['thumb'])[0];
    $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=poster";
    $newItem['last_watch'] = $item['stopped'];
    $newItem['user'] = $item['friendly_name'];
    $newItem['id'] = $item['id'];
    array_push($HISTORY, $newItem);
  }
}

usort($HISTORY, function ($item1, $item2) {
  if ($item1['last_watch'] == $item2['last_watch']) return 0;
  return $item1['last_watch'] > $item2['last_watch'] ? -1 : 1;
});

echo json_encode(array_slice($HISTORY, 0, $COUNT));

?>