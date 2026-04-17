<?php

namespace App\Repositories\Contracts;

interface StudentRepositoryInterface
{
    public function all(array $relations = []);
    public function find($id, array $relations = []);
    public function studentsByClass($classId);
    public function registerSubject($studentId, $subjectId, array $pivotData = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
