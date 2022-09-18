<?php
define('APP_NAME', 'فزعة');
define('APP_DOMAIN', 'http://localhost');
define('APP_FOLDER', '/251');
define('APP_URL', APP_DOMAIN . APP_FOLDER . '/');
define('ROOT_DIR',dirname(__FILE__));
define('debug', 1);
define('DB_CREDS', [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'car_break_system'
]);

if (debug) {
}
// // Create connection
// $conn = new mysqli($db['host'], $db['username'], $db['password'], $db['dbname']);

// if($conn->connect_error){
//     die("Can't connect to DB");
// }