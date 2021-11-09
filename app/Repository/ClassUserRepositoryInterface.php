<?php
namespace App\Repository;

use App\Model\ClassUser;

interface ClassUserRepositoryInterface
{
    public function getClassStudents($criteria);

    public function getNotInClassStudents($criteria);
}
