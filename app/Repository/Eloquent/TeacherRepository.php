<?php

namespace App\Repository\Eloquent;

use App\Models\MClass;
use App\Repository\TeacherRepositoryInterface;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param MClass $model
     */
    public function __construct(MClass $model)
    {
        parent::__construct($model);
    }

    public function queryForGettingTeacherClasses()
    {
        $query = $this->model
            ->select(
                'classes.*',
                'class_users.id as class_user_id',
                'class_periods.id as class_period_id',
                'class_periods.period_start',
                'class_periods.period_end'
            )
            ->join('class_users', 'class_users.class_id', '=', 'classes.id')
            ->join('class_periods', 'class_periods.class_id', 'classes.id');

        return $query;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getTeacherClasses($criteria = [])
    {
        $teacherClasses = $this->queryForGettingTeacherClasses()
            ->where(function($query) use ($criteria) {
                if (!empty($criteria['period_start']) && !empty($criteria['period_end'])) {
                    $query->where('period_start', $criteria['period_start'])
                        ->where('period_end', $criteria['period_end']);
                }
            })
            ->where('class_users.user_id', $criteria['id'])
            ->groupBy('classes.id');

        return $teacherClasses;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getNotInTeacherClasses($criteria = [])
    {
        $teacherClasses = $this->queryForGettingTeacherClasses()
            ->where(function($query) use ($criteria) {
                if (!empty($criteria['period_start']) && !empty($criteria['period_end'])) {
                    $query->where('period_start', '>=', $criteria['period_start'])
                        ->where('period_end', '<=', $criteria['period_end']);
                }
            })
            ->where('class_users.user_id', $criteria['id'])
            ->pluck('id');

        $notInTeacherClasses = $this->model
            ->whereNotIn('id', $teacherClasses);

        return $notInTeacherClasses;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getTeacherClassesWithPeriods($criteria)
    {
        $classes = $this->queryForGettingTeacherClasses()
            ->where('class_users.user_id', $criteria['id'])
            ->orderBy('class_periods.id');

        return $classes;
    }
}
