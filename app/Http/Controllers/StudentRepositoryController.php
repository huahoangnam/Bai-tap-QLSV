<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\StudentRepositoryInterface;

class StudentRepositoryController extends Controller
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        $students = $this->studentRepository->all(['classroom', 'subjects']);
        return response()->json($students);
    }

    public function show($id)
    {
        $student = $this->studentRepository->find($id, ['classroom', 'subjects']);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student);
    }

    public function studentsByClass($classId)
    {
        $students = $this->studentRepository->studentsByClass($classId);
        return response()->json($students);
    }

    public function registerSubject($studentId, $subjectId)
    {
        $result = $this->studentRepository->registerSubject($studentId, $subjectId);
        if (!$result) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json(['message' => 'Registered successfully', 'data' => $result]);
    }
}
