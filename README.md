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

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# upload contents of `dist/` to web server
scp -r dist <username>@<hostname>:<destination path>
```
## Requirments

- Plex
- Tautulli
- Sonarr
- Radarr
- qBittorrent

This project requires a webserver with php such as `Nginx + PHP FPM`
