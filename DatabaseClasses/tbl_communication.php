<?php
include_once("db.php");

class tbl_communication_{
    public $id = -1;
    public $channel = "";
}

class tbl_communication {
    private $conn;

    

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createChannel($username, $password, $stationNumber, $appType, $appNumber) {
        
        /*$stmt = $this->conn->prepare("INSERT INTO `tbl_apparatusLogin` (username, password, stationNumber, appType, appNumber) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $stationNumber, $appType, $appNumber);
        $stmt->execute();
        $stmt->close();*/
        //Use this as an example if needed
    }

    public function updateChannel($userID, $username, $password, $userType, $verificationStatus, $name, $stationNumber) {
        // Implement the logic to update an existing user in the 'User' table
        // ...
    }

    public function deleteChannel($userID) {
        // Implement the logic to delete a user from the 'User' table
        // ...
    }

    public function getAppByID($appID) {
        $stmt = $this->conn->prepare("SELECT * FROM `tbl_communication` WHERE AppID=?");
        $stmt->bind_param("i", $appID);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $stmt->close();
        if ($result != null){
            return $this->mapToObject($result);
        }
        return false;
        
    }

    private function mapToObject($tableResult){
        $mappedObject = new tbl_communication_;
        if(isset($tableResult["id"])){
            $mappedObject->id = $tableResult["id"];
        }
        if(isset($tableResult["Channel"])){
            $mappedObject->channel = $tableResult["Channel"];
        }
        
        

        return $mappedObject;
    }



    // Add more functions as needed
}
?>