<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Helper;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $authData = Helper::generateAuthData($row[1], $row[2]);

        return new User([
            'physical_id'   => $row[0],
            'first_name'    => $row[1],
            'last_name'     => $row[2],

            'role_id'       => config('const.roles.student'),
            'username'      => $authData['username'],
            'password'      => $authData['password'],

        ]);
    }
}
