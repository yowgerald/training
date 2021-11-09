<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Repository\AttendanceRepositoryInterface;

class AttendanceReportController extends Controller
{
    private $attendanceRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        $months = $this->attendanceRepository->getMonthsToReport();
        $attendanceReport = $this->attendanceRepository
            ->getAttendanceReportInLastMonths()
            ->get();

        return view('teacher.attendance.report',
            compact('attendanceReport', 'months'));
    }

    public function downloadCSV()
    {
        return (new AttendanceExport($this->attendanceRepository))
            ->download('attendance.csv',
                \Maatwebsite\Excel\Excel::CSV, [
                    'Content-Type' => 'text/csv',
            ]);
    }
}
