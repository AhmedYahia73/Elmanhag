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
         $utcTime = '2024-10-12 12:00:00'; // Example UTC time

         // Convert the UTC time to a Carbon instance
         $timeInUTC = Carbon::parse($utcTime, 'UTC');

         // Change the time to Egypt's time zone (Africa/Cairo)
         $timeInEgypt = $timeInUTC->setTimezone('Africa/Cairo');

         // Display the time in Egypt's time zone
         return  "Time in Egypt's time zone: " . $timeInEgypt->format('H-m');
            //  Get Time Zone EGYPT

            $nextDay = Carbon::parse("next $dayOfWeek");
            return $sessionTime;
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
        } else {
            return response()->json([
                'error' => 'This Day Expired',
            ], 404);
        }
    }
}
