<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    /**
     * 
     * 
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    // Task นี้ถูกสร้างโดย User คนไหน (ความสัมพันธ์ Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Task นี้ถูกทำเสร็จโดย User คนไหน (ความสัมพันธ์ Many-to-One)
    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by_user_id');
    }

    // Task นี้มีหลาย Comments (ความสัมพันธ์ One-to-Many)
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }




}
