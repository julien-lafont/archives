<?php 

function bitly($url)
{
  return file_get_contents('http://api.bit.ly/v3/shorten?login='.sfConfig::get('app_bitly_login').'&apiKey='.sfConfig::get('app_bitly_cle').'&longUrl='.urlencode($url).'&format=txt');
}

function bitTest($url)
{
  echo 'http://api.bit.ly/v3/shorten?login='.sfConfig::get('app_bitly_login').'&apiKey='.sfConfig::get('app_bitly_cle').'&longUrl='.urlencode($url).'/&format=txt';
  
}
?>