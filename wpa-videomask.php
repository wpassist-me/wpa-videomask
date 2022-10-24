<?php
/**
 * Plugin Name: WPA Videomask
 * Plugin URI: https://wpassist.me/plugins/wpa-videomask/
 * Description: WordPress plugin to display facades on youtube videos
 * Author: Metin Saylan
 * Author URI: https://wpassist.me
 *
 * Version: 20221024
 * Text Domain: wpa-videomask
 *
 * License:     GPLv2 or later
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Invalid request.' );
}


// utility functions
require_once __DIR__ . '/wpa-videomask-functions.php';


// filter to clear oembed providers
add_filter( 'oembed_providers', 'wpa_videomask_noembed', 99 );
function wpa_videomask_noembed( $providers ){
  return [];
}


// filter to clear oembed providers
add_filter(
  'pre_oembed_result',
  'wpa_videomask_pre_oembed_result', 99, 3 );
function wpa_videomask_pre_oembed_result(
  $oembed_result, $url, $args ){

  if( strpos( $url, 'youtu.be' ) !== false
    || strpos( $url, 'youtube.com/watch?v=' ) !== false ){

    $video_id = wpa_videomask_get_video_id_from_youtube_url( $url );

    if( wpa_videomask_is_amp() ){
      
      return "<div class=\"videomask\"><amp-youtube data-videoid=\"{$video_id}\" layout=responsive width=500 height=281 data-param-controls=1></amp-youtube></div>";
    } else {
      return "<div class=\"videomask\"><div data-video-src=\"{$url}\" data-videoid=\"{$video_id}\"><noscript><iframe width=500 height=281 src=\"{$url}\" frameborder=0 allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></noscript></div></div>";
    }
  }

  return $oembed_result;
}


// filter post content for videos
add_filter( 'the_content', 'wpa_videomask_iframe_filter', 99 );
function wpa_videomask_iframe_filter( $content ){
  global $post;
  
  if( wpa_videomask_is_amp() ){
    // remove noscript tags
    $content = preg_replace( '/<noscript>(.*)<\/noscript>/i', '', $content );

    $pattern = '/<div data-video-src=(.*) data-videoid="(.*)">(.*)<\/div>/i';
    $replacement = '<amp-youtube data-videoid="$2" layout=responsive width=500 height=281 data-param-controls=1></amp-youtube>';
    $content = preg_replace( $pattern, $replacement, $content );

  } else {
    /* nothing planned yet */
  }

  return $content;
}


add_action( 'wp_enqueue_scripts', 'wpa_videomask_assets' );
function wpa_videomask_assets() {

  wp_register_style( 
      'wpa-videomask', 
      plugins_url( '/wpa-videomask.css' , __FILE__ )
    );

  wp_register_script( 
      'wpa-videomask', 
      plugins_url( '/wpa-videomask.js' , __FILE__ ),
      false,
      false,
      true
    );

  wp_enqueue_style( 'wpa-videomask' );
  wp_enqueue_script( 'wpa-videomask' );

}

