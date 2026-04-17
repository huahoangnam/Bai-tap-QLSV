<?php

namespace App\Http\Controllers;

use App\Models\Student;

class StudentController extends Controller
{
    // Lấy tất cả (đã có global scope sắp xếp theo tên)
    public function index()
    {
        $students = Student::all();
        return $students;
    }

    // Chỉ lấy sinh viên active (dùng local scope)
    public function activeStudents()
    {
        $students = Student::active()->get();
        return $students;
    }

    // Bỏ qua global scope
    public function withoutGlobalScope()
    {
        $students = Student::withoutGlobalScope('ordered')->get();
        return $students;
    }
}
