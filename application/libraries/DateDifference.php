<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DateDifference {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('date');
    }

    public function getTimeDifference($start_date, $end_date, $unit = 'S') {
        $start_timestamp = strtotime($start_date);
        $end_timestamp = strtotime($end_date);

        $difference = $end_timestamp - $start_timestamp;

        switch (strtoupper($unit)) {
            case 'H':
                return (object)array(
                    'unit'=>'Hour',
                    'time'=>floor($difference / (60 * 60)),
                ); // Convert seconds to hours
                break;
            case 'M':
                return (object)array(
                    'unit'=>'Minute',
                    'time'=>floor($difference / 60),
                ); // Convert seconds to minutes
                break;
            case 'S':
            default:
                return (object)array(
                    'unit'=>'Second',
                    'time'=>$difference,
                ); // Return difference in seconds
                break;
        }
    }
}
