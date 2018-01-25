<?php
return [
  /*
  |--------------------------------------------------------------------------
  | SOA Generator Config
  |--------------------------------------------------------------------------
  |
  */
  
  'generator'  => [
    'basePath' => app_path(),
    'paths' => [
      'entities'     => 'Models\\Entities',
      'services'     => 'Models\\Services',
      'repositories' => 'Models\\Repositories'
    ],
  ],
];