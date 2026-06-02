<?php

// Link to and use interface
include('./openingHours_Interface.php');

use openingHoursInterface\openingHours;

// Logic for displaying correct times and statement
class shopOpeningHours implements openingHours {

    private $open;

    public static function getDateTime() {

        $timezone = new DateTimeZone('Europe/London');
        $dateTime = new DateTime();
        $dateTime->setTimezone($timezone);

        return $dateTime;
    }

    // Opening times array
    public static function getOpeningTimes() {
        $openingTimesArray = [
            "Mon"   => ["Open"=>"09:00", "Closed"=>"18:00"],
            "Tue"   => ["Open"=>"09:00", "Closed"=>"18:00"],
            "Wed"   => ["Open"=>"09:00", "Closed"=>"18:00"],
            "Thu"   => ["Open"=>"09:00", "Closed"=>"18:00"],
            "Fri"   => ["Open"=>"09:00", "Closed"=>"18:00"],
            "Sat"   => ["Open"=>"09:00", "Closed"=>"13:00"],
            "Sun"   => ["Open"=>"10:00", "Closed"=>"12:00"]
        ];

        return $openingTimesArray;
    }
    
    // Get state -> open or closed
    public static function isOpen() {

        $dateTime       = self::getDateTime();
        $time           = $dateTime->format('H:i');
        $day            = $dateTime->format('D');
        $openingTimes   = self::getOpeningTimes();

        // Compare current time with opening times array 
        if ($time >= $openingTimes[$day]["Open"] && $time < $openingTimes[$day]["Closed"]) {
            return json_encode(['status'=>'true', 'day'=>$day]);
        } else {
            return json_encode(['status'=>'false', 'day'=>$day]);
        }
    }

    // Display when next open if currently closed 
    public static function nextOpening() {
  
        $dateTime   = self::getDateTime();
        $today      = $dateTime->format('D');
        $time       = $dateTime->format('H:i');

        // If current time is before todays opening time, return the opening time.
        if ($time < self::getOpeningTimes()[$today]["Open"]) {
            $openingTime = self::getOpeningTimes()[$today]['Open'];
            return $openingTime;
        }

        // If current time is after todays closing time, return next opening time.
        if ($time > self::getOpeningTimes()[$today]["Closed"]) {
           
            $firstDay = array_key_first(self::getOpeningTimes());
            $lastDay  = array_key_last(self::getOpeningTimes());
            $nextDay  = new DateTime('+1day');

            if ($today !== $lastDay) {
                $tomorrow       = $nextDay->format('D');
                $openingTime    = self::getOpeningTimes()[$tomorrow]["Open"];
                $fullDay        = $nextDay->format('l');
                $string         = "$openingTime on $fullDay";
                return $string;
            } else {
                $openingTime    = self::getOpeningTimes()[$firstDay]["Open"];
                $string         = "$openingTime on Monday";
                return $string;
            }  
        }
    }

}

// Take JS ajax request and use above class to return status
if (isset($_POST['action']) && $_POST['action'] == 'isOpen') {
    $soh = new shopOpeningHours;
    echo $soh->isOpen();
}