<?php

  require "./Config/conf.php";

  function getMovies() {
    $CONFIG = new Config();
    $MOVIES_QUEUE = $CONFIG->Radarr("queue", "sort_by=timeleft&order=asc");
    $MOVIES = [];
    foreach ($MOVIES_QUEUE as $MOVIE_RAW) {
      $MOVIES[] = [
        'title' => $MOVIE_RAW['movie']['title'],
        'poster' => $CONFIG->Proxy("radarr_id={$MOVIE_RAW['movie']['id']}"),
        'downloading' => [
          'timeleft' => ($MOVIE_RAW['timeleft'] ? $MOVIE_RAW['timeleft'] : 0),
          'progress' => round(($MOVIE_RAW['size'] - $MOVIE_RAW['sizeleft'])/ ($MOVIE_RAW['size'] / 100), 2),
          'status' => strtolower(($MOVIE_RAW['status'] === 'warning' ? 'stalled' : $MOVIE_RAW['status'])),
          'message' => strtolower($MOVIE_RAW['trackedDownloadStatus'])
        ]
      ];
    }
    return $MOVIES;
  }
  function getSeries() {
    $CONFIG = new Config();
    $SERIES_QUEUE = $CONFIG->Sonarr("queue", "sort_by=timeleft&order=asc");
    $SERIES = [];
    foreach ($SERIES_QUEUE as $SERIES_RAW) {
      $SERIES[] = [
        'title' => $SERIES_RAW['episode']['title'],
        'series' => [
          'title' => $SERIES_RAW['series']['title'],
          'season' => (strlen($SERIES_RAW['episode']['seasonNumber']) === 1 ? 0 : null) . $SERIES_RAW['episode']['seasonNumber'],
          'episode' => (strlen($SERIES_RAW['episode']['episodeNumber']) === 1 ? 0 : null) . $SERIES_RAW['episode']['episodeNumber'],
          'poster' => $CONFIG->Proxy("sonarr_id={$SERIES_RAW['series']['id']}")
        ],
        'downloading' => [
          'timeleft' => ($SERIES_RAW['timeleft'] ? $SERIES_RAW['timeleft'] : 0),
          'progress' => round(($SERIES_RAW['size'] - $SERIES_RAW['sizeleft'])/ ($SERIES_RAW['size'] / 100), 2),
          'status' => strtolower(($SERIES_RAW['status'] === 'warning' ? 'stalled' : $SERIES_RAW['status'])),
          'message' => strtolower($SERIES_RAW['trackedDownloadStatus'])
        ]
      ];
    }
    return $SERIES;
  }

  $QUEUE = [
    'series' => getSeries(),
    'movies' => getMovies()
  ];

  header("Content-Type: application/json");
  echo json_encode($QUEUE);

?>