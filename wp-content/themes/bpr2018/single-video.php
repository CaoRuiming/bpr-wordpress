<?php

/*!
	Template Name: Video Post
	Template Post Type: post, page, event
*/

namespace BPRWP\Theme\Single;

/*
|------------------------------------------------------------------
| Single Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function BPRWP\Theme\App\template;

/**
 * Renders single post.
 *
 * @see resources/templates/single-video.tpl.php
 */
template('single-video');
