<?php
define( 'DBSERVER', 'database' );
define( 'DBNAME', getenv('MYSQL_DATABASE') );
define( 'DBUSER', getenv('MYSQL_USER') );
define( 'DBPASSWORD', getenv('MYSQL_PASSWORD') );
define('SAULT', getenv('SAULT'));
define('FRONTEND_HOST', getenv('FRONTEND_HOST'));
define('BACKEND_HOST', getenv('BACKEND_HOST'));
?>