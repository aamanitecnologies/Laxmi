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
 * @desc   Rt_social_engage  UserSubServices  Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';

class UserSubServices
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new SocialEngage_db();
        return $this->conn = $connection->getDB();
    }

    /**
     * This method return service
     */
    public function getusersubservice($email,$channel , $service_uuid)
    {
    	
    	// get user id from email
    	
    	$sql_email    = "SELECT * from users where useremail ='" . $email . "'";
    	$result_email = $this->conn->query($sql_email);
    	if ($result_email->num_rows > 0) {
    		$row     = $result_email->fetch_assoc();
    		$user_id = $row['id'];
    		
    		//get service id from servie_uuid
    		$sql_services = "SELECT *  from services where service_uuid ='".$service_uuid."'";
    		$result_services = $this->conn->query($sql_services);
    		if ($result_services->num_rows > 0) {
    			$data     = $result_services->fetch_assoc();
    			$service_id = $data['id'];
			    $service_config_url = $data['service_config_url'];
			    
			    $service_config_url = APP_BASE_URL."configure/".$service_config_url;
			    
			    $sql_getuserserviceid = "SELECT id from user_services where user_id='".$user_id."' and service_id='" . $service_id . "'";
			    $result_getuserserviceid = $this->conn->query($sql_getuserserviceid);
			    if ($result_getuserserviceid->num_rows > 0)
			    {
			    	$dataservice     = $result_getuserserviceid->fetch_assoc();
			    	$user_service_id = $dataservice['id'];
			    	
    			//sub services
			     $sql_search  = "SELECT sub_services.code,sub_services.cta_text,sub_services.name,sub_services.icon,sub_services.cover,sub_services.short_desc,sub_services.long_desc,sub_services.is_paid,sub_services.monthly_price,sub_services.currency_code FROM sub_services LEFT JOIN user_sub_services ON sub_services.id = user_sub_services.sub_service_id WHERE user_sub_services.user_service_id='".$user_service_id."'";
			    	 
    			$result_search = $this->conn->query($sql_search);
    			if ($result_search->num_rows > 0) {
    				 
    			
    				while ($rowservice = $result_search->fetch_assoc())
    				{
    					$sub_service     = array();
    					$sub_service['code']   = $rowservice['code'];
    					$sub_service['name'] = $rowservice['name'];
    					$sub_service['icon'] = $rowservice['icon'];
    					$sub_service['cover'] = $rowservice['cover'];
    					$sub_service['short_desc'] = $rowservice['short_desc'];
    					$sub_service['long_desc'] = $rowservice['long_desc'];
    					$sub_service['is_paid'] = $rowservice['is_paid'];
    					$sub_service['monthly_price'] = $rowservice['monthly_price'];
    					$sub_service['annual_price'] = $rowservice['annual_price'];
    					$sub_service['currency_code'] = $rowservice['currency_code'];
    					$sub_service['cta_text'] = $rowservice['cta_text'];
    					$sub_service['service_config_url'] = $service_config_url;
    				

					//add sub service config url
					//$sub_service['sub_service_config_url'] = 
    					$res['user_sub_services'][] = $sub_service;
    					
    					
    				
    				}
    				$res_arr['status']['error']    = false;
    				$res_arr['payload'] = $res;
    				return $res_arr;
    				
    			}//
    			
    			}else{
    				$res_arr['status']['error']    = true;
    				$res_arr['status']['message']  = 'invalid url';
    				return $res_arr;
    			
    			
    			
    			}	
    		}else{
    			$res_arr['status']['error']    = true;
    			$res_arr['status']['message']  = 'invalid service  uuid';
    			return $res_arr;
    		}
    	}else{
    		$res_arr['status']['error']    = true;
    		$res_arr['status']['message']  = 'invalid Email id';
    		return $res_arr;
    	}

    	
    	
    	
    	
    	
        
           
    }
    

    /**
     * This method return service
     */
    public function usersubservicesbyid($userid, $service_uuid)
    {

    		//get service id from servie_uuid
    		$sql_services = "SELECT *  from services where service_uuid ='".$service_uuid."'";
    		$result_services = $this->conn->query($sql_services);
    		if ($result_services->num_rows > 0) {
    			$data     = $result_services->fetch_assoc();
    			$service_id = $data['id'];
    			$service_config_url = $data['service_config_url'];
    			 
    			$service_config_url = APP_BASE_URL.$service_config_url;
    			
    			$sql_getuserserviceid = "SELECT id from user_services where user_id='".$userid."' and service_id='" . $service_id . "'";
    			$result_getuserserviceid = $this->conn->query($sql_getuserserviceid);
    			if ($result_getuserserviceid->num_rows > 0)
    			{
    				$dataservice     = $result_getuserserviceid->fetch_assoc();
    				$user_service_id = $dataservice['id'];
    
    				//sub services
    				$sql_search  = "SELECT sub_services.code,sub_services.cta_text,sub_services.name,sub_services.icon,sub_services.cover,sub_services.short_desc,sub_services.long_desc,sub_services.is_paid,sub_services.monthly_price,sub_services.currency_code, user_sub_services.id FROM sub_services LEFT JOIN user_sub_services ON sub_services.id = user_sub_services.sub_service_id WHERE user_sub_services.user_service_id='".$user_service_id."'";
    			  
    				$result_search = $this->conn->query($sql_search);
    				if ($result_search->num_rows > 0) {
    					while ($rowservice = $result_search->fetch_assoc())
    					{
    						$sub_service     = array();
    						$sub_service['id'] = $rowservice['id'];
    						$sub_service['code']   = $rowservice['code'];
    						$sub_service['name'] = $rowservice['name'];
    						$sub_service['icon'] = $rowservice['icon'];
    						$sub_service['cover'] = $rowservice['cover'];
    						$sub_service['short_desc'] = $rowservice['short_desc'];
    						$sub_service['long_desc'] = $rowservice['long_desc'];
    						$sub_service['is_paid'] = $rowservice['is_paid'];
    						$sub_service['monthly_price'] = $rowservice['monthly_price'];
    						$sub_service['annual_price'] = $rowservice['annual_price'];
    						$sub_service['currency_code'] = $rowservice['currency_code'];
    						$sub_service['cta_text'] = $rowservice['cta_text'];
    						$sub_service['service_config_url'] = $service_config_url;
    						
    						//add sub service config url
    						//$sub_service['sub_service_config_url'] =
    						$res['user_sub_services'][] = $sub_service;
    					}
    					$res_arr['status']['error']    = false;
    					$res_arr['payload'] = $res;
    					return $res_arr;
    
    				}//
    				 
    			}else{
    				$res_arr['status']['error']    = true;
    				$res_arr['status']['message']  = 'invalid url';
    				return $res_arr; 
    			}
    		}else{
    			$res_arr['status']['error']    = true;
    			$res_arr['status']['message']  = 'invalid service  uuid';
    			return $res_arr;
    		}

    	 
    }
    
    
    
    
    
    
     public function user_add_sub_service($service_id)
     {
     	// service exist in database
     	$sql    = "SELECT id from user_services where service_id ='" . $service_id . "'";
     	$result = $this->conn->query($sql);
     	if ($result->num_rows > 0) {
     		
     		$userserviceid = $result->fetch_assoc();
     		$user_service_id = $userserviceid['id'];
     	    // get all sub services of that service
     		
     	 $sql_subservices = "select * from sub_services WHERE service_id ='" . $service_id . "'";
     	$result_sub = $this->conn->query($sql_subservices);
     	if ($result_sub->num_rows > 0) {	
     		
     		while ($datasubservice = $result_sub->fetch_assoc()) {
     		
     			$subserviceid  = $datasubservice['id'];
     			
     			// check sub service exist in database or not.
     			$sqlsubserviceexist  = "select * from user_sub_services where user_service_id ='" . $subserviceid . "'";
     			$result_subservice = $this->conn->query($sqlsubserviceexist);
     			if ($result_subservice->num_rows > 0) 
     			{
     				
     				
     			}else
     			{
     				
     				// insert free sub services into user sub services
     				$sql_insert   = "insert into user_sub_services (user_service_id,sub_service_id) values('" . $user_service_id . "','" . $subserviceid . "')";
     				
     				if ($this->conn->query($sql_insert) === TRUE) {
     				
     					$result_arr['status']['error']   = false;
     					$result_arr['status']['message'] = 'Sucessfully added sub services';
     				
     				
     				}
     				
     				
     			}
     			
     			
     			
     			
     			
     		}
     		return $result_arr;
     		
     		
     	}	
     	}else{
     		
     		$res_arr['status']['error']   = true;
     		$res_arr['status']['message'] = 'Service  not exist';
     		return $res_arr;
     		
     	}

     }
     
   
     
     
     
     
     
     
     
     
     
     
}

?>
