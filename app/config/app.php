<?php
// ------------------------------------ 
//  General settings settings
// ------------------------------------

return array(

  // ----------------------------------
  //  Debug
  // ----------------------------------

  'debug' => true,



  'database' => array(
    'driver'    => 'mysql',
    'host'      => 'skemax.com.mysql',
    'database'  => 'skemax_com',
    'username'  => 'skemax_com',
    'password'  => '7cba624f7c1',
    'prefix'    => '',
  ),



  // ----------------------------------
  //  Timezone & Date format
  // ----------------------------------
  
  'timezone'    => 'Europe/Copenhagen',
  'date_format' => 'Y-m-d H:i:s',


  // ----------------------------------
  //  HTTPS
  // ----------------------------------
  'ssl' => true,


  // ----------------------------------
  //  Error overwrite
  // ----------------------------------
  '404' => false,

);