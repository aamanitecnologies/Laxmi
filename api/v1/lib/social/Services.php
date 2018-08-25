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
 * @desc   Rt_social_engage  Services  Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';
require_once 'config.php';

class Services
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
    public function getservice($service_uuid)
    {
       
        $sql = "SELECT *  from services where service_uuid ='" . $service_uuid . "'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row          = $result->fetch_assoc();
            $service_id   = $row['id'];
            $service_name = $row['name'];
            $is_paid = $row['is_paid'];
            $monthly_price = $row['monthly_price'];
            $anual_price = $row['annual_price'];
            $currency_code = $row['currency_code'];
            
            $sql_search = "SELECT service_option , service_option_value  from service_options  where service_id ='" . $service_id . "'";
            
            $result_search = $this->conn->query($sql_search);
            if ($result_search->num_rows > 0) {
                
                while ($data = $result_search->fetch_assoc()) {
                    $option                         = array();
                    $option['service_option']       = $data['service_option'];
                    $option['service_option_value'] = $data['service_option_value'];
                    $res['options'][]               = $option;
                }
                
				//sub services
                $sql_search = "SELECT *  from sub_services where service_id ='" . $service_id . "'";
                $result_search = $this->conn->query($sql_search);
                if ($result_search->num_rows > 0) {
                
                	while ($data = $result_search->fetch_assoc()) {
                		$sub_service = array();
                		$sub_service['code'] = $data['code'];
                		$sub_service['name'] = $data['name'];
                		$res['sub_services'][] = $sub_service;
                	}
                
	                $res['service_id']   = $service_uuid;
	                $res['service_name'] = $service_name;
	                $res['is_paid'] = $is_paid;
	                $res['monthly_price'] = monthly_price;
	                $res['annual_price'] = annual_price;
	                $res['currency_code'] = currency_code;
	                
	                
	                $res_arr['status']['error']    = false;
	                $res_arr['status']['message']  = 'list of services';
	                $res_arr['payload']['service'] = $res;
	                return $res_arr;
            	}
            }
        } else {
            
            $res_arr['status']['error']   = true;
            $res_arr['status']['message'] = 'service id and verson not found';
            return $res_arr;
        }        
    }
    
    
    public function service($service_uuid)
    {
    	$sql = "SELECT *  from services where service_uuid ='".$service_uuid."'";
    	$result = $this->conn->query($sql);
    	if ($result->num_rows > 0) {
    		 
    		while ($row = $result->fetch_assoc()) {
    			$data  = array();
    			$data['service_id']       = $row['id'];
    			$data['service_name']  =   $row['name'];
    			$data['service_icon']  =   $row['icon'];
    			$data['service_cover']  =   $row['cover'];
    			$data['service_short_desc']  =   $row['short_desc'];
    			$data['service_long_desc']  =   $row['long_desc'];
    			$data['service_is_paid']  =   $row['is_paid'];
    			$data['service_monthly_price']  =   $row['monthly_price'];
    			$data['service_annual_price']  =   $row['annual_price'];
    			$data['service_currency_code']  =   $row['currency_code'];
    			$data['service_wp_store_url']  =   $row['wp_store_url'];
    			$service_url = $data['service_url']  =  APP_BASE_URL . 'service/' . $row['service_url'];
    			$data['service_config_url']  =   $row['service_config_url'];
    			$data['service_comming_soon']  =   $row['comming_soon'];
    			 
    			$res['service'] = $data;
    
    			 
    			$sql_search = "SELECT service_option , service_option_value  from service_options  where service_id ='" . $data['service_id'] . "'";
    
    			$result_search = $this->conn->query($sql_search);
    			if ($result_search->num_rows > 0) {
    					
    				while ($dataoption = $result_search->fetch_assoc()) {
    					$option                         = array();
    					$option['service_option']       = $dataoption['service_option'];
    					$option['service_option_value'] = $dataoption['service_option_value'];
    					$res['service']['options'][]             = $option;
    				}
    					
    				//sub services
    				 $sql_search = "SELECT *  from sub_services where service_id ='" . $data['service_id'] . "'";
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
							//add display price
							if($sub_service['is_paid'] == 1) {
								$sub_service['price'] = $sub_service['monthly_price'];
								$sub_service['currency'] = '$';
								$sub_service['duration'] = '/ Month';
							} else {
								$sub_service['price'] = $sub_service['monthly_price'];
								$sub_service['currency'] = '$';
								$sub_service['duration'] = '/ Month';
							} 

							$sub_service['sub_service_url'] = $service_url;
							
							
    						$res['service']['sub_services'][] = $sub_service;
    							
    					}
    				}
    			}
    
    
    			$i++;
    		}
    		 
    		$res_arr['status']['error']    = false;
    		$res_arr['payload'] = $res;
    		return $res_arr;
    		 
    		 
    	}else{
    		 
    		$res_arr['status']['error']    = true;
    		$res_arr['status']['message']  = 'invalid url';
    		return $res_arr;
    		 
    		 
    		 
    	}
    	 
    }
    
    
    
    /**
     * This method return service with sub services
     */
    public function userservice($service_url)
    {
		    $sql = "SELECT *  from services where service_url ='".$service_url."'";
		    $result = $this->conn->query($sql);
		    if ($result->num_rows > 0) {
		    
		    	$i = 0;
		    	while ($row = $result->fetch_assoc()) {
		    		$data  = array();
		    		$data['service_id']       = $row['id'];
		    		$data['service_name']  =   $row['name'];
		    		$data['service_icon']  =   $row['icon'];
		    		$data['service_cover']  =   $row['cover'];
		    		$data['service_short_desc']  =   $row['short_desc'];
		    		$data['service_long_desc']  =   $row['long_desc'];
		    		$data['service_is_paid']  =   $row['is_paid'];
		    		$data['service_monthly_price']  =   $row['monthly_price'];
		    		$data['service_annual_price']  =   $row['annual_price'];
		    		$data['service_currency_code']  =   $row['currency_code'];
		    		$data['service_wp_store_url']  =   $row['wp_store_url'];
		    		$data['service_url']  =   $row['service_url'];
		    		$data['service_config_url']  =   $row['service_config_url'];
		    		$data['service_comming_soon']  =   $row['comming_soon'];
		    		
		    		$res['service'][$i] = $data;
		    	

		    		$sql_search = "SELECT service_option , service_option_value  from service_options  where service_id ='" . $data['service_id'] . "'";
		    	
		    		$result_search = $this->conn->query($sql_search);
		    		if ($result_search->num_rows > 0) {
		    	
		    			while ($dataoption = $result_search->fetch_assoc()) {
		    				$option                         = array();
		    				$option['service_option']       = $dataoption['service_option'];
		    				$option['service_option_value'] = $dataoption['service_option_value'];
		    				$res['service'][$i]['option']             = $option;
		    			}
		    	
		    			//sub services
		    			$sql_search = "SELECT *  from sub_services where service_id ='" . $data['service_id'] . "'";
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
		    					$res['service'][$i]['sub_services'][] = $sub_service;
			    				
		    			    }
		    		}
		    	}
		    	
		    	
		    	$i++;
		    	}
		    	
		    	$res_arr['status']['error']    = false;
		    	$res_arr['payload'] = $res;
		    	return $res_arr;
		    
		    	 
		    }else{
		    	
		    	$res_arr['status']['error']    = true;
		    	$res_arr['status']['message']  = 'invalid url';
		    	return $res_arr;
		    	
		    	
		    	
		    }
    
    
    }

    
    
    
    
    /**
     * This method return all service
     */
    public function getallservice()
    {
    	$sql = "SELECT *  from services";
    	
    	$result = $this->conn->query($sql);
    	if ($result->num_rows > 0) {
    		
    		while ($row = $result->fetch_assoc()) {
    			$data    = array();
    			$data['service_id']       = $row['id'];
    			$data['service_name']  =   $row['name'];
    			$data['service_icon']  =   $row['icon'];
    			$data['service_cover']  =   $row['cover'];
    			$data['service_short_desc']  =   $row['short_desc'];
    			$data['service_long_desc']  =   $row['long_desc'];
    			$data['service_is_paid']  =   $row['is_paid'];
    			$data['service_monthly_price']  =   $row['monthly_price'];
    			$data['service_annual_price']  =   $row['annual_price'];
    			$data['service_currency_code']  =   $row['currency_code'];
    			$data['service_wp_store_url']  =   $row['wp_store_url'];
    			$data['service_url']  =   $row['service_url'];
    			$data['service_config_url']  =   $row['service_config_url'];
    			$data['service_comming_soon']  =   $row['comming_soon'];
    			$res[]  = $data;
    		}
    		
    		
    		$res_arr['status']['error']    = false;
    		$res_arr['payload']['services'] = $res;
    		return $res_arr;
    		
    	
    	}else{
    		
    		$res_arr['status']['error']   = true;
    		$res_arr['status']['message'] = 'No services found in database';
    		return $res_arr;
    		
    		
    	}
    	
    	
    }
    
    
    
    
    
}

?>
