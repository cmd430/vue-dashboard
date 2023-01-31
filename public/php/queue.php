<?php

  require "./Config/conf.php";

  function getMovies() {
    $CONFIG = new Config();
    $MOVIES_QUEUE = $CONFIG->Radarr("queue", "page=1&pageSize=100&sortDirection=asc&sortKey=timeLeft&includeUnknownMovieItems=false");
    $MOVIES = [];
    $MOVIES_INFO_IDS = [];
    $MOVIES_INFO = [];

    foreach ($MOVIES_QUEUE['records'] as $MOVIE_RAW) {
      if (!in_array($MOVIE_RAW['movieId'], $MOVIES_INFO_IDS, true)) {
        $MOVIES_INFO[] = $CONFIG->Radarr("movie/{$MOVIE_RAW['movieId']}");
      }

      $MOVIE_INFO_RAW = $MOVIES_INFO[array_search($MOVIE_RAW['movieId'], array_column($MOVIES_INFO, 'id'))];

      $MOVIES[] = [
        'title' => $MOVIE_INFO_RAW['title'],
        'poster' => $CONFIG->Proxy("radarr_id={$MOVIE_RAW['movieId']}"),
        'downloading' => [
          'timeleft' => (isset($MOVIE_RAW['timeleft']) ? $MOVIE_RAW['timeleft'] : 0),
          'progress' => $MOVIE_RAW['size'] > 0 ? round(($MOVIE_RAW['size'] - $MOVIE_RAW['sizeleft']) / ($MOVIE_RAW['size'] / 100), 2) : 0,
          'status' => strtolower(($MOVIE_RAW['status'] === 'warning' ? 'stalled' : $MOVIE_RAW['status'])),
          'message' => strtolower($MOVIE_RAW['trackedDownloadStatus'])
        ]
      ];
    }
    return $MOVIES;
  }
  function getSeries() {
    $CONFIG = new Config();
    $SERIES_QUEUE = $CONFIG->Sonarr("queue");
    $SERIES = [];
    $SERIES_INFO_IDS = [];
    $SERIES_INFO = [];

    foreach ($SERIES_QUEUE['records'] as $SERIES_RAW) {
      if (!in_array($SERIES_RAW['seriesId'], $SERIES_INFO_IDS, true)) {
        $SERIES_INFO[] = $CONFIG->Sonarr("series/{$SERIES_RAW['seriesId']}");
      }

      $SERIES_INFO_RAW = $SERIES_INFO[array_search($SERIES_RAW['seriesId'], array_column($SERIES_INFO, 'id'))];
      $EPISODE_INFO_RAW = $CONFIG->Sonarr("episode/{$SERIES_RAW['episodeId']}");

      $SERIES[] = [
        'title' => $EPISODE_INFO_RAW['title'],
        'series' => [
          'title' => $SERIES_INFO_RAW['title'],
          'season' => (strlen($EPISODE_INFO_RAW['seasonNumber']) === 1 ? 0 : null) . $EPISODE_INFO_RAW['seasonNumber'],
          'episode' => (strlen($EPISODE_INFO_RAW['episodeNumber']) === 1 ? 0 : null) . $EPISODE_INFO_RAW['episodeNumber'],
          'poster' => $CONFIG->Proxy("sonarr_id={$SERIES_RAW['seriesId']}")
        ],
        'downloading' => [
          'timeleft' => (isset($SERIES_RAW['timeleft']) ? $SERIES_RAW['timeleft'] : 0),
          'progress' => $SERIES_RAW['size'] > 0 ? round(($SERIES_RAW['size'] - $SERIES_RAW['sizeleft']) / ($SERIES_RAW['size'] / 100), 2) : 0,
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
