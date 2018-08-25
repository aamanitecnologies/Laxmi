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
 * @desc   Rt_social_engage  Users Wrapper and Utility Functions
 *         
 *
 * @author Nikhil Nainta
 */
require_once 'SocialEngage_db.php';

class Users
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new SocialEngage_db();
        return $this->conn = $connection->getDB();
    }
    
    
    public 	function getGUID()
    {
    
    
    	if (function_exists('com_create_guid'))
    		{
    		return com_create_guid();
    		}
    		else
    		{
    		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    		$charid = strtoupper(md5(uniqid(rand(), true)));
    		$hyphen = chr(45);// "-"
    		//$uuid = chr(123)// "{"
    		$uuid = substr($charid, 0, 8).$hyphen
    		.substr($charid, 8, 4).$hyphen
    		.substr($charid,12, 4).$hyphen
    		.substr($charid,16, 4).$hyphen
    		.substr($charid,20,12);
    		//.chr(125);// "}"
    		return  $uuid;
    		} 
    }

    public function signup($email, $service_uuid, $one_time_password)
    {
        // check service id and version already exist in database
        
        $sql    = "SELECT * from services where service_uuid ='" . $service_uuid . "'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $service    = $result->fetch_assoc();
            $service_id = $service['id'];
            
            // check email exist in database
            
            $sql_email    = "SELECT * from users where useremail ='" . $email . "'";
            $result_email = $this->conn->query($sql_email);
            if ($result_email->num_rows > 0) {
                $row     = $result_email->fetch_assoc();
                $user_id = $row['id'];
                
                // check user is registered with the same service in user_services
                
                $search_sql        = "SELECT * FROM user_services where user_id = '" . $user_id . "' && service_id = '" . $service_id . "'";
                $result_search_sql = $this->conn->query($search_sql);
                if ($result_search_sql->num_rows > 0) {
                    
                    // user and service found  return already registered
                    
                    $rowdata    = $result_email->fetch_assoc();
                    $channel_id = $rowdata['channel'];
                    
                    // update otp
                    
                    $update_user_services_sql = "UPDATE user_services SET otp ='" . $one_time_password . "' where user_id=".$user_id;
                    if ($this->conn->query($update_user_services_sql) === TRUE) {
                        $res_arr['status']['error']   = false;
                        $res_arr['status']['message'] = 'User is already registered with the same service';
                    } else {
                        $res_arr['status']['error']   = true;
                        $res_arr['status']['message'] = 'Unable to update OTP';
                    }
                } else {
                    
                    //  registered user with another service
                    
                    $uuid      = $this->getGUID();
                    $insert_user_services_sql = "INSERT INTO user_services (user_id,service_id,otp,channel) values('" . $user_id . "','" . $service_id . "','" . $one_time_password . "','" . $uuid . "')";
                    if ($this->conn->query($insert_user_services_sql) === TRUE) {
                        $res_arr['status']['error']   = false;
                        $res_arr['status']['message'] = 'Sucessfully Registered';
                    }
                }
            } else {
                $insert_sql = "INSERT INTO users (useremail) values('" . $email . "')";
                if ($this->conn->query($insert_sql) === TRUE) {
                    $user_id                  = mysqli_insert_id($this->conn);
                    $uuid                     = $this->getGUID();
                    $insert_user_services_sql = "INSERT INTO user_services (user_id,service_id,otp,channel) values('" . $user_id . "','" . $service_id . "','" . $one_time_password . "','" . $uuid . "')";
                    if ($this->conn->query($insert_user_services_sql) === TRUE) {
                        $res_arr['status']['error']   = false;
                        $res_arr['status']['message'] = 'Sucessfully Registered';
                        
                        
                    }
                } else {
                    $res_arr['status']['error']   = true;
                    $res_arr['status']['message'] = 'Error: ' . $this->conn->error;
                }
            }
            
            return $res_arr;
        } else {
            $res_arr['status']['error']   = true;
            $res_arr['status']['message'] = 'Service id , version  not found';
            return $res_arr;
        }
        
        $conn->close();
        
        
    }
    
    public function userlogin($email, $password)
    {
    	
    	//0 - nothing , 1 - not verified , 2- verified
    	// check email exist or not exist in database
    	$sql_email    = "SELECT * from users where useremail ='" . $email . "'";
    	$result_email = $this->conn->query($sql_email);
    	if ($result_email->num_rows > 0) {
    		
    		// check password is correct or incorrect
    		$sql_email    = "SELECT * from users where useremail ='" . $email . "' AND password = '". $password ."'";
    		$result_email = $this->conn->query($sql_email);
    		if ($result_email->num_rows > 0) {
    			
    			// check email verified or not;
    			$sql_verified    = "SELECT * from users where useremail ='" . $email . "' AND verified = '1'";
    			$result_email = $this->conn->query($sql_verified);
    			if ($result_email->num_rows > 0) {
    				
    				$row     = $result_email->fetch_assoc();
    				$result_arr['status']['error']   = false;
    				$result_arr['status']['verified'] = '2';
    				$result_arr['status']['message'] = 'Sucessfully logged in';
    				$result_arr['status']['userid'] = $row['id'];
    				return  $result_arr;
    				
    			}else{
    				
    				$result_arr['status']['error']   = true;
    				$result_arr['status']['verified'] = '1';
    				$result_arr['status']['message'] = 'Account is  not verified';
    				return  $result_arr;
    				
    			}
    
    		}else{
    			
    			$result_arr['status']['error']   = true;
    			$result_arr['status']['verified'] = '0';
    			$result_arr['status']['message'] = 'Incorrect email and  password';
    			return  $result_arr;
    		}
    		
    	}else{
    		
    		$result_arr['status']['error']   = true;
    		$result_arr['status']['verified'] = '0';
    		$result_arr['status']['message'] = 'Invalid email';
    		
    		return  $result_arr;
    		
    		
    	}
    	
    	$conn->close();
    	
    }
    
    public function usersignup($email, $password ,$one_time_password)
    {
    	// check email exist or not exist in database
    	$sql_email    = "SELECT * from users where useremail ='" . $email . "'";
    	$result_email = $this->conn->query($sql_email);
    	if ($result_email->num_rows > 0) {
    		
    		 // if mail exist in database get user id 
    		$row     = $result_email->fetch_assoc();
    		$user_id = $row['id'];
    		$password_created = $row['password_created'];
    		$acc_verified = $row['verified'];
    		
    		// check password  created or not
    		if ($password_created == '1')
    		{	
   
    		    // check account is verified or not 
    			if ($acc_verified == '1')
    		    {	
    		
    		        // if acc verified  show message
    		    	 $result_arr['status']['error']   = true;
    		    	 $result_arr['status']['otp'] = '0';
                     $result_arr['status']['message'] = 'Account is already created';

    		    }else
    		    {
    			    // acc not verified send otp message
    		    	$update_sql = "UPDATE users  set  otp = '".$one_time_password."' where id= '".$user_id."' ";
    		    	if ($this->conn->query($update_sql) === TRUE) {
    		    		 
    		    		$result_arr['status']['error']   = false;
    		    		$result_arr['status']['otp'] = '1';
    		    		$result_arr['status']['message'] = 'Otp sent to '.$email;
    		    	
    		    	}
    		    	
    		    	return $result_arr;
    		    }
    		    
    		    return $result_arr;
    		
    		}else
    		{
    
    		// save password and generate otp
    		 $update_sql = "UPDATE users  set password = '" . $password . "' , otp = '".$one_time_password."' , password_created = true where id= '".$user_id."' ";
    		if ($this->conn->query($update_sql) === TRUE) {
    			
    			$result_arr['status']['error']   = false;
    			$result_arr['status']['otp'] = '1';
    			$result_arr['status']['message'] = 'Otp sent to '.$email;
				
    		}
    		
    		return $result_arr;
    		}	
    		
    	}else{
    		
    	    // email not exits in database
    	    
    		// insert into database and generate otp
    		
    		$insert_sql = "INSERT INTO users (useremail,password,password_created,otp) values('" . $email . "','" . $password . "',true ,'".$one_time_password."')";
    		if ($this->conn->query($insert_sql) === TRUE) {
    			
    			$result_arr['status']['error']   = false;
    			$result_arr['status']['otp'] = '1';
    			$result_arr['status']['message'] = 'Sucessfully registered';

    		
    		}
    		
    		return $result_arr;
    		
    	}
    	
    	$conn->close();
    
    
    }
    
    
    
    /**
     * This method verify email id of user.
     */
    public function verification($email, $otp,$service_uuid)
    {
    	
        // Check first email exist in database return user_id
        $sql    = "SELECT id  from users  where useremail ='" . $email . "'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row     = $result->fetch_assoc();
            $user_id = $row['id'];
            

            // check service_uuid exist in database
            
            $search_servicesuuid = "SELECT id  from services where service_uuid ='" . $service_uuid . "'";
            $result_servicesid   = $this->conn->query($search_servicesuuid);
            if ($result_servicesid->num_rows > 0) {
                $row        = $result_servicesid->fetch_assoc();
                $service_id = $row['id'];
                
                // check in user_services table user_id , service_id , otp found
                
                $search_sql        = "SELECT * FROM user_services where user_id = '" . $user_id . "' && service_id = '" . $service_id . "' && otp = '" . $otp . "'";
                $result_search_sql = $this->conn->query($search_sql);
                if ($result_search_sql->num_rows > 0) {
                    
                    // update verify to true in user_services table and email_verified to true in users table.
                    
                    $update_user_services = "UPDATE user_services  SET verified = true where otp = '" . $otp . "' && service_id = '" . $service_id . "' && user_id = '" . $user_id . "'";
                    if ($this->conn->query($update_user_services) === TRUE) {
                      
                            // GET CHANNEL ID
                           $search_sql        = "SELECT channel FROM user_services where service_id = '" . $service_id . "' && user_id = '" . $user_id . "'";
                            $result_search_sql = $this->conn->query($search_sql);
                            if ($result_search_sql->num_rows > 0) {
                                $row                           = $result_search_sql->fetch_assoc();
                                $channel_id                    = $row['channel'];
                                
                                // get service id from service uuid
                                $sqlgetservice    = "SELECT id  from services  where service_uuid ='" . $service_uuid . "'";
                                $resultservice = $this->conn->query($sqlgetservice);
                                if ($resultservice->num_rows > 0) {
                                	$rowservice    = $resultservice->fetch_assoc();
                                	$service_id = $rowservice['id'];
                                	 
                                	 
                                	
                                	/*adding user sub services  **/
                                	// service exist in database
                                    $sql    = "SELECT id from user_services where service_id ='" . $service_id . "' AND user_id='" . $user_id . "' && verified ='1'";
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
                                				$is_paid =  $datasubservice['is_paid'];
                                				 
                                				// if service is free only then check and insert into database
                                				if ($is_paid == '0')
                                				{
                                					// check sub service exist in database or not.
                                					 $sqlsubserviceexist  = "select * from user_sub_services where user_service_id ='" . $user_service_id . "' && sub_service_id='" . $subserviceid . "'";
                                					$result_subservice = $this->conn->query($sqlsubserviceexist);
                                					if ($result_subservice->num_rows > 0)
                                					{
                                						$result_arr['status']['error']   = false;
                                						$result_arr['status']['message'] = 'Verification Sucessfull';
                                						$result_arr['payload']['channel'] =  $channel_id;
                                						
                                						 
                                					}else
                                					{
                                						// insert free sub services into user sub services
                                						$sql_insert   = "insert into user_sub_services (user_service_id,sub_service_id) values('" . $user_service_id . "','" . $subserviceid . "')";
                                						 
                                						if ($this->conn->query($sql_insert) === TRUE) {
                                
                                							$result_arr['status']['error']   = false;
                                							// sucessfully added sub services
                                							$result_arr['status']['message'] = 'Verification Sucessfull';
                                							$result_arr['payload']['channel'] =  $channel_id;
                                						}
                                					}
                                					 
                                				}
                                
                                			}
                                			return $result_arr;
                                		}
                                	}else{
                                		
                                		// verification sucessfully not updated entry in user_sub_services
                                		$res_arr['status']['error']   = false;
                                		$res_arr['status']['message'] = 'Verification Sucessfull';
                                		$res_arr['payload']['channel'] =  $channel_id;
                                		return $res_arr;
                                		 
                                	}
                                	/*user sub services*/
                                	 
                                
                                }
                                else{
                                	
                                	$res_arr['status']['error']   = true;
                                	$res_arr['status']['message'] = 'Service not found.';
                                	return $res_arr;
                                
                                }
                                
                                
                             
                            }
                           
                    }
                } else {
                    $res_arr['status']['error']   = true;
                    $res_arr['status']['message'] = 'Incorrect OTP';
                    return $res_arr;
                }
            } else {
                $res_arr['status']['error']   = true;
                $res_arr['status']['message'] = 'Incorrect Service id';
                return $res_arr;
            }
        } else {
            $res_arr['status']['error']   = true;
            $res_arr['status']['message'] = 'Email does not exist';
            return $res_arr;
        }
        
        $conn->close();
    }
    
    
    

    /**
     * This method verify otp.
     */
    public function usersignupotpverification($otp , $email){
    	
    	// check otp and email is correct or not 
    	$sql    = "SELECT id  from users  where useremail ='" . $email . "' AND otp ='" .$otp. "'";
    	$result = $this->conn->query($sql);
    	if ($result->num_rows > 0) 
    	{
    		
    		$row     = $result->fetch_assoc();
    		$user_id = $row['id'];
    		
    		// acc not verified send otp message
    		$update_sql = "UPDATE users  set  verified = '1' where id= '".$user_id."' ";
    		if ($this->conn->query($update_sql) === TRUE) 
    		{
    			 
    			$result_arr['status']['error']   = false;
    			$result_arr['status']['otp'] = '1';
    			$result_arr['status']['message'] = 'Account Verified';
    				
    		}
    			
    		return $result_arr;
    		
    		
    	}
    	else
    	{
    		
    		$result_arr['status']['error']   = true;
    		$result_arr['status']['otp'] = '0';
    		$result_arr['status']['message'] = 'Otp does not match with your email id :- '.$email;
    		
    		return $result_arr;
    	}
    	
    	
    	$conn->close();
    	
    }
    
    
    /**
     * This method save otp in database.
     */
    public function usersignupresendotp($otp , $email){
    	 
    	$update_sql = "UPDATE users SET otp ='".$otp."' where useremail = '".$email."'";
    	if ($this->conn->query($update_sql) === TRUE) {
    		 
    		$result_arr['status']['error']   = false;
    		$result_arr['status']['otp'] = '1';
    		$result_arr['status']['message'] = 'otp sent to '.$email;
    		return $result_arr;
    	
    	}else{
    		
    		$result_arr['status']['error']   = true;
    		$result_arr['status']['otp'] = '0';
    		$result_arr['status']['message'] = 'Incorrect email and otp';
    		return $result_arr;
    		
    	}
    	
    	
    	 
    
    	$conn->close();
    	
    }
    
    
    
    public function user_services($user_id)
    {
    	// get the service of the user 
    	$user_services_sql = "select service_id from user_services where user_id ='" . $user_id . "'";
    	$result = $this->conn->query($user_services_sql);
    	if ($result->num_rows > 0)
    	{
    		// fetch data of service
    		
    		$row     = $result->fetch_assoc();
    		$service_id = $row['service_id'];
    		
    		// get service 
    		$services_sql = "select * from services where id='".$service_id."'";
    		$result_service = $this->conn->query($services_sql);
    		if ($result_service->num_rows > 0)
    		{
    			$servicesdata = array();
    			while ($dataservice = $result_service->fetch_assoc())
    			{
    				$services = array();
    				$services['name'] = $dataservice['name'];
    				$services['icon'] = $dataservice['icon'];
    				$services['cover'] = $dataservice['cover'];
    				$services['short_desc'] = $dataservice['short_desc'];
    				$services['long_desc'] = $dataservice['long_desc'];
    				$services['is_paid'] = $dataservice['is_paid'];
    				$services['service_url'] = $dataservice['service_url'];
    				$services['service_config_url'] = $dataservice['service_config_url'];
    				
    				$servicesdata = $services;
    			
    			}
    			
    			$res_arr['status']['error']   = false;
    			$res_arr['payload']['services'] = $servicesdata;
    			return $res_arr;
    			
    		}else
    		{
    			$res_arr['status']['error']   = true;
    			$res_arr['status']['message'] = 'Some error in service';
    			return $res_arr;
    			
    		}
    		
    	}else{
    		
    		$res_arr['status']['error']   = true;
    		$res_arr['status']['message'] = 'Service does not exist';
    		return $res_arr;
    		
    	}
    }
    
    
    
    
    
    
    
}

?>
