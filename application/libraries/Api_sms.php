<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . '/libraries/php-client/SwaggerClient-php/autoload.php');

class Api_sms {

    protected $_api_key;
    protected $_destination_number;
    protected $_sms;
    protected $_date_envoi;

    function __construct() {
        $ci = &get_instance();
        $this->set_api_key($ci->config->item('sms_key'));
    }

    function set_api_key($api_key) {
        $this->_api_key = $api_key;
    }

    function set_destination_number($destination_number) {
        $this->_destination_number = $destination_number;
    }

    function set_sms($sms) {
        $this->_sms = $sms;
    }

    function set_date_envoi($date_envoi) {
        $this->_date_envoi = $date_envoi;
    }

    function get_api_key() {
        return $this->_api_key;
    }

    function get_destination_number() {
        return $this->_destination_number;
    }

    function get_sms() {
        return $this->_sms;
    }

    function get_date_envoi() {
        return $this->_date_envoi;
    }

    function send_sms() {
        $api_instance = new Swagger\Client\Api\SmsApi();
        $smsrequest = new \Swagger\Client\Model\SmsUniqueRequest();
        $smsrequest["keyid"] = $this->get_api_key();
        $smsrequest["num"] = $this->get_destination_number();
        $smsrequest["sms"] = $this->get_sms();
		
		
        try {
            $api_instance->sendSms($smsrequest);
            return 1;
        } catch (Exception $e) {
			
			//echo 'Exception when calling SmsApi->sendSms: ', $e->getMessage(), PHP_EOL;
			$reponse_erreur=$e->getResponseBody();
			
			
			
			
			
            return 0;
        }
    }

    function send_multiple_sms() {
        $api_instance = new Swagger\Client\Api\SmsApi();
        $smsrequest = new \Swagger\Client\Model\SMSRequest();
        $smsrequest["keyid"] = $this->get_api_key();
        $smsrequest["num"] = $this->get_destination_number();
        $smsrequest["sms"] = $this->get_sms();
        $smsrequest["date_envoi"] = $this->get_date_envoi();
        try {
            $api_instance->sendSmsMulti($smsrequest);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

}
