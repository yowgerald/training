<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repository\AttendanceRepositoryInterface;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    private $attendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        $attendanceReport = $this->attendanceRepository
            ->getAttendanceReportInLastMonths()
            ->get();

        return response(['message' => 'Retrieved successfully', 'result' => $attendanceReport], 200);
    }

    public function getReportByMonth($month)
    {
        $availableMonths = (array) $this->attendanceRepository->getMonthsToReport();
        $month = (string) $month;

        //add "/", separate the year and month
        $month = implode("/", str_split($month, 4));

        $attendanceReport = $this->attendanceRepository
            ->getAttendanceReportByMonth($month)
            ->get();

        if (!in_array($month, $availableMonths) ) {
            return response(['message' => 'No results found.', 'result' => []], 404);
        }

        return response(['message' => 'Retrieved successfully', 'result' => $attendanceReport], 200);
    }
}
