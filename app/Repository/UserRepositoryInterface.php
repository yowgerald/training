<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function getStudents($criteria);

    public function getTeachers($criteria);
}
