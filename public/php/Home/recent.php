<?php

  require "../Config/conf.php";

  $CONFIG = new Config();

  $LIMIT = 9;
  $RECENT_ADDED_SHOWS = $CONFIG->Tautulli("get_recently_added", "count={$LIMIT}&type=show");
  $RECENT_ADDED_MOVIES = $CONFIG->Tautulli("get_recently_added", "count={$LIMIT}&type=movie");
  $RECENT_ITEMS = [];

  foreach ($RECENT_ADDED_SHOWS['response']['data']['recently_added'] as $SERIES_RAW) {
    if ($SERIES_RAW['media_type'] === "episode") {
      $RECENT_ITEMS[] = [
        'title' => $SERIES_RAW['title'],
        'series' => [
          'title' => $SERIES_RAW['grandparent_title'],
          'season' => (strlen($SERIES_RAW['parent_media_index']) > 1 ? $SERIES_RAW['parent_media_index'] : "0" . $SERIES_RAW['parent_media_index']),
          'episode' => (strlen($SERIES_RAW['media_index']) > 1 ? $SERIES_RAW['media_index'] : "0" . $SERIES_RAW['media_index']),
          'poster' => $CONFIG->Proxy("rating_key={$SERIES_RAW['grandparent_rating_key']}&type=thumb")
        ],
        'mediatype' => 'episode',
        'added' => $SERIES_RAW['added_at']
      ];
    }
  }
  foreach ($RECENT_ADDED_MOVIES['response']['data']['recently_added'] as $MOVIE_RAW) {
    if ($MOVIE_RAW['media_type'] == "movie") {
      $RECENT_ITEMS[] = [
        'title' => $MOVIE_RAW['full_title'],
        'poster' => $CONFIG->Proxy("rating_key={$MOVIE_RAW['rating_key']}&type=thumb"),
        'mediatype' => 'movie',
        'added' => $MOVIE_RAW['added_at']
      ];
    }
  }

  usort($RECENT_ITEMS, function ($a, $b) {
    if ($a['added'] === $b['added']) return 0;
    return ($a['added'] > $b['added']) ? -1 : 1;
  });

  header("Content-Type: application/json");
  echo json_encode(array_slice($RECENT_ITEMS, 0, $LIMIT));

?>