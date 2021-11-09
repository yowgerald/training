<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\ClassUserRepositoryInterface;

class ClassUserRepository extends BaseRepository implements ClassUserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function queryForGettingClassStudents()
    {
        $query = $this->model
            ->select('users.*',
                'class_users.id as class_user_id',
                'student_attendances.is_present',
                'student_attendances.id as attendance_id'
            )
            ->join('class_users', 'class_users.user_id', '=', 'users.id')
            ->join('student_attendances', 'student_attendances.class_user_id', '=', 'class_users.id')
            ->join('classes', 'classes.id', '=', 'class_users.class_id')
            ->join('class_periods', 'class_periods.class_id', 'classes.id')
            ->where('users.role_id', config('const.roles.student'));

        return $query;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getClassStudents($criteria = [])
    {
        $classStudents = $this->queryForGettingClassStudents()
            ->where(function($query) use ($criteria) {
                if (!empty($criteria['period_start']) && !empty($criteria['period_end'])) {
                    $query->where('class_periods.period_start', $criteria['period_start'])
                        ->where('class_periods.period_end', $criteria['period_end'])
                        ->whereRaw('student_attendances.class_period_id = class_periods.id');
                }
            })
            ->where('class_users.class_id', '=', $criteria['id'])
            ->groupBy('users.id');

        return $classStudents;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getNotInClassStudents($criteria = [])
    {
        $studentsInClass = $this->queryForGettingClassStudents()
            ->where(function($query) use ($criteria) {
                if (!empty($criteria['period_start']) && !empty($criteria['period_end'])) {
                    $query->where('period_start', '>=', $criteria['period_start'])
                        ->where('period_end', '<=', $criteria['period_end'])
                        ->whereRaw('student_attendances.class_period_id = class_periods.id');
                }
            })
            ->pluck('id');

        $notInClassStudents = $this->model
            ->whereNotIn('id', $studentsInClass)
            ->where('users.role_id', config('const.roles.student'));

        return $notInClassStudents;
    }
}
