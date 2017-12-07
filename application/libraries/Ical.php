<?php



require_once(APPPATH . '/libraries/iCalcreator/autoload.php');

class Ical {

    
    function __construct() {
		
		
        $ci = &get_instance();
        
    }

	function save_file($output)
	{
		
		
		$config = [kigkonsult\iCalcreator\util\util::$UNIQUE_ID => "kigkonsult.se" ];
		// create a new calendar instance
		$calendar = new  kigkonsult\iCalcreator\vcalendar($config );
	
		  // required of some calendar software
		$calendar->setProperty( kigkonsult\iCalcreator\util\util::$METHOD,
								"PUBLISH" );
		$calendar->setProperty( "x-wr-calname",
								"Calendar Sample" );
		$calendar->setProperty( "X-WR-CALDESC",
								"Calendar Description" );
		$calendar->setProperty( "X-WR-TIMEZONE",
								"Europe/Stockholm" );					
		$config = [ kigkonsult\iCalcreator\util\util::$DIRECTORY => "./assets",
            kigkonsult\iCalcreator\util\util::$FILENAME  => "calendar.ics"
          ];
		$calendar->setConfig( $config );
		$vcalendar = new kigkonsult\iCalcreator\vcalendar( $config ); 
		
		 $vcalendar->parse( $output );
		//$calendar->saveCalendar();
	}
	public function output(){
	
		 $config = array( kigkonsult\iCalcreator\util\util::$UNIQUE_ID => "kigkonsult.se",
		 kigkonsult\iCalcreator\util\util::$URL => "http://www.ical.net/calendars/calendar.ics" ,
		 kigkonsult\iCalcreator\util\util::$DIRECTORY => "./assets",
		 kigkonsult\iCalcreator\util\util::$FILENAME  => "icalandar.ics"
		 
		 
		 ); 
		 $vcalendar = new kigkonsult\iCalcreator\vcalendar( $config ); 
		 $str = array( 
		 "BEGIN:VCALENDAR", "PRODID:-//kigkonsult.se//NONSGML kigkonsult.se iCalcreator 2.24//", "VERSION:2.0", 
		 "BEGIN:VEVENT", "DTSTART:20101224T190000Z", "DTEND:20101224T200000Z", 
		 "DTSTAMP:20101020T103827Z", "UID:20101020T113827-1234GkdhFR@test.org", 
		 "DESCRIPTION:example", 
		 "END:VEVENT", 
		 "END:VCALENDAR");
		 $vcalendar->parse( $str );
		 
		 
	
	
	}

}
