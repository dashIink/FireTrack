<?php
//Put includes at top of document
include_once("../DatabaseClasses/databaseClasses.php");

//Begin the session, should be coming from the login page or returning from call.
session_start();
$conn = connect();


//Create our tables
$tbl_apparatusLogin = new tbl_apparatusLogin($conn);
$tbl_communication = new tbl_communication($conn);

$appID = -1;

if(isset($_SESSION["AppID"])){
    $appID = $_SESSION["AppID"];
}
$apparatus = $tbl_apparatusLogin->getAppByID($appID);
if($apparatus == false){
    //This will need to be updated to say there was an error on the login page. Not a priority.
    header("location: login.php");
}

$userFound = false;
if($apparatus->id != -1){
    $userFound = true;

    $AppHiveChannel = $tbl_communication->getAppByID($appID);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apparatus Main Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .visible {
            display: block;
        }

        .invisible {
            display: none;
        }
        .alert-card {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            position: relative;
        }
        .alert-card .alert-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2rem;
            color: #721c24;
        }
        .alert-card .card-body {
            padding-top: 50px;
        }

    </style>
</head>
<body>
<div id="toggleDiv" class="visible">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h1 class="card-title"><?php if ($userFound == true){ echo "Logged in as ".$apparatus->appType; echo " Apparatus #"; echo $apparatus->appNumber; } else{ echo "Cannot find Apparatus";}?></h1>
                        <p class="card-text">You are now Logged in. This page will update when an emergency is active.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="alertDiv" class="invisible">
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card alert-card">
                    <div class="card-body text-center">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i> <!-- Not working, find a proper one later -->
                        </div>
                        <h5 class="card-title" id = "alertTitle">Alert Title</h5>
                        <p class="card-text" id = "alertDetails1">This is a sample text for the alert card. You can place additional information here.</p>
                        <p class="card-text" id = "alertDetails2">More details about the alert can go in this section.</p>

                        <button id = "respondingConfirm" class="btn btn-info">Respond</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>

    <script>
        var client = new Paho.MQTT.Client('0c60c31c05c444f6aeb44e7a6bc63fab.s2.eu.hivemq.cloud', 8884, 'web-client');

client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;


//TODO: We can't leave these here, need an env file or some other way of obscuring this
//Problem! Using PHP will print the password to the javascript making it readable. 
//We need another file or class to handle this operation and pass it back
var options = {
    userName: '',
    password: '',
    useSSL: true,
    onSuccess: onConnect,
    onFailure: onFailure
};

client.connect(options);

function onConnect() {
    console.log('Connected');
    client.subscribe('<?php echo $AppHiveChannel->channel; ?>');
    console.log('Subscribed to General topic');
}

function onFailure(error) {
    console.log('Connection failed:', error.errorMessage);
}

function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log('Connection lost:', responseObject.errorMessage);
    }
}

function onMessageArrived(message) {
    console.log('Received message:', message.destinationName, message.payloadString);

    var Alert = JSON.parse(message.payloadString);
    if(Alert.type == "EmergencyAlert"){
        toggleAlertDiv();
        document.getElementById("alertTitle").innerHTML = "Emergency: " + Alert.callCode;
        document.getElementById("alertDetails1").innerHTML = "Address: "+ Alert.address;
        document.getElementById("alertDetails2").innerHTML = Alert.info;
    }
    if(Alert.type == "EmergencyCancel"){
        toggleAlertDiv();
    }
            


}

function toggleAlertDiv(){
    div = document.getElementById('alertDiv');
    if (div.classList.contains('visible')) {
        div.classList.remove('visible');
        div.classList.add('invisible');
    } else {
        div.classList.remove('invisible');
        div.classList.add('visible');
    }
}


    </script>


</body>
</html>
<script>
