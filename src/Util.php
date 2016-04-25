<?php

namespace Shokai;

class Util
{
    public static function getDatetime($time = null)
    {
        return new \Datetime($time === null ? time() : $time);
    }


    public static function getDatetimeString($time = null)
    {
        return date('Y-m-d H:i:s', $time === null ? time() : $time);
    }
    
    public static function dateTimeToString(\Datetime $date)
    {
        return date_format($date, 'Y-m-d H:i:s');
    }
}
