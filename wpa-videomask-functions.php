<?php


function wpa_videomask_is_amp(){
  return apply_filters( 'wpa_videomask_is_amp', (function_exists( 'is_amp' ) && is_amp()) || ( function_exists( 'amp_is_request' ) && amp_is_request() ) );
}


function wpa_videomask_get_video_id_from_youtube_url(
  $media_url ){

  $leaf = explode("/", $media_url);
  if( !is_array($leaf) ) return;
  $video_id=str_replace("watch?v=", "", $leaf[count($leaf)-1]);
  if( strpos( $video_id, "&" ) ){
    $params = explode("&", $video_id);
    $video_id = $params[0];
  }

  return $video_id;
}


add_filter(
'is_protected_meta',
function( $protected, $meta_key, $meta_type )
{

  if( strpos( $meta_key, '_oembed' ) !== false ){
    return false;
  }

  return $protected;

}, 10, 3 );



function wpa_videomask_amp_content_has_iframe(){
  global $wp_query;
  if( !is_singular() ){ return false; }

  the_post();
  $content = apply_filters( 'the_content', get_the_content() );
  rewind_posts();

  return strpos( $content, '<amp-iframe' ) !== false;
}

function wpa_videomask_amp_content_has_youtube(){
  global $wp_query;
  if( !is_singular() ){ return false; }

  the_post();
  $content = apply_filters( 'the_content', get_the_content() );
  rewind_posts();

  return strpos( $content, '<amp-youtube' ) !== false;
}


// amp head support for wpxt
add_action( 'amp_head', 'wpa_videomask_add_youtube_component' );
function wpa_videomask_add_youtube_component(){

  if( !is_singular() ) return;

  if( wpa_videomask_amp_content_has_youtube() ){
    echo '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>';
  }
  
  if( wpa_videomask_amp_content_has_iframe() ){
    echo '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>';
  }
}