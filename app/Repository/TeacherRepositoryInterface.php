<?php
namespace App\Repository;

interface TeacherRepositoryInterface
{
    public function getTeacherClasses($criteria);

    public function getNotInTeacherClasses($criteria);

    public function getTeacherClassesWithPeriods($criteria);
}
