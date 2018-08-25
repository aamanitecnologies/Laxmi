<?php
/*!
 *********************************************************
 This code is a proprietary of PushFYI Inc
 
 Following may not be used in part or in whole without the
 prior permission of PushFYI Inc
 
 Author: Nikhil Nainta
 Date: 1/12/2017
 Purpose: Social Engage Wrapper and Utility Functions
 *********************************************************
 */
/**
 * @desc   Interface class to the Rt_social_engage
 *            database.
 *
 * @author Nikhil Nainta
 */
class SocialEngage_db
{

   	protected $host = "localhost";
    protected $user = "root";
    protected $pass = "Jarvi5_669";
    protected $db = "engage";
    protected $conn;
    
    function __construct()
    {
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
