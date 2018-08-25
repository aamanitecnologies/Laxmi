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
require_once 'Users.php';
require_once 'Services.php';
require_once 'UserSubServices.php';
require_once 'UserSubServicesInstances.php';
require_once 'ServicePlatforms.php';
class SocialEngage
{
    
    
    public function __construct()
    {
    	
    }
    
    public function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid   = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
            return $uuid;
        }
    }
    
    /**
     * This method create user in database
     */
    public function signup($email, $service_uuid, $one_time_password)
    {
        
        
        $users = new Users();
        return $result = $users->signup($email, $service_uuid, $one_time_password);
        
        
        
    }
    
    
    /**
     * This method verify email id of user.
     */
    public function verification($email, $otp, $service_uuid)
    {
        
        $users = new Users();
        return $result = $users->verification($email, $otp, $service_uuid);
        
        
    }
    
    
    /**
     * This method return service
     */
    public function service($service_uuid)
    {
        $users = new Services();
        //return $result = $users->getservice($service_id);
        return $result = $users->service($service_uuid);
    }
    
    
    public function userservice($service_url)
    {
    	$users = new Services();
    	//return $result = $users->getservice($service_id);
    	return $result = $users->userservice($service_url);
    }
    
    /**
     * This method return service
     */
    public function getallservice()
    {
   
    	$users = new Services();
    	return $result = $users->getallservice();
    }
    
    
    
    
    /**
     * This method return user sub service
     */
    public function usersubservices($email,$channel , $service_uuid)
    {
    
    
    	$obj = new UserSubServices();
    	return $result = $obj->getusersubservice($email,$channel , $service_uuid);
    }
    
    
    /**
     * This method return user sub service
     */
    public function usersubservicesbyid($userid, $service_uuid)
    {
    	$obj = new UserSubServices();
    	return $result = $obj->usersubservicesbyid($userid, $service_uuid);
    }
    
    
    /**
     * This method return user sub service
     */
    public function getsubservices($service_id)
    {
    	$obj = new UserSubServices();
    	return $result = $obj->getusersubservice($service_id);
    }
    
    
    
    
    /**
     * This method return user sub service
     */
    public function usersignup($email,$password ,$otp)
    {
    	$users = new Users();
    	return $result = $users->usersignup($email, $password ,$otp);
    
    }
    
    
    /**
     * This method return sucess on login
     */
    public function userlogin($email,$password)
    {
    	$users = new Users();
    	return $result = $users->userlogin($email, $password);
    
    }
    
    
    
    /**
     * This method return sucess on verfication
     */
    public function usersignupotpverification($otp , $email)
    {
    	$users = new Users();
    	return $result = $users->usersignupotpverification($otp , $email);
    }
    
    
    /**
     * This method return sucess on resend otp
     */
    public function usersignupresendotp($otp, $email)
    {
    	$users = new Users();
    	return $result = $users->usersignupresendotp($otp, $email);
    
    }
    
    public function user_add_sub_service($service_id)
    {
    	$subservices = new UserSubServices();
    	return $result = $subservices->user_add_sub_service($service_id);
    	
    }
    
    
   
     public function  user_services($user_id)
     {
     	$users = new Users();
     	return $result = $users->user_services($user_id);
     	
     }
     
     
     public function getusersubserviceinstances($userid)
     {
     	$instance = new UserSubServicesInstances();
     	return $result = $instance->getusersubserviceinstances($userid);
     }
     
     public function getserviceplatforms($service_url)
     {
     	$platform = new ServicePlatform();
     	return $result = $platform->getserviceplatforms($service_url);
     	
     }
     
     public function add_sub_service_instance($userid , $usersubserviceid)
     {
     	$platform = new UserSubServicesInstances();
     	return $result = $platform->add_sub_service_instance($userid,$usersubserviceid);
     
     }
     
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>
