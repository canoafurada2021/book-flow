<?php

//Definição do banco de dados
$_config['db'] = [ 
  "SERVER" => "MYSQL", // server type 
  "DB" => "carteradedomingo_dev", // database name
  "HOST" => "localhost", // database host (dsn or ip)
  "PORT" => 1366,
  "USER" => "portal", // database user ( create, update, delete and insert permissions required )
  "PASSWORD" => "0666", // database password 
  "CHARSET" => "utf8mb4",
];
define("DB_CONFIG", $_config['db']);
define("DEFAULT_LANGUAGE", "pt_br");
if(!isset($_SESSION))session_start();

  define('API_TOKEN_SALT', 'T0k3n*4p1!');
  define('PW_SALT', 'soh*eu*sei!');

?>