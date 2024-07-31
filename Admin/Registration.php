<?php
include_once("../DatabaseClasses/databaseClasses.php");

$username = "";
$password = "";
$stationNumber = "";
$appType = "";
$appNumber = "";
if(isset($_POST["username"])){
    $username = $_POST["username"];
    unset($_POST["username"]);
}
if(isset($_POST["password"])){
    $password = md5($_POST["password"]);
    unset($_POST["password"]);
}
if(isset($_POST["stationNumber"])){
    $stationNumber = $_POST["stationNumber"];
    unset($_POST["stationNumber"]);
}
if(isset($_POST["appType"])){
    $appType = $_POST["appType"];
    unset($_POST["appType"]);
}
if(isset($_POST["appNumber"])){
    $appNumber = $_POST["appNumber"];
    unset($_POST["appNumber"]);
}

$_POST = array();


if($username != "" and $password != "" and $stationNumber != "" and $appType != "" and $appNumber != ""){

    $conn = connect();
    $tbl_apparatusLogin = new tbl_apparatusLogin($conn);

    $tbl_apparatusLogin->createApparatus($username, $password, $stationNumber, $appType, $appNumber);

    header('Location: Registration.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Apparatus</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Register Apparatus</h5>
                    <div class="card-body">
                        <form action="Registration.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="stationNumber">Station Number</label>
                                <input type="text" class="form-control" id="stationNumber" name="stationNumber" required>
                            </div>
                            <div class="form-group">
                                <label for="appType">Apparatus Type</label>
                                <input type="text" class="form-control" id="appType" name="appType" required>
                            </div>
                            <div class="form-group">
                                <label for="appNumber">Apparatus Number</label>
                                <input type="text" class="form-control" id="appNumber" name="appNumber" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>