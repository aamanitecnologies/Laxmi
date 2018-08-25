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
 * @desc   Rt_social_engage Sub Services  Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';

class SubServices
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new SocialEngage_db();
        return $this->conn = $connection->getDB();
    }

    /**
     * This method return sub services
     */
    
    public function getsubservice($service_id)
    {
    	$sql = "SELECT *  from sub_services where service_id ='" . $service_id . "'";
    	$result = $this->conn->query($sql);
    	if ($result->num_rows > 0)
    	{
    		$row          = $result->fetch_assoc();
    		$service_id   = $row['id'];
    	}else
    	{
    		$res_arr['status']['error']   = true;
    		$res_arr['status']['message'] = 'No sub service found for this service';
    		return $res_arr;
    		
    	}
    	
    }

    
}   