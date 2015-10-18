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

  $settings = $GLOBALS['config'];

  if(count($errors) > 0 && $settings['debug'] && php_sapi_name() !== 'cli'){
    $html = '<html>';

    $html .= '<head>'
              .'<title>Ups, looks like you broke it.</title>'
              .'<style>'
                .'body { 
                  overflow: hidden; 
                  font-family: gesta, helvetica, verdana;
                  color: #555;
                }'
                
                .'#view { 
                  background: #fff; 
                  position: absolute; 
                  top: 0;  left: 0; 
                  width: 100%; 
                  height: 100%; 
                  overflow: auto; 
                }'

                .'h1 {
                  color: #373F47;
                  font-family: facit;
                  margin-top: 100px;
                  margin-bottom: 80px;
                }'

                .'h1:before {
                  content: "#";
                  display:inline-block;
                  margin-right: 20px;
                  margin-left: -40px;
                  font-weight: 300;
                  color: #8AA39B;
                }'

                .'.item {
                  padding-bottom: 25px;
                  padding-top: 10px;
                  box-shadow: inset 0px -1px rgba(0,0,0,0.06);
                }'

                .'.item:last-child {
                  box-shadow: inset 0px -1px rgba(0,0,0,0.0);
                }'

                .'h3 {
                  color: #8AA39B;
                  margin-bottom: 5px;
                }'

                .'#errors {
                  margin-right: 15%;
                  margin-left: 15%; 
                }'
              .'</style>'
            .'</head><body><div id="view"><div id="errors">'
            .'<h1 class="heading">Ups, looks like something failed...</h1>';

    for($i = 0; $i < count($errors); $i++){
      $error = $errors[$i];
      $html .= '<div class="item">'
                .'<h3>'.$error['str'].', on line '.$error['line'].'</h3>'
                .'<small>'.$error['file'].'</small>'
             .'</div>';
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

