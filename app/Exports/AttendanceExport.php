<?php

namespace App\Exports;

use App\Repository\AttendanceRepositoryInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AttendanceExport implements FromView
{
    use Exportable;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function view(): View
    {
        $months = $this->attendanceRepository->getMonthsToReport();
        $attendanceReport = $this->attendanceRepository
            ->getAttendanceReportInLastMonths()
            ->get();

        return view('teacher._parts.report_table',
            compact('attendanceReport', 'months'));
    }
}
