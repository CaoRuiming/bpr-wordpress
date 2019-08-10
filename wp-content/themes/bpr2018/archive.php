<?php

/*!
	Template Name: Archive Page
	Template Post Type: page
*/

namespace BPRWP\Theme\Archive;

/*
|------------------------------------------------------------------
| Page Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function BPRWP\Theme\App\template;

/**
 * Renders the content of a topical section (cateogory) of the website.
 *
 * @see resources/templates/content-category.tpl.php
 */
template('archive');
