<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ ADD THIS

class EditorContent extends Model
{
    use HasFactory, SoftDeletes; // ✅ ADD THIS

    protected $fillable = [
        'content',
    ];
}