<?php

namespace App\Imports;

use App\Models\User;
use App\Models\TeacherDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Helper;

class TeachersImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $authData = Helper::generateAuthData($row[1], $row[2]);

            $savedUser = User::create([
                'physical_id'   => $row[0],
                'first_name'    => $row[1],
                'last_name'     => $row[2],

                'role_id'       => config('const.roles.teacher'),
                'username'      => $authData['username'],
                'password'      => $authData['password'],
            ]);

            TeacherDetail::create([
                'title'         => $row[3],
                'user_id'       => $savedUser->id
            ]);
        }
    }
}
