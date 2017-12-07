<?php

class Sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_active_sms_notification_setting() {
        $this->db->select("*")
                ->from('marketing_sms_settings');
        $db = $this->db->get();
        return $db->result();
    }
    
    public function get_sms_notification_setting_by_user($user) {
        $this->db->select("*")
                ->from('marketing_sms_settings')
                ->where("user = '" . $user . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_sms_log_by_rdv($rdv_id) {
        $this->db->select("*")
                ->from('marketing_sms_logs')
                ->where('rdv_id', $rdv_id);
        $db = $this->db->get();
        return $db->row(0);
    }

    public function get_sms_pattern($user, $pattern_type_id) {
        $this->db->select("*")
                ->from('marketing_sms_pattern')
                ->where("user = '" . $user . "' AND pattern_type = '" . $pattern_type_id . "'");
        $db = $this->db->get();
        return $db->row(0);
    }

    public function save_log($message_log) {
		
		
		
		
        $this->db->insert('marketing_sms_logs', $message_log);
    }

    public function save_sms_notification_setting($sms_notification_setting) {
        $this->db->insert('marketing_sms_settings', $sms_notification_setting);
    }

    public function update_sms_notification_setting($sms_notification_setting) {
        $this->db->where('user', $sms_notification_setting['user']);
        $this->db->update('marketing_sms_settings', $sms_notification_setting);
    }

    public function save_sms_pattern($marketing_sms_pattern) {
        $this->db->insert('marketing_sms_pattern', $marketing_sms_pattern);
    }

    public function update_sms_pattern($marketing_sms_pattern) {
        $this->db->where('user = "' . $marketing_sms_pattern['user'] . '" AND pattern_type = "' . $marketing_sms_pattern['pattern_type'] . '"');
        $this->db->update('marketing_sms_pattern', $marketing_sms_pattern);
    }

}
