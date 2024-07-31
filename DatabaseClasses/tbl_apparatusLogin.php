<?php
include_once("db.php");

class tbl_apparatusLogin_{
    public $id = -1;
    public $username = "";
    public $stationNumber = "";
    public $appType = "";
    public $appNumber = "";
}

class tbl_apparatusLogin {
    private $conn;

    

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createApparatus($username, $password, $stationNumber, $appType, $appNumber) {
        $stmt = $this->conn->prepare("INSERT INTO `tbl_apparatusLogin` (username, password, stationNumber, appType, appNumber) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $stationNumber, $appType, $appNumber);
        $stmt->execute();
        $stmt->close();
    }

    public function updateUser($userID, $username, $password, $userType, $verificationStatus, $name, $stationNumber) {
        // Implement the logic to update an existing user in the 'User' table
        // ...
    }

    public function deleteUser($userID) {
        // Implement the logic to delete a user from the 'User' table
        // ...
    }

    public function getAppByID($appID) {
        $stmt = $this->conn->prepare("SELECT * FROM `tbl_apparatusLogin` WHERE id=?");
        $stmt->bind_param("i", $appID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if ($user != null){
            return $this->mapToObject($user);
        }
        return false;
        
    }

    public function authorize($username, $password){
        $stmt = $this->conn->prepare("SELECT id FROM `tbl_apparatusLogin` WHERE Username LIKE ? AND Password LIKE ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        

        if ($user != null){
            return array(true, $this->mapToObject($user));
        }
        return false;
    }

    private function mapToObject($tableResult){
        $mappedObject = new tbl_apparatusLogin_;
        if(isset($tableResult["id"])){
            $mappedObject->id = $tableResult["id"];
        }
        if(isset($tableResult["username"])){
            $mappedObject->username = $tableResult["username"];
        }
        if(isset($tableResult["stationNumber"])){
            $mappedObject->stationNumber = $tableResult["stationNumber"];
        }
        if(isset($tableResult["appType"])){
            $mappedObject->appType = $tableResult["appType"];
        }
        if(isset($tableResult["appNumber"])){
            $mappedObject->appNumber = $tableResult["appNumber"];
        }
        

        return $mappedObject;
    }



    // Add more functions as needed
}
?>