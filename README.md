# Brown Political Review WordPress Website

## Initial Setup

To run this website locally, installation of software like `MAMP` for macOS or `XAMP` for Windows will be required. Point to the software to the directory containing this repository and start the servers. You may need to create a new MySQL database for the WordPress installation process.

## Startup

The primary theme of this installation is based on Tonik, so installation of dependencies is required. Composer and NPM will need to be installed beforehand.

```
cd wp-content/themes/bpr2018
composer install
npm install
npm run dev
```

To have assets automatically compile on save, run:
```
npm run dev && npm run watch
```

## Setup After Startup

To get the front page working properly, configure WordPress through the admin GUI to set the homepage to a static page (you will need to create a new page before this). This setting can be found in `Settings > Reading > Your homepage displays`.

