<?php

/**
 * 
 * @param type $birthdate YYYY-MM-DD
 */
function is_date_close($birthdate, $difference = 7) {
    $d1 = explode('-', $birthdate);
    $is_closed = false;
    if ((int) $d1[1] >= (int) date('m')) {
        $d2 = date('Y') . '-' . $d1[1] . '-' . $d1[2];
        $date = new DateTime($d2);
        $now = new DateTime();
        $interval = $now->diff($date);
        if ($interval->days <= $difference) {
            $is_closed = true;
        }
    }
    return $is_closed;
}

/**
 * 
 * @param type $birthdate YYYY-MM-DD
 */
function date_close($birthdate, $difference = 7) {
    $param = " +".$difference." days";
    $d = date('Y-m-d', strtotime($birthdate . $param));
    $d1 = explode('-', $d);
    return '-' . $d1[1] . '-' . $d1[2];
}
