<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Subject;

class StudentApiController extends Controller
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * GET /api/students
     */
    public function index()
    {
        $students = $this->studentRepository->all(['classroom', 'subjects']);

        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách sinh viên thành công',
            'data' => $students
        ], 200);
    }

    /**
     * POST /api/students
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email',
            'date_of_birth' => 'nullable|date',
            'class_id' => 'required|exists:classrooms,class_id',
            'is_active' => 'boolean'
        ]);

        $student = $this->studentRepository->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm sinh viên thành công',
            'data' => $student
        ], 201);
    }

    /**
     * GET /api/students/{id}
     */
    public function show($id)
    {
        $student = $this->studentRepository->find($id, ['classroom', 'subjects']);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin sinh viên thành công',
            'data' => $student
        ], 200);
    }

    /**
     * PUT /api/students/{id}
     */
    public function update(Request $request, $id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên'
            ], 404);
        }

        $validated = $request->validate([
            'full_name' => 'sometimes|string|max:100',
            'email' => ['sometimes', 'email', Rule::unique('students')->ignore($id, 'student_id')],
            'date_of_birth' => 'nullable|date',
            'class_id' => 'sometimes|exists:classrooms,class_id',
            'is_active' => 'boolean'
        ]);

        $updated = $this->studentRepository->update($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sinh viên thành công',
            'data' => $updated
        ], 200);
    }

    /**
     * DELETE /api/students/{id}
     */
    public function destroy($id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên'
            ], 404);
        }

        $this->studentRepository->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Xóa sinh viên thành công'
        ], 200);
    }

    /**
     * GET /api/students/{id}/subjects
     */
    public function getSubjects($id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên'
            ], 404);
        }

        $subjects = $student->subjects()->withPivot('score', 'registered_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách môn học thành công',
            'data' => $subjects
        ], 200);
    }

    /**
     * POST /api/students/{id}/register-subject/{subject_id}
     */
    public function registerSubject($id, $subjectId, Request $request)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên'
            ], 404);
        }

        $subjectExists = Subject::where('subject_id', $subjectId)->exists();
        if (!$subjectExists) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy môn học'
            ], 404);
        }

        $alreadyRegistered = $student->subjects()->where('subject_id', $subjectId)->exists();
        if ($alreadyRegistered) {
            return response()->json([
                'success' => false,
                'message' => 'Sinh viên đã đăng ký môn học này rồi'
            ], 400);
        }

        $validated = $request->validate([
            'score' => 'nullable|numeric|min:0|max:10'
        ]);

        $pivotData = [
            'score' => $validated['score'] ?? null,
            'registered_at' => now()
        ];

        $result = $this->studentRepository->registerSubject($id, $subjectId, $pivotData);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký môn học thành công',
            'data' => $result
        ], 201);
    }
}
