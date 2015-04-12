<?php
// ------------------------------------ 
//  General settings settings
// ------------------------------------

return array(

  // ----------------------------------
  // Set the default controller/home controller

  'controller' => 'hello',

  // ----------------------------------
  // Set the default method

  'method' => 'index',

  // ----------------------------------
  // Date format

  'date_format' => 'Y-m-d H:i:s',

  // ----------------------------------
  // Set timezone

  'timezone' => 'UTC',


  // ----------------------------------
  // HTTPS
  'ssl' => false,


  // ----------------------------------
  // Classmap for core classes
  'classmap' => array(
    'Database',
    'View',
    'Time',
  ),

);