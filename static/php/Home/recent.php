<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $COUNT = 10;

  $RECENT_ADDED_SHOWS = json_decode(file_get_contents("${TAUTULLI}/api/v2?apikey=${API_KEY_TAUTULLI}&cmd=get_recently_added&count=${COUNT}&type=show"), true);
  $RECENT_ADDED_MOVIES = json_decode(file_get_contents("${TAUTULLI}/api/v2?apikey=${API_KEY_TAUTULLI}&cmd=get_recently_added&count=${COUNT}&type=movie"), true);

  $RECENT_ITEMS = array();

  foreach ($RECENT_ADDED_SHOWS['response']['data']['recently_added'] as $item) {
    $newItem = array();
    if ($item['media_type'] == "episode") {
      $newItem['series']['title'] = $item['grandparent_title'];
      $newItem['series']['season'] = $item['parent_media_index'];
      $newItem['series']['episode'] = $item['media_index'];
      $newItem['series']['episode_title'] = $item['title'];
    } else if ($item['media_type'] == 'series') {
      $newItem['series']['title'] = $item['parent_title'];
      $newItem['series']['season'] = $item['media_index'];
    } else {
      continue;
    }
    $newItem['media_type'] = $item['media_type'];
    $newItem['image'] = "/static/php/Shared/image.php?rating_key=" . $item['rating_key'] . "&type=thumb";
    $newItem['added_at'] = $item['added_at'];
    array_push($RECENT_ITEMS, $newItem);
  }
  foreach ($RECENT_ADDED_MOVIES['response']['data']['recently_added'] as $item) {
    $newItem = array();
    if ($item['media_type'] == "movie") {
      $newItem['title'] = $item['full_title'];
    } else {
      continue;
    }
    $newItem['media_type'] = $item['media_type'];
    $newItem['image'] = "/static/php/Shared/image.php?rating_key=" . $item['rating_key'] . "&type=thumb";
    $newItem['added_at'] = $item['added_at'];
    array_push($RECENT_ITEMS, $newItem);
  }

  usort($RECENT_ITEMS, function ($a, $b) {
    if ($a['added_at'] == $b['added_at']) return 0;
    return ($a['added_at'] > $b['added_at']) ? -1 : 1;
  });

  echo json_encode(array_slice($RECENT_ITEMS, 0, $COUNT));

?>