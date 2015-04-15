<?php
// ------------------------------------ 
//  General settings settings
// ------------------------------------

return array(


  'controller' => 'hello',
  'method' => 'index',


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
  // Classmap for core classes
  // ----------------------------------
  'classmap' => array(
    'Database',
    'View',
    'Time',
  ),

);