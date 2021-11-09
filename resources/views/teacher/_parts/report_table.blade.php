<table class="table">
    <thead>
    <tr>
        <th><abbr title="Class">Classes</abbr></th>
        <th><abbr title="Month">{{ $months->first_month }}</abbr></th>
        <th><abbr title="Month">{{ $months->second_month }}</abbr></th>
        <th><abbr title="Month">{{ $months->third_month }}</abbr></th>

    </tr>
    </thead>
    <tbody>
    @forelse($attendanceReport as $report)
        <tr>
            <td>{{ $report->class }}</td>
            @php
                $report = array_values($report->toArray());
            @endphp
            <td class="has-text-centered">{{ number_format($report[1], 0) }}%</td>
            <td class="has-text-centered">{{ number_format($report[2], 0) }}%</td>
            <td class="has-text-centered">{{ number_format($report[3], 0) }}%</td>
        </tr>
    @empty
        <tr>
            <td>No Reports to show.</td>
        </tr>
    @endforelse
    </tbody>
</table>
