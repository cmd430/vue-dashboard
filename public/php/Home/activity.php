<?php

  require "../Config/conf.php";

  $CONFIG = new Config();

  $CURRENT_ACTIVITY = $CONFIG->Tautulli("get_activity");
  $ACTIVITY = [];

  foreach ($CURRENT_ACTIVITY['response']['data']['sessions'] as $ACTIVITY_RAW) {
    if ($ACTIVITY_RAW['media_type'] == "episode") {
      $ACTIVITY[] = [
        'title' => $ACTIVITY_RAW['title'],
        'series' => [
          'title' => $ACTIVITY_RAW['grandparent_title'],
          'season' => (strlen($ACTIVITY_RAW['parent_media_index']) > 1 ? $ACTIVITY_RAW['parent_media_index'] : "0" . $ACTIVITY_RAW['parent_media_index']),
          'episode' => (strlen($ACTIVITY_RAW['media_index']) > 1 ? $ACTIVITY_RAW['media_index'] : "0" . $ACTIVITY_RAW['media_index']),
          'images' => [
            'poster' => $CONFIG->Proxy("rating_key={$ACTIVITY_RAW['grandparent_rating_key']}&type=thumb"),
            'art' => $CONFIG->Proxy("rating_key={$ACTIVITY_RAW['grandparent_rating_key']}&type=art")
          ]
        ],
        'playback' => [
          'user' => $ACTIVITY_RAW['friendly_name'],
          'state' => $ACTIVITY_RAW['state'],
          'runtime' => $ACTIVITY_RAW['stream_duration'],
          'quality' => $ACTIVITY_RAW['stream_video_resolution'],
          'progress' => [
            'percent' => $ACTIVITY_RAW['progress_percent'],
            'time' => $ACTIVITY_RAW['view_offset']
          ]
        ],
        'mediatype' => 'episode'
      ];
    } else if ($ACTIVITY_RAW['media_type'] == 'movie') {
      $ACTIVITY[] = [
        'title' => $ACTIVITY_RAW['title'],
        'images' => [
          'poster' => $CONFIG->Proxy("rating_key={$ACTIVITY_RAW['rating_key']}&type=thumb"),
          'art' => $CONFIG->Proxy("rating_key={$ACTIVITY_RAW['rating_key']}&type=art")
        ],
        'playback' => [
          'user' => $ACTIVITY_RAW['friendly_name'],
          'state' => $ACTIVITY_RAW['state'],
          'runtime' => $ACTIVITY_RAW['stream_duration'],
          'quality' => $ACTIVITY_RAW['stream_video_resolution'],
          'progress' => [
            'percent' => $ACTIVITY_RAW['progress_percent'],
            'time' => $ACTIVITY_RAW['view_offset']
          ]
        ],
        'mediatype' => 'movie'
      ];
    }
  }

  header("Content-Type: application/json");
  echo json_encode($ACTIVITY);

?>