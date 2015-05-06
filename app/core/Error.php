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

  $settings = include __DIR__."../../config/app.php";

  if(count($errors) > 0 && $settings['debug']){
    $html = '<html>';

    $html .= '<head>'
              .'<style>'
                .'body { overflow: hidden; font-family: helvetica, verdana }'
                .'#view { background: #f8f8f8; position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: auto; }'
                .'#errors { width: 80%; margin-left: 10%;  }'
              .'</style>'
            .'</head><body><div id="view"><div id="errors">';

    for($i = 0; $i < count($errors); $i++){
      $error = $errors[$i];
      $html .= '<p>'
                .'<h3>'.$error['str'].', on line '.$error['line'].'</h3>'
                .'<small>'.$error['file'].'</small>'
             .'</p><hr>';
    }

    $html .= '</div></div></body></html>';

    echo $html;
  }
}



class Error {
  public static function set($str, $file = __FILE__, $line = __LINE__){
    $GLOBALS['errors'][] = ['num' => 0, 'str' => $str, 'file' => $file, 'line' => $line, 'vars' => $GLOBALS];
  }
}

