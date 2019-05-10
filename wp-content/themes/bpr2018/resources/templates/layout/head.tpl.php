<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <main id="app" class="app">
            <nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4 header left"></div>
                        <div class="col-sm-4 header-center">
                            <a href="<?= get_home_url(); ?>">
                                <div class="header-logo" style="background-image: url(<?php echo get_template_directory_uri() . '/resources/assets/images/BPR_logo_black.png' ?>)"></div>
                            </a>
                        </div>
                        <div class="col-sm-4 header-right"></div>
                    </div>
                </div>
            </nav>
