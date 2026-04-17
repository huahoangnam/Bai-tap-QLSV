<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    // Cách 1: Eloquent
    public function query1a()
    {
        $students = Classroom::where('class_name', 'CNTT1')->first()->students;
        return $students;
    }

    // Cách 2: Query Builder
    public function query1b()
    {
        $students = DB::table('students')
            ->join('classrooms', 'students.class_id', '=', 'classrooms.class_id')
            ->where('classrooms.class_name', 'CNTT1')
            ->select('students.*')
            ->get();
        return $students;
    }

    // Cách 3: whereHas
    public function query1c()
    {
        $students = Student::whereHas('classroom', function($q) {
            $q->where('class_name', 'CNTT1');
        })->get();
        return $students;
    }
}
