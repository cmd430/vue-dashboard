# vue-dashboard (Name TBD)

> A Dashboard for showing information about a Plex, Tautulli, Sonarr and Radarr Media server

## Screenshots

![](./home.png?raw=true "Home Page")
![](./calendar.png?raw=true "Calendar")
![](./queue.png?raw=true "Download Queue")

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

This project requires a webserver with php such as `Nginx + PHP FPM`

- Plex
- Tautulli
- Sonarr
- Radarr
- qBittorrent
- Webserver i.e `Nginx`
  - PHP `7.2+`

## License
GNU GENERAL PUBLIC LICENSE

 Version 3, 29 June 2007

 Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.