<?php

if (!function_exists('translate')){
	function translate($item)
	{
		$temp = lang($item);
		$retourn = $temp ? $temp : $item;
		return $retourn;
	}
}


if (!function_exists('is_logger')){
	function is_logger()
	{
		$CI = & get_instance();
		$CI->load->library('oc_auth');
		$CI->load->model('User_model');
		$user_id = $CI->oc_auth->get_user_id();
		$user_model = new User_model();
        $user = $user_model->get_user_by_uid($user_id);
		
		return  $user ;
	}
}

if(!function_exists("calcul_nombre_message"))
{
	function calcul_nombre_message($message)
	{
		$log = strlen($message);
		$nombre_sms = 1 ; 
		 if($log<=160)
		  {
			$nombre_sms = 1;
			
		  }
		  else if($log>160 && $log<=306)
		  {
			$nombre_sms = 2;
			
		  }
		   else if($log>306 && $log<=459)
		  {
			$nombre_sms = 3;
			
		  }
		   else if($log>459 && $log<=612)
		  {
			$nombre_sms = 4;
			//total = 612;
		  }
		   else if($log>612 && $log<=765)
		  {
			$nombre_sms = 5;
			//total = 765;
		  }
		  else
		  {
			
			$nombre_sms = 6;
		  }
	
		return $nombre_sms;
	
	}


}
