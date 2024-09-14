@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="calendar-wrapper">
    <div class="calendar-navigation">
        <a href="{{ route('attendances.index', ['date' => $previousDate]) }}" class="prev-day">&laquo; </a>
        <span class="current-date">{{ $currentDate->format('Y/m/d') }}</span>
        <a href="{{ route('attendances.index', ['date' => $nextDate]) }}" class="next-day"> &raquo;</a>
    </div>

    <form action="{{ route('attendances.index') }}" method="GET" class="date-picker-form">
        <label for="date-picker">カレンダー選択:</label>
        <input type="date" id="date-picker" name="date" value="{{ $currentDate->format('Y-m-d') }}" onchange="this.form.submit()">
    </form>
</div>

<table class="admin__table">
    <tr class="admin__row">
        <th class="admin__label">名前</th>
        <th class="admin__label">勤務開始</th>
        <th class="admin__label">勤務終了</th>
        <th class="admin__label">休憩時間</th>
        <th class="admin__label">勤務時間</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr class="admin__row">
        <td>{{ $attendance->name }}</td>
        
        <td>{{ \Carbon\Carbon::parse($attendance->start_time)->format('H:i:s') }}</td>
       
        <td>
            @if ($attendance->end_time)
                {{ \Carbon\Carbon::parse($attendance->end_time)->format('H:i:s') }}
            @else
                未入力
            @endif
        </td>
       
        <td>{{ $attendance->rest_time ? gmdate('H:i:s', $attendance->rest_time) : '00:00:00' }}</td>
        
        <td>{{ $attendance->total ? gmdate('H:i:s', $attendance->total) : '00:00:00' }}</td>
    </tr>
    @endforeach
</table>

<div class="pagination">
    {{ $attendances->links() }}
</div>
@endsection
