<?php

  require "./Config/conf.php";

  $START = (isset($_GET['start']) ? "start=" . $_GET['start'] : "");
  $END = (isset($_GET['end']) ? "end=" . $_GET['end'] : "");

  function safeRound($LEFT, $RIGHT) {
    try {
      return round($LEFT / $RIGHT, 2);
    } catch (DivisionByZeroError $e) {
      return 0;
    }
  }

  function getSeries($START, $END) {
    $CONFIG = new Config();
    $SERIES_QUEUE = $CONFIG->Sonarr("queue");
    $SERIES_CALENDAR = $CONFIG->Sonarr("calendar", "{$START}&{$END}&unmonitored=false");
    $SERIES_UPCOMMING = $CONFIG->Sonarr("calendar", "end=" . date('Y-m-d', strtotime('midnight tomorrow')) ."&unmonitored=false");
    $SERIES_DOWNLOADING = [];
    $SERIES_UPCOMMING_EPISODES = [];
    $SERIES_IDS = [];
    $SERIES = [];
    $SERIES_INFO_IDS = [];
    $SERIES_INFO = [];

    foreach ($SERIES_QUEUE as $SHOW_QUEUE => $SHOW) {
      $SERIES_DOWNLOADING[isset($SHOW['episode']['id'])] = [
        'status' => (isset($SHOW['status']) === 'warning' ? 'stalled' : isset($SHOW['status'])),
        'trackedStatus' => isset($SHOW['trackedDownloadStatus']),
        'progress' => safeRound((isset($SHOW['size']) - isset($SHOW['sizeleft'])), (isset($SHOW['size']) / 100), 2)
      ];
    }
    foreach ($SERIES_UPCOMMING as $UPCOMMING) {
      $SERIES_UPCOMMING_EPISODES[] = $UPCOMMING['id'];
    }
    foreach ($SERIES_CALENDAR as $SERIES_RAW) {
      $NEXT = null;

      if ($SERIES_RAW['hasFile'] === false && !in_array($SERIES_RAW['seriesId'], $SERIES_IDS, true) && !in_array($SERIES_RAW['id'], $SERIES_UPCOMMING_EPISODES)) {
        $SERIES_IDS[] = $SERIES_RAW['seriesId'];
        $NEXT = 'next';
      }
      if (!in_array($SERIES_RAW['seriesId'], $SERIES_INFO_IDS, true)) {
        $SERIES_INFO[] = $CONFIG->Sonarr("series/{$SERIES_RAW['seriesId']}");
      }

      $SERIES_INFO_RAW = $SERIES_INFO[array_search($SERIES_RAW['seriesId'], array_column($SERIES_INFO, 'id'))];

      $SERIES[] = [
        'title' => $SERIES_RAW['title'],
        'series' => [
          'title' => $SERIES_INFO_RAW['title'],
          'season' => (strlen($SERIES_RAW['seasonNumber']) === 1 ? 0 : null) . $SERIES_RAW['seasonNumber'],
          'episode' => (strlen($SERIES_RAW['episodeNumber']) === 1 ? 0 : null) . $SERIES_RAW['episodeNumber'],
          'overview' => (isset($SERIES_INFO_RAW['overview']) ? $SERIES_INFO_RAW['overview'] : ""),
          'poster' => $CONFIG->Proxy("sonarr_id={$SERIES_RAW['seriesId']}"),
          'network' => $SERIES_INFO_RAW['network']
        ],
        'release' => [
          'air' => (isset($SERIES_RAW['airDateUtc']) ? $SERIES_RAW['airDateUtc'] : null),
          'runtime' => $SERIES_INFO_RAW['runtime'],
          'status' => (in_array($SERIES_RAW['id'], $SERIES_UPCOMMING_EPISODES) ? 'today' : $NEXT)
        ],
        'overview' => (isset($SERIES_RAW['overview']) ? $SERIES_RAW['overview'] : ""),
        'downloaded' => $SERIES_RAW['hasFile'],
        'downloading' => [
          'status' => (array_key_exists($SERIES_RAW['id'], $SERIES_DOWNLOADING) ? strtolower($SERIES_DOWNLOADING[$SERIES_RAW['id']]['status']) : 'idle'),
          'message' => (array_key_exists($SERIES_RAW['id'], $SERIES_DOWNLOADING) ? strtolower($SERIES_DOWNLOADING[$SERIES_RAW['id']]['trackedStatus']) : 'ok'),
          'progress' => (array_key_exists($SERIES_RAW['id'], $SERIES_DOWNLOADING) ? $SERIES_DOWNLOADING[$SERIES_RAW['id']]['progress'] : 0)
        ]
      ];
    }
    return $SERIES;
  }
  function getMovies($START, $END) {
    $CONFIG = new Config();
    $MOVIES_QUEUE = $CONFIG->Radarr("queue");
    $MOVIES_CALENDAR = $CONFIG->Radarr("calendar", "{$START}&{$END}&unmonitored=false");
    $MOVIES_DOWNLOADING = [];
    $MOVIES = [];
    foreach ($MOVIES_QUEUE as $MOVIE_QUEUE => $MOVIE) {
      $MOVIES_DOWNLOADING[isset($MOVIE['movie']['tmdbId'])] = [
        'status' => (isset($MOVIE['status']) === 'warning' ? 'stalled' : isset($MOVIE['status'])),
        'trackedStatus' => isset($MOVIE['trackedDownloadStatus']),
        'progress' => safeRound((isset($MOVIE['size']) - isset($MOVIE['sizeleft'])), (isset($MOVIE['size']) / 100), 2)
      ];
    }
    foreach ($MOVIES_CALENDAR as $MOVIE_RAW) {
      $MOVIES[] = [
        'title' => $MOVIE_RAW['title'],
        'poster' => $CONFIG->Proxy("radarr_id={$MOVIE_RAW['id']}"),
        'release' => [
          'cinema' => (isset($MOVIE_RAW['inCinemas']) ? $MOVIE_RAW['inCinemas'] : null),
          'physical' => (isset($MOVIE_RAW['physicalRelease']) ? $MOVIE_RAW['physicalRelease'] : null),
          'runtime' => $MOVIE_RAW['runtime'],
          'status' => strtolower($MOVIE_RAW['status'])
        ],
        'studio' => $MOVIE_RAW['studio'],
        'overview' => (isset($MOVIE_RAW['overview']) ? $MOVIE_RAW['overview'] : ""),
        'downloaded' => $MOVIE_RAW['hasFile'],
        'downloading' => [
          'status' => (array_key_exists($MOVIE_RAW['tmdbId'], $MOVIES_DOWNLOADING) ? strtolower($MOVIES_DOWNLOADING[$MOVIE_RAW['tmdbId']]['status']) : 'idle'),
          'message' => (array_key_exists($MOVIE_RAW['tmdbId'], $MOVIES_DOWNLOADING) ? strtolower($MOVIES_DOWNLOADING[$MOVIE_RAW['tmdbId']]['trackedStatus']) : 'ok'),
          'progress' => (array_key_exists($MOVIE_RAW['id'], $MOVIES_DOWNLOADING) ? $MOVIES_DOWNLOADING[$MOVIE_RAW['id']]['progress'] : 0)
        ]
      ];
    }
    return $MOVIES;
  }

  $CALENDAR = [
    'series' => getSeries($START, $END),
    'movies' => getMovies($START, $END)
  ];

  header("Content-Type: application/json");
  echo json_encode($CALENDAR);

?>
