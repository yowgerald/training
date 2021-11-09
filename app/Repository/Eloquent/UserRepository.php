<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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

    /**
     * @param $id
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getStudents($criteria = [])
    {
        $students = $this->model
            ->select('users.*')
            ->leftJoin('class_users as c_users', 'c_users.user_id', '=', 'users.id')
            ->where('users.role_id', config('const.roles.student'))
            ->fullNameMatch($criteria['name'] ?? null)
            ->classMatch($criteria['class_id'] ?? null)
            ->where(function ($query) use ($criteria) {
                if (!empty($criteria['teacher_id'])) {
                    $query->whereRaw('(
                        SELECT COUNT(teachers.id) FROM class_users
                        INNER JOIN users AS teachers ON class_users.user_id = teachers.id
                        WHERE teachers.role_id = ? AND teachers.id = ?
                            AND c_users.class_id = COALESCE(?, c_users.class_id)
                        ) >= 1
                    ', [
                        config('const.roles.teacher'),
                        $criteria['teacher_id'],
                        $criteria['class_id'],
                    ]);
                }
            })
            ->groupBy('users.id')
            ->orderBy('users.id', 'DESC');

        return $students;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getTeachers($criteria = [])
    {
        $teachers = $this->model
            ->select('users.*')
            ->leftJoin('class_users as c_users', 'c_users.user_id', '=', 'users.id')
            ->where('role_id', config('const.roles.teacher'))
            ->fullNameMatch($criteria['name'] ?? null)
            ->classMatch($criteria['class_id'] ?? null)
            ->groupBy('users.id')
            ->orderBy('users.id', 'DESC');

        return $teachers;
    }
}
