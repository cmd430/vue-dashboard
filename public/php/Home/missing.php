<?php

  require "../Config/conf.php";

  $CONFIG = new Config();

  $MISSING_SHOWS = $CONFIG->Sonarr("wanted/missing", "page=1&pageSize=50&sortKey=airDateUtc&sortDir=desc&filterKey=monitored&filterValue=true");
  $MISSING_MOVIES = $CONFIG->Radarr("wanted/missing", "page=1&pageSize=50&sortKey=physicalRelease&sortDir=desc&filterKey=physicalRelease");
  $MISSING_ITEMS = [];
  $SERIES_INFO_IDS = [];
  $SERIES_INFO = [];

  foreach ($MISSING_SHOWS['records'] as $SERIES_RAW) {
    if (!in_array($SERIES_RAW['seriesId'], $SERIES_INFO_IDS, true)) {
      $SERIES_INFO[] = $CONFIG->Sonarr("series/{$SERIES_RAW['seriesId']}");
    }
    $SERIES_INFO_RAW = $SERIES_INFO[array_search($SERIES_RAW['seriesId'], array_column($SERIES_INFO, 'id'))];

    $MISSING_ITEMS[] = [
      'title' => $SERIES_RAW['title'],
      'series' => [
        'title' => $SERIES_INFO_RAW['title'],
        'season' => (strlen($SERIES_RAW['seasonNumber']) > 1 ? $SERIES_RAW['seasonNumber'] : "0" . $SERIES_RAW['seasonNumber']),
        'episode' => (strlen($SERIES_RAW['episodeNumber']) > 1 ? $SERIES_RAW['episodeNumber'] : "0" . $SERIES_RAW['episodeNumber']),
        'overview' => (isset($SERIES_INFO_RAW['overview']) ? $SERIES_INFO_RAW['overview'] : ""),
        'poster' => $CONFIG->Proxy("sonarr_id={$SERIES_RAW['seriesId']}")
      ],
      'release' => date('c', strtotime($SERIES_RAW['airDateUtc'] . ' + ' . $SERIES_INFO_RAW['runtime'] . ' minutes')),
      'overview' => (isset($SERIES_RAW['overview']) ? $SERIES_RAW['overview'] : ""),
      'mediatype' => 'episode'
    ];
  }
  foreach ($MISSING_MOVIES['records'] as $MOVIE_RAW) {
    if (isset($MOVIE_RAW['physicalRelease'])) {
      if (strtotime(date('c', strtotime($MOVIE_RAW['physicalRelease']))) < strtotime(date('c'))) {
        $MISSING_ITEMS[] = [
          'title' => $MOVIE_RAW['title'],
          'poster' => $CONFIG->Proxy("radarr_id={$MOVIE_RAW['id']}"),
          'release' => date('c', strtotime($MOVIE_RAW['physicalRelease'])),
          'overview' => (isset($MOVIE_RAW['overview']) ? $MOVIE_RAW['overview'] : ""),
          'mediatype' => 'movie'
        ];
      }
    }
  }

  usort($MISSING_ITEMS, function ($a, $b) {
    if ($a['release'] === $b['release']) return 0;
    return ($a['release'] < $b['release']) ? -1 : 1;
  });

  header("Content-Type: application/json");
  echo json_encode($MISSING_ITEMS);

?>
