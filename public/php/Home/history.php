<?php

  require "../Config/conf.php";

  $CONFIG = new Config();

  $LIMIT = 9;
  $TV_HISTORY = $CONFIG->Tautulli("get_history", "section_id=2");
  $MOVIE_HISTORY = $CONFIG->Tautulli("get_history", "section_id=1");
  $HISTORY = [];

  foreach ($TV_HISTORY['response']['data']['data'] as $TV_RAW) {
    if ($TV_RAW['state'] !== 'playing' && $TV_RAW['percent_complete'] >= 80) {
      $HISTORY[] = [
        'title' => explode(" - ", $TV_RAW['full_title'])[1],
        'series' => [
          'title' => $TV_RAW['grandparent_title'],
          'season' => (strlen($TV_RAW['parent_media_index']) > 1 ? $TV_RAW['parent_media_index'] : "0" . $TV_RAW['parent_media_index']),
          'episode' => (strlen($TV_RAW['media_index']) > 1 ? $TV_RAW['media_index'] : "0" . $TV_RAW['media_index']),
          'poster' => $CONFIG->Proxy("rating_key={$TV_RAW['grandparent_rating_key']}&type=poster")
        ],
        'mediatype' => 'episode',
        'watched' => [
          'stopped' => date('c', $TV_RAW['stopped']),
          'user' => $TV_RAW['friendly_name']
        ]
      ];
    }
  }
  foreach ($MOVIE_HISTORY['response']['data']['data'] as $MOVIE_RAW) {
    if ($MOVIE_RAW['state'] !== 'playing' && $MOVIE_RAW['percent_complete'] >= 80) {
      $HISTORY[] = [
        'title' => $MOVIE_RAW['full_title'],
        'poster' => $CONFIG->Proxy("rating_key={$MOVIE_RAW['rating_key']}&type=poster"),
        'mediatype' => 'movie',
        'watched' => [
          'stopped' => date('c', $MOVIE_RAW['stopped']),
          'user' => $MOVIE_RAW['friendly_name']
        ]
      ];
    }
  }

  usort($HISTORY, function ($a, $b) {
    if ($a['watched']['stopped'] === $b['watched']['stopped']) return 0;
    return $a['watched']['stopped'] > $b['watched']['stopped'] ? -1 : 1;
  });

  header("Content-Type: application/json");
  echo json_encode(array_slice($HISTORY, 0, $LIMIT));

?>