<?php
if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('cmn-marketing-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
});
