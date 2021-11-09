<aside class="column is-2 is-narrow-mobile is-fullheight section is-hidden-mobile">
    <p class="menu-label is-hidden-touch">Teachers</p>
    <ul class="menu-list">
        <li>
            <a href="{{ route('attendance.index') }}" class="{{ (request()->segment(2) == 'attendance') ? 'is-active' : ''}}">
                Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('attendance_report.index') }}" class="{{ (request()->segment(2) == 'attendance_report') ? 'is-active' : ''}}">
                Attendance Report
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                Logout
            </a>
        </li>
    </ul>
</aside>
