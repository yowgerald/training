<?php

namespace App\Repository\Eloquent;

use App\Models\ClassUser;
use App\Repository\AttendanceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param ClassUser $model
     */
    public function __construct(ClassUser $model)
    {
        parent::__construct($model);
    }

    public function queryForCalculatingMonthlyPercentage()
    {
        $strQuery = '';
        $availableMonths = (array) $this->getMonthsToReport();

        // actual attendance divided by total then multiply to 100
        foreach ($availableMonths as $key => $month) {
            $monthNumber = $this->getMonthNumber($key);

            $strQuery .= '(
                (' . $this->queryForGettingMonthlyData($monthNumber, false) . ') /
                (' . $this->queryForGettingMonthlyData($monthNumber) . ')
            ) * 100 AS `' . $month . '`,';
        }

        // remove comma at the end
        $strQuery = rtrim($strQuery, ",");

        return $strQuery;
    }

    public function queryForGettingMonthlyData($monthInterval, $isTotal = true)
    {
        // for 'monthInterval', 1 = 1st month, 2 = 2nd month, 3 = 3rd month
        $monthInterval = (string) $monthInterval;

        $strQuery = 'SELECT COUNT(class_users.id) FROM class_users
            LEFT JOIN student_attendances AS sa ON sa.class_user_id = class_users.id
            WHERE DATE(sa.date) BETWEEN LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL ' . $monthInterval . ' MONTH
                AND (LAST_DAY(LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL ' . $monthInterval . ' MONTH))
                AND class_users.class_id = classes.id
        ';

        if (!($isTotal)) {
            // if query is not for getting the total, then filter by present students
            return $strQuery . ' AND sa.is_present = 1';
        }

        return $strQuery;
    }

    /**
     * @return mixed
     */
    public function getAttendanceReportInLastMonths()
    {
        $report = $this->model
            ->selectRaw('
                classes.name as class,
                ' . $this->queryForCalculatingMonthlyPercentage()
            )
            ->join('classes', 'classes.id', '=', 'class_users.class_id')
            ->join('users', 'users.id', '=', 'class_users.user_id')
            ->where('users.role_id', config('const.roles.student'))
            ->groupBy('classes.id');

        return $report;
    }

    /**
     * @return mixed
     */
    public function getAttendanceReportByMonth($month)
    {
        $availableMonths = (array) $this->getMonthsToReport();
        $monthIndicator = array_search($month, $availableMonths);
        $monthNumber = $this->getMonthNumber($monthIndicator);

        $report = $this->model
            ->selectRaw('
                classes.name as class,
                (
                    (' . $this->queryForGettingMonthlyData($monthNumber, false) . ') /
                    (' . $this->queryForGettingMonthlyData($monthNumber) . ')
                ) * 100 AS `' . $month . '`'
            )
            ->join('classes', 'classes.id', '=', 'class_users.class_id')
            ->join('users', 'users.id', '=', 'class_users.user_id')
            ->where('users.role_id', config('const.roles.student'))
            ->groupBy('classes.id');

        return $report;
    }

    public function getMonthNumber($monthIndicator)
    {
        switch ($monthIndicator) {
            case "first_month":
                return 1;
            case "second_month":
                return 2;
            case "third_month":
                return 3;
        }
    }

    public function getMonthsToReport()
    {
        $months = DB::select('
            SELECT DATE_FORMAT(LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 1 MONTH, "%Y/%m") AS first_month,
	        DATE_FORMAT(LAST_DAY(NOW()) + INTERVAL 1 day - INTERVAL 2 month, "%Y/%m") AS second_month,
            DATE_FORMAT(LAST_DAY(NOW()) + INTERVAL 1 day - INTERVAL 3 month, "%Y/%m") AS third_month
        ', []);

        return $months[0];
    }
}
