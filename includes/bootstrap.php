<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config/config.php';

use Classes\Auth;
use Classes\Database;
use Classes\Session;

$db = new Database();
$session = new Session();
$auth = new Auth($db, $session);