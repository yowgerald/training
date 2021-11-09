<?php
namespace App\Repository;

use Illuminate\Support\Collection;

interface AttendanceRepositoryInterface
{
    public function getAttendanceReportInLastMonths();

    public function getMonthsToReport();

    public function getAttendanceReportByMonth($month);
}
