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
            $timestamp = now(); // Example timestamp

            return $time = Carbon::parse($timestamp)->setTimezone('Africa/Cairo')->format('H:m');
            $now = Carbon::now('Africa/Cairo')->format('H:m');
            $now = Carbon::now('Africa/Cairo');
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
