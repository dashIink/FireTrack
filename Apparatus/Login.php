<?php
include_once("../DatabaseClasses/databaseClasses.php");

$username = "";
$password = "";
if(isset($_POST["username"])){
    $username = $_POST["username"];
}
if(isset($_POST["password"])){
    $password = md5($_POST["password"]);
}
$loginFailed = false;
if($username != "" and $password != ""){
    $conn = connect();
    $tbl_apparatusLogin = new tbl_apparatusLogin($conn);
    
    $result = $tbl_apparatusLogin->authorize($username, $password);
    if ($result[0] == true){
        session_unset();
        session_start();
        $_SESSION["AppID"] = $result[1]->id;
        header('Location: ControlMain.php');
    }
    else{
        $loginFailed = true;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Login</h5>
                    <div class="card-body">
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <?php
                            if ($loginFailed){
                                echo "<br><p>Login Failed!<p>";
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>