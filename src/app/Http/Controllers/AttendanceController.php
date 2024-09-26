<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    
    public function index(Request $request)
    {
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now();
          $attendances = Attendance::paginate(5);
          $attendances = Attendance::whereDate('start_time', $date)->paginate(5);
        return view('attendance', [
            'attendances' => $attendances,
            'currentDate' => $date,
            'previousDate' => $date->copy()->subDay()->format('Y-m-d'),
            'nextDate' => $date->copy()->addDay()->format('Y-m-d'),
        ]);
    }

    public function start(Request $request)
    {
        $attendance = Attendance::where('user_id', Auth::id())
                                ->whereDate('start_time', Carbon::today())
                                ->whereNull('end_time')
                                ->first();

        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->user_id = Auth::id();
            $attendance->name = Auth::user()->name;
            $attendance->start_time = Carbon::now('Asia/Tokyo');
            $attendance->end_time = null;
            $attendance->rest_time = 0; 
            $attendance->total = 0;     
            $attendance->save();
        }

        return response()->json(['success' => true, 'start_time' => $attendance->start_time]);
    }

    
    public function end(Request $request)
    {
        $attendance = Attendance::where('user_id', Auth::id())
                                ->whereNull('end_time')
                                ->whereDate('start_time', Carbon::today())
                                ->first();

        if ($attendance) {
            $attendance->end_time = now(); 

            $restTime = $attendance->rest_time ?? 0;

           
            $totalWorkingTimeInSeconds = $this->calculateTotalWorkingTimeInSeconds(
                $attendance->start_time,
                $attendance->end_time,
                $restTime
            );

            $attendance->total = $totalWorkingTimeInSeconds; 

            $attendance->save();

            return response()->json([
                'success' => true,
                'end_time' => $attendance->end_time->format('H:i:s'),
                'total' => gmdate('H:i:s', $attendance->total),
                'rest_time' => gmdate('H:i:s', $attendance->rest_time)
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    
    private function calculateTotalWorkingTimeInSeconds($startTime, $endTime, $restTime)
    {
        $start = strtotime($startTime);
        $end = strtotime($endTime);

       
        $totalTime = $end - $start;
        $totalWorkingTimeInSeconds = $totalTime - $restTime;

        return $totalWorkingTimeInSeconds;
    }
    
   
    public function recordRest(Request $request)
{
    $attendance = Attendance::where('user_id', Auth::id())
                            ->whereDate('start_time', today())
                            ->first();

    if ($attendance) {
        $restStartTime = $request->input('rest_start_time'); 
        $restEndTime = $request->input('rest_end_time'); 

        if (!$restStartTime || !$restEndTime) {
            return response()->json(['success' => false, 'message' => '休憩開始時間または終了時間が不足しています。'], 400);
        }

        $restStart = Carbon::createFromFormat('Y-m-d H:i:s', $restStartTime);
        $restEnd = Carbon::createFromFormat('Y-m-d H:i:s', $restEndTime);

        
        $restDurationInSeconds = $restStart->diffInSeconds($restEnd);
        $attendance->rest_time += $restDurationInSeconds;
        $attendance->save();

        return response()->json([
            'success' => true,
            'rest_time' => gmdate("H:i:s", $attendance->rest_time)
        ]);
    }

    return response()->json(['success' => false], 400);
}

    
    private function calculateDurationInSeconds($startTime, $endTime)
    {
        $startTimestamp = strtotime($startTime);
        $endTimestamp = strtotime($endTime);

        return $endTimestamp - $startTimestamp;
    }

    
    public function calculateTotalWorkingTime($startTime, $endTime, $totalRestTime)
    {
        $totalTime = strtotime($endTime) - strtotime($startTime);
        $totalWorkingTime = $totalTime - $totalRestTime; 

        return gmdate("H:i:s", $totalWorkingTime); 
    }
}
