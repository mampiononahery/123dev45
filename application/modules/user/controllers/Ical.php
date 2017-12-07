<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Back.php');

class Ical extends Back  {

	function __construct() {
		
        parent::__construct();
    }
    public function index() 
	{
	
		$token = $this->input->get("token");
		$user = $this->input->get("user");
		$ical = new Ical_model();
		$is_data_acces = $ical->get_access($token,$user);
		$output = "";
		$data_rdv = $ical->get_all_rendez_by_client($user);
		
		if(sizeof($is_data_acces))
		{
			
			// GET RE
			
			$output = "BEGIN:VCALENDAR
			METHOD:PUBLISH
			VERSION:2.0
			PRODID:-//POWERCRM//CLINI Time//EN\n";
			
			// GET RENDEZ-VOUS BY CLIENT //
			
			
			define('DATE_ICAL', 'Ymd\THis\Z');
			$data_rdv = $ical->get_all_rendez_by_client($user);
			
			foreach ($data_rdv as $rdv):
			 $output .=
			"BEGIN:VEVENT
			SUMMARY:$rdv->note_prd  
			UID:$rdv->rdv_id
			STATUS:" . strtoupper($rdv->rdv_etat ) . "
			DTSTART:" . date(DATE_ICAL, strtotime($rdv->dt_start)) . "
			DTEND:" . date(DATE_ICAL, strtotime($rdv->dt_end)) . "
			LAST-MODIFIED:" . date(DATE_ICAL, strtotime($rdv->dt_start)) . "
			LOCATION:$rdv->nom_client 
			END:VEVENT\n";
			endforeach;
			$output .= "END:VCALENDAR";
 
			
			
		}
		echo $output;
       
    }
	
	

}
