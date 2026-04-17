<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    protected $table = 'students';

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'email',
        'class_id',
        'is_active'
    ];

    // ========== Relationships ==========
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'class_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id')
                    ->withPivot('score', 'registered_at')
                    ->withTimestamps();
    }

    // ========== Local Scope ==========
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ========== Global Scope ==========
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('full_name', 'asc');
        });
    }
}
