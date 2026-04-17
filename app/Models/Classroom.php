<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $primaryKey = 'class_id';
    protected $table = 'classrooms';

    protected $fillable = [
        'class_name',
        'room_number',
        'academic_year'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id', 'class_id');
    }
}
