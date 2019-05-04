<?php

  include "../Config/conf.php";

  function getMovies() {
    $CONFIG = new Config();
    $MOVIES_QUEUE = $CONFIG->Radarr("queue");
    $MOVIES = [];
    foreach ($MOVIES_QUEUE as $MOVIE_RAW) {
      $MOVIES[] = [
        'title' => $MOVIE_RAW['movie']['title'],
        'poster' => $CONFIG->Proxy("tmdb_id={$MOVIE_RAW['movie']['tmdbId']}"),
        'downloading' => [
          'timeleft' => $MOVIE_RAW['timeleft'],
          'progress' => round(($MOVIE_RAW['size'] - $MOVIE_RAW['sizeleft'])/ ($MOVIE_RAW['size'] / 100), 2),
          'status' => $MOVIE_RAW['status'],
          'trackedStatus' => $MOVIE_RAW['trackedDownloadStatus']
        ]
      ];
    }
    return $MOVIES;
  }
  function getSeries() {
    $CONFIG = new Config();
    $SERIES_QUEUE = $CONFIG->Sonarr("queue");
    $SERIES = [];
    foreach ($SERIES_QUEUE as $SERIES_RAW) {
      $SERIES[] = [
        'title' => $SERIES_RAW['episode']['title'],
        'series' => [
          'title' => $SERIES_RAW['series']['title'],
          'season' => (strlen($SERIES_RAW['episode']['seasonNumber']) === 1 ? 0 : null) . $SERIES_RAW['episode']['seasonNumber'],
          'episode' => (strlen($SERIES_RAW['episode']['episodeNumber']) === 1 ? 0 : null) . $SERIES_RAW['episode']['episodeNumber'],
          'poster' => array_column($SERIES_RAW['series']['images'], 'url', 'coverType')['poster']
        ],
        'downloading' => [
          'timeleft' => $SERIES_RAW['timeleft'],
          'progress' => round(($SERIES_RAW['size'] - $SERIES_RAW['sizeleft'])/ ($SERIES_RAW['size'] / 100), 2),
          'status' => $SERIES_RAW['status'],
          'trackedStatus' => $SERIES_RAW['trackedDownloadStatus']
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