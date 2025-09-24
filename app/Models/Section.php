<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // One Section has many Students
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
