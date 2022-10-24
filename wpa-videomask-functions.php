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