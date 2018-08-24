# vue-dashboard (Name TBD)

> A Dashboard for showing information about a Plex, Tautulli, Sonarr and Radarr Media server

## Screenshots

![](/docs/home.png?raw=true "Home Page")
![](/docs/calendar.png?raw=true "Calendar")
![](/docs/queue.png?raw=true "Download Queue")

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

## Usage

Requires Plex, Tautulli, Sonarr and Radarr

``` php
# make sure to create static/php/Config/conf.php
<?php

  $API_KEY_SONARR = "<YOUR API KEY>";
  $API_KEY_RADARR = "<YOUR API KEY>";
  $API_KEY_TAUTULLI = "<YOUR API KEY>";
  $API_KEY_TMDB = "<YOUR API KEY>";

  $CONNECTION  = "<http|https>";
  $SONARR_HOST = "<IP>";
  $RADARR_HOST = "<IP>";
  $TAUTULLI_HOST = "<IP>";
  $SONARR_PORT = "<PORT>";
  $RADARR_PORT = "<PORT>";
  $TAUTULLI_PORT = "<PORT>";
  $SONARR_BASE = "<BASE PATH [FOR REVERSE PROXY - LEAVE BLANK FOR DEFAULT]>";
  $RADARR_BASE = "<BASE PATH [FOR REVERSE PROXY - LEAVE BLANK FOR DEFAULT]>";
  $TAUTULLI_BASE = "<BASE PATH [FOR REVERSE PROXY - LEAVE BLANK FOR DEFAULT]>";

  $SONARR = $CONNECTION . "://" . $SONARR_HOST . ":" . $SONARR_PORT . $SONARR_BASE;
  $RADARR = $CONNECTION . "://" . $RADARR_HOST . ":" . $RADARR_PORT . $RADARR_BASE;
  $TAUTULLI = $CONNECTION . "://" . $TAUTULLI_HOST . ":" . $TAUTULLI_PORT . $TAUTULLI_BASE;

?>
```
``` bash
# build for production with minification
npm run build

# upload contents of `dist/` to web server
scp -r dist <username>@<hostname>:<destination path>
```
