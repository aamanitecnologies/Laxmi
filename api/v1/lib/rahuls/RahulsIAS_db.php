<?php

/**
 * @desc   Database entry point
 *
 * @author Nikhil Nainta
 */
class RahulsIAS_db {

    protected $host = "localhost";
    protected $user = "root";
    protected $pass = "MyLove@07";
    protected $db = "farmaceutical";
    protected $conn;

    function __construct() {
        /*
         * this method Create connection
         */
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    public function getDB() {
        return $this->conn;
    }

}

?>
