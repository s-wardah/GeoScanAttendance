<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Classes;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['teacher', 'room', 'class'])->get();

        $teachers = User::where('role', 'teachers')->get();

        $rooms = Rooms::all();
        $classes = Classes::all();

        return view('admin.schedule.index', compact('schedules', 'teachers', 'rooms', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'class_id' => 'required',
            'subject' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'academic_year' => 'required',
            'semester' => 'required',
        ]);

        $user = User::find($request->user_id);
        if ($user->role !== 'teachers') {
            return back()->with('error', 'User yang dipilih bukan seorang guru!');
        }
        
        Schedule::create($request->all());

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
