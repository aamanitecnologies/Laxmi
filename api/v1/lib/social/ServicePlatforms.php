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
 * @desc   Rt_social_engage  Services platforms Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';
require_once 'config.php';

class ServicePlatform
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new SocialEngage_db();
        return $this->conn = $connection->getDB();
    }

    /**
     * This method return service platforms
     */
    public function getserviceplatforms($service_url)
    {
    	
    	 $sql = "SELECT *  from services where service_url ='".$service_url."'";
		 $result = $this->conn->query($sql);
		 if ($result->num_rows > 0) {
		 	
		 	$data   = $result->fetch_assoc();
		 	$service_id = $data['id'];
		 	
		 	$sql_serviceplatform = "SELECT *  from service_platforms where service_id ='".$service_id."'";
		 	$result_serviceplatform = $this->conn->query($sql_serviceplatform);
		 	if ($result_serviceplatform->num_rows > 0) {
		 	
		 		while ($rowservice = $result_serviceplatform->fetch_assoc())
		 		{
		 			$platforms     = array();
		 			$platforms['service_id'] = $rowservice['service_id'];
		 			$platforms['platform_name'] = $rowservice['platform_name'];
		 			$platforms['platform_download_url'] = $rowservice['platform_download_url'];
		 			$platforms['platform_direct_download_url'] = $rowservice['platform_direct_download_url'];
		 			$platforms['platform_icon'] = $rowservice['platform_icon'];
		 			
		 			$res['platforms'][] = $platforms;
		 			 
		 		}
		 		$res_arr['status']['error']    = false;
		 		$res_arr['payload'] = $res;
		 		return $res_arr;
		 	
		 	}else{
		 	
		 		$res_arr['status']['error']    = true;
		 		$res_arr['status']['message']  = 'No platforms';
		 		return $res_arr;
		 	}
		 	
		 }else{
		 	$res_arr['status']['error']    = true;
		 	$res_arr['status']['message']  = 'No Services found in database';
		 	return $res_arr;
		 	
		 }

    }
    
  
    
    
    
}

?>
