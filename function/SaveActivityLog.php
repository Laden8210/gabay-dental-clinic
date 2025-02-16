<?php

require '../config/config.php';

session_start();
class SaveActivityLog
{

    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }
    public function saveDataLog($user_id, $activity){
        $sql = "INSERT INTO system_logs (user_id, activity) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $activity);
        $stmt->execute();
        $stmt->close();
        $this->conn->close();
    }

    public function saveLog($activity){
        $user_id = $_SESSION['user_id'];
        $this->saveDataLog($user_id, $activity);
    }
}