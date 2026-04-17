<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function all(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function find($id, array $relations = [])
    {
        return $this->model->with($relations)->find($id);
    }

    public function studentsByClass($classId)
    {
        return $this->model->where('class_id', $classId)->get();
    }

    public function registerSubject($studentId, $subjectId, array $pivotData = [])
    {
        $student = $this->model->find($studentId);
        if (!$student) {
            return null;
        }

        $defaultData = [
            'score' => null,
            'registered_at' => now()
        ];

        $data = array_merge($defaultData, $pivotData);

        $student->subjects()->attach($subjectId, $data);
        return $student->subjects()->where('subject_id', $subjectId)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $student = $this->model->find($id);
        if (!$student) {
            return null;
        }
        $student->update($data);
        return $student;
    }

    public function delete($id)
    {
        $student = $this->model->find($id);
        if (!$student) {
            return false;
        }
        return $student->delete();
    }
}
