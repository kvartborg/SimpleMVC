<?php

$GLOBALS['errors'] = [];
function errorHandler($num, $str, $file, $line, $vars){
  if($line){
    array_push($GLOBALS['errors'], [
      'num' => $num, 
      'str' => $str, 
      'file' => $file,
      'line' => $line,
      'vars' => $vars,
    ]);
  }
}

set_error_handler("errorHandler");
register_shutdown_function('fatalErrorHandler');

function fatalErrorHandler() {
  $f = error_get_last();
  $errors = $GLOBALS['errors'];
  unset($GLOBALS['errors']);
  if($f['type']){
    array_push($errors, [
      'num' => $f['type'],
      'str' => $f['message'],
      'file' => $f['file'],
      'line' => $f['line'],
      'vars' => $GLOBALS,
    ]);
  }

  if(count($errors) > 0){
    $html = '';
    echo '<h1>Errors</h1>';
    for($i = 0; $i < count($errors); $i++){
      $error = $errors[$i];
      $html .= '<p>'
                .'<h3>'.$error['str'].', on line '.$error['line'].'</h3>'
                .'<small>'.$error['file'].'</small>'
             .'</p><hr>';
    }

    echo $html;
  }
}