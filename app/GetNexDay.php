<?php

namespace App;

use Carbon\Carbon;
use Error;
use ErrorException;

trait GetNexDay
{
    // This Function Get Next Day Of Week

    public function getNextDayBetween($startDate, $endDate, $dayOfWeek, $sessionTime)
    {
        try {
            // Convert start and end dates to Carbon instances
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            // Get the next occurrence of the specified day from the current date
            //  Get Time Zone EGYPT
             $timestamp = $timeInEgypt = now()->setTimezone('Africa/Cairo')->format('H:m'); // Example timestamp
            $nowDayName = now()->format('l'); // Example timestamp
             $nameSessionDay = Carbon::parse($dayOfWeek)->format('l') ;
             $time = Carbon::parse($timestamp)->setTimezone('Africa/Cairo')->format('H:m');
                if($nameSessionDay == $nowDayName && $timestamp <= $sessionTime){
                     $nextDay = Carbon::parse(time:" $dayOfWeek"); // Example timestamp
                }else{
                              $nextDay = Carbon::parse(time:"next $dayOfWeek");
                }
            //  $nextDay->format('l:Y-m-d');
            //  Get Time Zone EGYPT

        } catch (\Exception $e) {
            return response()->json(['Faield' => 'Thy Day Unformated Check If Spelling and Day Must Be Lower Case']);
        }
        // Check if the next occurrence falls within the start_date and end_date
        if ($nextDay->between($start, $end)) {
            $carbonDate = Carbon::parse($nextDay);
            $dayName = $carbonDate->format('l'); //  returns the full day name
            $nextDate =  $nextDay->toDateString(); // returns The Date Format Y-m-d
            $data = [
                'name' => $dayName,
                'date' => $nextDate,
            ];
            return $data;
        }
        return Null;
    }
}
