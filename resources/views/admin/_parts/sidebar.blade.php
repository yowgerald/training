<aside class="column is-2 is-narrow-mobile is-fullheight section is-hidden-mobile">
    <p class="menu-label is-hidden-touch">Administration</p>
    <ul class="menu-list">
        <li>
            <a href="{{ route('student.index') }}" class="{{ (request()->segment(2) == 'student') ? 'is-active' : ''}}">
                Students
            </a>
        </li>
        <li>
            <a href="{{ route('teacher.index') }}" class="{{ (request()->segment(2) == 'teacher') ? 'is-active' : ''}}">
                Teachers
            </a>
        </li>
        <li>
            <a href="{{ route('class.index') }}" class="{{ (request()->segment(2) == 'class') ? 'is-active' : ''}}">
                Classes
            </a>
        </li>
        <li>
            <a href="{{ route('plot_class.index') }}" class="{{ (request()->segment(2) == 'plot_class') ? 'is-active' : ''}}">
                Plot Classes
            </a>
        </li>
        <li>
            <a href="{{ route('plot_teacher.index') }}" class="{{ (request()->segment(2) == 'plot_teacher') ? 'is-active' : ''}}">
                Plot Teachers
            </a>
        </li>
        <li>
            <a href="{{ route('account.index') }}" class="{{ (request()->segment(2) == 'account') ? 'is-active' : ''}}">
                Accounts
                <span class="tag is-danger">new</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                Logout
            </a>
        </li>
    </ul>
</aside>
