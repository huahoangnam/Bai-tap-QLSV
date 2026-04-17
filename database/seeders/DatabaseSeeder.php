<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo lớp học
        $class1 = Classroom::create([
            'class_name' => 'CNTT1',
            'room_number' => 'A101',
            'academic_year' => '2024'
        ]);

        $class2 = Classroom::create([
            'class_name' => 'CNTT2',
            'room_number' => 'A102',
            'academic_year' => '2024'
        ]);

        $class3 = Classroom::create([
            'class_name' => 'CNTT3',
            'room_number' => 'A103',
            'academic_year' => '2024'
        ]);

        // Tạo sinh viên
        $student1 = Student::create([
            'full_name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@gmail.com',
            'date_of_birth' => '2000-01-15',
            'class_id' => $class1->class_id,
            'is_active' => true
        ]);

        $student2 = Student::create([
            'full_name' => 'Trần Thị B',
            'email' => 'tranthib@gmail.com',
            'date_of_birth' => '2000-03-20',
            'class_id' => $class1->class_id,
            'is_active' => true
        ]);

        $student3 = Student::create([
            'full_name' => 'Lê Văn C',
            'email' => 'levanc@gmail.com',
            'date_of_birth' => '2001-05-10',
            'class_id' => $class2->class_id,
            'is_active' => true
        ]);

        $student4 = Student::create([
            'full_name' => 'Phạm Thị D',
            'email' => 'phamthid@gmail.com',
            'date_of_birth' => '2000-11-25',
            'class_id' => $class2->class_id,
            'is_active' => false
        ]);

        $student5 = Student::create([
            'full_name' => 'Hoàng Văn E',
            'email' => 'hoangvane@gmail.com',
            'date_of_birth' => '2001-07-30',
            'class_id' => $class1->class_id,
            'is_active' => true
        ]);

        // Tạo môn học
        $subject1 = Subject::create([
            'subject_name' => 'Lập trình Web với Laravel',
            'credits' => 3
        ]);

        $subject2 = Subject::create([
            'subject_name' => 'ReactJS',
            'credits' => 2
        ]);

        $subject3 = Subject::create([
            'subject_name' => 'Cơ sở dữ liệu',
            'credits' => 4
        ]);

        $subject4 = Subject::create([
            'subject_name' => 'Lập trình hướng đối tượng',
            'credits' => 3
        ]);

        // Đăng ký môn học cho sinh viên
        // Sinh viên 1 đăng ký 2 môn
        $student1->subjects()->attach($subject1->subject_id, ['score' => 8.5, 'registered_at' => now()]);
        $student1->subjects()->attach($subject2->subject_id, ['score' => 7.0, 'registered_at' => now()]);

        // Sinh viên 2 đăng ký 1 môn
        $student2->subjects()->attach($subject1->subject_id, ['score' => 9.0, 'registered_at' => now()]);

        // Sinh viên 3 đăng ký 2 môn
        $student3->subjects()->attach($subject2->subject_id, ['score' => 8.0, 'registered_at' => now()]);
        $student3->subjects()->attach($subject3->subject_id, ['score' => 7.5, 'registered_at' => now()]);

        // Sinh viên 5 đăng ký 3 môn
        $student5->subjects()->attach($subject1->subject_id, ['score' => 8.0, 'registered_at' => now()]);
        $student5->subjects()->attach($subject3->subject_id, ['score' => 9.0, 'registered_at' => now()]);
        $student5->subjects()->attach($subject4->subject_id, ['score' => 8.5, 'registered_at' => now()]);
    }
}
