<?php

namespace App\Helpers;

use App\Core\App;

class Formatter
{
    /**
     * @param $status
     * @return string
     */
    public static function formatPalindromeStatus($status) :string
    {
        switch ($status) {
            case 1:
                return 'Yes!';
            case 2:
                return 'Almost...';
            default:
                return 'No';
        }
    }

    /**
     * @param $dateTime
     * @return false|string
     * @throws Exception
     */
    public static function formatDate($dateTime)
    {
        try {
            $dateFormat = App::get('config')['date_format'];
            $timeFormat = App::get('config')['time_format'];

            return date($timeFormat . ' ' . $dateFormat, strtotime($dateTime));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
