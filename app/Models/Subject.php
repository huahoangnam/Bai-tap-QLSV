<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $primaryKey = 'subject_id';
    protected $table = 'subjects';

    protected $fillable = [
        'subject_name',
        'credits'
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_id', 'student_id')
                    ->withPivot('score', 'registered_at')
                    ->withTimestamps();
    }
}
