<?php

  require "../Config/conf.php";

  $START = (isset($_GET['start']) ? "&start=" . $_GET['start'] : "");
  $END = (isset($_GET['end']) ? "&end=" . $_GET['end'] : "");

  function getSeries($START, $END, $CONFIG) {
    $SERIES_QUEUE = json_decode(file_get_contents("{$CONFIG['SONARR']['URL']}/queue?apikey={$CONFIG['SONARR']['API_KEY']}"), true);
    $SERIES_CALENDAR = json_decode(file_get_contents("{$CONFIG['SONARR']['URL']}/calendar?apikey={$CONFIG['SONARR']['API_KEY']}{$START}{$END}&unmonitored=false"), true);
    $SERIES_DOWNLOADING = [];
    $SERIES = [];
    foreach ($SERIES_QUEUE as $SERIES_QUEUE) {
      $SERIES_DOWNLOADING[$SERIES_QUEUE['episode']['id']] = [
        'status' => $SERIES_QUEUE['status'],
        'trackedStatus' => $SERIES_QUEUE['trackedDownloadStatus']
      ];
    }
    foreach ($SERIES_CALENDAR as $SERIES_RAW) {
      $SERIES[] = [
        'title' => $SERIES_RAW['title'],
        'series' => [
          'title' => $SERIES_RAW['series']['title'],
          'season' => (strlen($SERIES_RAW['seasonNumber']) === 1 ? 0 : null) . $SERIES_RAW['seasonNumber'],
          'episode' => (strlen($SERIES_RAW['episodeNumber']) === 1 ? 0 : null) . $SERIES_RAW['episodeNumber'],
          'overview' => (isset($SERIES_RAW['series']['overview']) ? $SERIES_RAW['series']['overview'] : ""),
          'poster' => array_column($SERIES_RAW['series']['images'], 'url', 'coverType')['poster']
        ],
        'release' => (isset($SERIES_RAW['airDateUtc']) ? $SERIES_RAW['airDateUtc'] : null),
        'overview' => (isset($SERIES_RAW['overview']) ? $SERIES_RAW['overview'] : ""),
        'downloaded' => $SERIES_RAW['hasFile'],
        'downloading' => [
          'status' => (in_array($SERIES_RAW['id'], $SERIES_DOWNLOADING) ? strtolower($SERIES_DOWNLOADING[$SERIES_RAW['id']]['status']) : 'idle'),
          'message' => (in_array($SERIES_RAW['id'], $SERIES_DOWNLOADING) ? strtolower($SERIES_DOWNLOADING[$SERIES_RAW['id']]['trackedStatus']) : 'ok')
        ]
      ];
    }
    return $SERIES;
  }
  function getMovies($START, $END, $CONFIG) {
    $MOVIES_QUEUE = json_decode(file_get_contents("{$CONFIG['RADARR']['URL']}/queue?apikey={$CONFIG['RADARR']['API_KEY']}"), true);
    $MOVIES_CALENDAR = json_decode(file_get_contents("{$CONFIG['RADARR']['URL']}/calendar?apikey={$CONFIG['RADARR']['API_KEY']}{$START}{$END}&unmonitored=false"), true);
    $MOVIES_DOWNLOADING = [];
    $MOVIES = [];
    foreach ($MOVIES_QUEUE as $MOVIE_QUEUE) {
      $MOVIES_DOWNLOADING[$MOVIE_QUEUE['movie']['tmdbId']] = [
        'status' => $MOVIE_QUEUE['status'],
        'trackedStatus' => $MOVIE_QUEUE['trackedDownloadStatus']
      ];
    }
    foreach ($MOVIES_CALENDAR as $MOVIE_RAW) {
      $MOVIES[] = [
        'title' => $MOVIE_RAW['title'],
        'poster' => "{$CONFIG['PROXY']['IMAGE']}?tmdb_id={$MOVIE_RAW['tmdbId']}",
        'release' => [
          'cinema' => (isset($MOVIE_RAW['inCinemas']) ? $MOVIE_RAW['inCinemas'] : null),
          'physical' => (isset($MOVIE_RAW['physicalRelease']) ? $MOVIE_RAW['physicalRelease'] : null)
        ],
        'overview' => (isset($MOVIE_RAW['overview']) ? $MOVIE_RAW['overview'] : ""),
        'downloaded' => $MOVIE_RAW['downloaded'],
        'downloading' => [
          'status' => (in_array($MOVIE_RAW['tmdbId'], $MOVIES_DOWNLOADING) ? strtolower($MOVIES_DOWNLOADING[$MOVIE_RAW['tmdbId']]['status']) : 'idle'),
          'message' => (in_array($MOVIE_RAW['tmdbId'], $MOVIES_DOWNLOADING) ? strtolower($MOVIES_DOWNLOADING[$MOVIE_RAW['tmdbId']]['trackedStatus']) : 'ok')
        ]
      ];
    }
    return $MOVIES;
  }

  $CALENDAR = [
    'series' => getSeries($START, $END, $CONFIG),
    'movies' => getMovies($START, $END, $CONFIG)
  ];

  header("Content-Type: application/json");
  echo json_encode($CALENDAR);

?>