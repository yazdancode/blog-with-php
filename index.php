<?php

require_once('Database/CreateDB.php');
use Database\CreateDB;

$createDB = new CreateDB();
$createDB->run();
