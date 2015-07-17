<?php

function requireFolder($folder){
  $files = scandir($folder);
  for($n = 2; $n < count($files); $n++){
    $dir = $folder.'/'.$files[$n];
    if(is_dir($dir))
      requireFolder($dir);
    else 
      requireFile($dir);
  }
}

function requireFile($file){
  if(strpos($file, '.php') !== false && is_file($file))
    require_once $file;
}

function boot(){
  $folders = ['core', 'models'];
  
  for($i = 0; $i < count($folders); $i++){
    $files = scandir(__DIR__.'/'.$folders[$i]);
    for($n = 2; $n < count($files); $n++){
      $dir = __DIR__.'/'.$folders[$i].'/'.$files[$n];
      if(is_dir($dir))
        requireFolder($dir);
      else
        requireFile($dir);
    }
  }
}

boot();

require_once __DIR__."/routes.php";

$app = new App;