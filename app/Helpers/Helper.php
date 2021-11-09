<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Hash;
use TaylorNetwork\UsernameGenerator\Generator;

class Helper
{
    public static function generateAuthData(string $fname, string $lname)
    {
        $authData = [];

        $generator = new Generator();
        $username = $generator->generate($fname . ' ' . $lname);
        $authData['username'] = $username . (string) rand(10000, 99999);

        $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, 6);
        $authData['password'] = Hash::make($password);

        return $authData;
    }

    public static function normalizePeriodData($data)
    {
        if (empty($data)) {
            $data = '08:00 - 09:00';
        }

        $arrayPeriod = [];
        $periodStart = explode(' - ', $data)[0];
        $arrayStart = explode(':', $periodStart);
        $arrayPeriod['period_start'] = mktime($arrayStart[0], $arrayStart[1], 0); //mktime(hour, min, sec)

        $periodEnd = explode(' - ', $data)[1];
        $arrayEnd = explode(':', $periodEnd);
        $arrayPeriod['period_end'] = mktime($arrayEnd[0], $arrayEnd[1], 0); //mktime(hour, min, sec)

        return $arrayPeriod;
    }
}
