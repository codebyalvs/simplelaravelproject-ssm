<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'fname',
        'mi',
        'lname',
        'email',
        'contact',
        'section_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Optional: Accessor for full name
    public function getFullNameAttribute()
    {
        return trim("{$this->fname} {$this->mi} {$this->lname}");
    }
}
