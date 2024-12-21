<?php
if (!function_exists('greeting')) {
    function greeting()
    {
        date_default_timezone_set('Australia/Sydney');
        $hour = date('h'); // Get the current hour in 12-hour format
        $period = date('A'); // Get AM or PM

        if ($period === 'AM') {
            if ($hour >= 5) { // Morning from 5 AM to 11:59 AM
                return "Good Morning";
            }
            return "Good Night"; // Night from 12 AM to 4:59 AM
        } else { // PM
            if ($hour <= 5) {
                return "Good Afternoon"; // Afternoon from 12 PM to 4:59 PM
            } elseif ($hour <= 7) {
                return "Good Evening"; // Evening from 5 PM to 8:59 PM
            }
            return "Good Night"; // Night from 9 PM to 11:59 PM
        }
    }
}
?>
