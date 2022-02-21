<?php
/**
 * Created by PhpStorm.
 * User: Nigel Reign
 * Date: 9/2/2021
 * Time: 18:14
 */

session_start();
require_once "../../functions/database_connection/connect.php";
require_once '../../functions/variables.php';
require_once '../../functions/session.php';

if (empty($_SESSION['id'])) {
    header("Location: ../../signin");
}