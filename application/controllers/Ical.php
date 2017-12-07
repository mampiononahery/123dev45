<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Front.php');

class Ical extends Front  {

	function __construct() {
		
        parent::__construct();
    }
    public function index() 
	{
                $this->load->library('oc_auth');
                $this->load->library('ical');
                $this->load->model('Ical_model');
                $output = "BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//POWERCRM//CLINI Time//EN\n";
		$token = $this->input->get("token");
		$user = $this->input->get("user");
		$ical = new Ical_model();
		$is_data_acces = $ical->get_access($token,$user);
                $data_rdv = $ical->get_all_rendez_by_client($user);
		
		if(sizeof($is_data_acces))
		{
			
			// GET RE
			
			
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
              	$this->output->set_content_type('text/calendar','utf-8');
                $this->output->set_header("Content-Disposition: inline; filename=calendar.ics");
                $this->output->set_output($output);


//		redirect("assets/calendar.ics");
     
     
     
     
       
    }	
}
