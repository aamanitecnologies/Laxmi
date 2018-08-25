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
 * @desc   Rt_social_engage  UserSubServicesInstances  Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';

class UserSubServicesInstances
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new SocialEngage_db();
        return $this->conn = $connection->getDB();
    }

    /**
     * This method return service instances
     */
    public function getusersubserviceinstances($userid)
    {
    	$instance = 0;
    	/*
    	 * get user services id from table user_services
    	 */ 
    	$sql_userservices = "SELECT id from user_services where user_id ='".$userid."'";
    	$result_userservices = $this->conn->query($sql_userservices);
    	if ($result_userservices->num_rows > 0)
    	{
    		$data     = $result_userservices->fetch_assoc();
    		 $userservice_id = $data['id'];
			/*
			 * get all id of user sub services from table user_sub_services
			 * 
			 */ 
    		 $sql_usersubservices = "SELECT id from user_sub_services where user_service_id ='".$userservice_id."'";
    		$result_usersubservices = $this->conn->query($sql_usersubservices);
    		if ($result_usersubservices->num_rows > 0)
    		{
    			while ($rowservice = $result_usersubservices->fetch_assoc())
    			{
    				 $usersubserviceid   = $rowservice['id'];
    				/*
    				 * check user_sub_service_id exitst in table user_sub_services_instances
    				 */
    				$sql_usersubservicesinstances = "SELECT * from user_sub_services_instances where user_sub_service_id ='".$usersubserviceid."'";
    				$result_usersubservicesinstances = $this->conn->query($sql_usersubservicesinstances);
    				if ($result_usersubservicesinstances->num_rows > 0)
    				{
    					while ($rowinstance = $result_usersubservicesinstances->fetch_assoc())
    					{
    						$usersubserviceinstanceid   = $rowinstance['id'];
    						$user_sub_service_id  = $rowinstance['user_sub_service_id'];
    						
    						/*
    						 * getting the data 
    						 */
    						
    					     $sql_cmd = "SELECT a.service_id,a.code,a.name,a.icon,a.cover,a.short_desc,a.long_desc,a.is_paid,a.monthly_price,a.annual_price,a.currency_code,a.cta_text from sub_services a LEFT JOIN user_sub_services b  ON b.sub_service_id  = a.id WHERE b.id = '".$user_sub_service_id."'";
    						$result_cmd = $this->conn->query($sql_cmd);
    						if ($result_cmd->num_rows > 0)
    						{
    							$instance = 1;
    							
    							$rowcmd         = $result_cmd->fetch_assoc();
    							$sub_service['code']   = $rowcmd['code'];
    							$sub_service['name'] = $rowcmd['name'];
    							$sub_service['icon'] = $rowcmd['icon'];
    							$sub_service['cover'] = $rowcmd['cover'];
    							$sub_service['short_desc'] = $rowcmd['short_desc'];
    							$sub_service['long_desc'] = $rowcmd['long_desc'];
    							$sub_service['is_paid'] = $rowcmd['is_paid'];
    							$sub_service['monthly_price'] = $rowcmd['monthly_price'];
    							$sub_service['annual_price'] = $rowcmd['annual_price'];
    							$sub_service['currency_code'] = $rowcmd['currency_code'];
    							$sub_service['cta_text'] = $rowcmd['cta_text'];
    						}
    						$sub_service['user_sub_serviceid'] = $usersubserviceinstanceid;
    						$res_arr['status']['error']    = false;
    						$res_arr['payload']['instances'][]  = $sub_service;
    					}
    					
    				}
    				
    			}

    			if ($instance == 1)
    			{
    			return $res_arr;
    			}else
    			{
    				
    				$res_arr['status']['error']    = true;
    				$res_arr['status']['message']  = 'No instances found';
    				return $res_arr;
    			}
    		}else{
    			
    			$res_arr['status']['error']    = true;
    			$res_arr['status']['message']  = 'No user sub services found';
    			return $res_arr;
    		}	
    	}else
    	{
    		$res_arr['status']['error']    = true;
    		$res_arr['status']['message']  = 'No user services found';
    		return $res_arr;
    		
    	}
    	
    	
           
    }
    
    
    
    public function add_sub_service_instance($userid,$usersubserviceid)
    {
    	
	  /*
	   *Check if instance is already create or not
	   */
	   /* $sql_userservice_instance = "SELECT * from user_sub_services_instances where user_sub_service_id ='".$usersubserviceid."' && user_id='".$userid."'";
    	$result_userserviceinst = $this->conn->query($sql_userservice_instance);
    	if ($result_userserviceinst->num_rows > 0)
		{
		   $result_arr['status']['error']   = true;
    	   $result_arr['status']['message'] = 'Instance Already created';
    	   return $result_arr;
		
		
		}else{ */
		
      /*
       * insert data into user_sub_services_instances 
       */
    	$insert_sql = "INSERT INTO user_sub_services_instances (user_sub_service_id,user_id) values('" . $usersubserviceid . "','" . $userid . "')";
    	if ($this->conn->query($insert_sql) === TRUE) {
    		 
    		$instance_id    = mysqli_insert_id($this->conn);
    		$option_name = 'access_token';
    		$option_value = 'EAAHZC8qBYuPsBANPzumB1t4qI6PZABi7jiHFVIZB4eWZCNdrStsa6cCMlGK6sitNGQ1ryRxPRBbqmIkmLwrsyw1lZA99RscONsZCZA71fOvGMLvZAZARBV2YZAstiqJoQfJme3HasGDCJhTALn0F782rYf7umjn6jYSEEZD';
    		$insert_instance_options_sql = "INSERT INTO user_sub_services_instance_options (instance_id,option_name,option_value) values('" . $instance_id . "','" . $option_name . "','" . $option_value . "')";
    		if ($this->conn->query($insert_instance_options_sql) === TRUE) {
    			
    			$result_arr['status']['error']   = false;
    			$result_arr['status']['message'] = 'Sucessfull created instance';
    			return $result_arr;
    		
    		}
    		
    		
    	}
    	else{
    		
    		$result_arr['status']['error']   = true;
    		$result_arr['status']['message'] = 'Some problem while creating instance';
    		return $result_arr;
    		
    	}
			
	 //}		
			
			
    	
    }
    
    
 
     
     
}

?>

