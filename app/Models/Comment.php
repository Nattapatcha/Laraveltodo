<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Comment extends Model
{
    //
    use HasFactory;
    /**
     * 
     * 
     *
     * @var array
     */
    protected $fillable = ['task_id', 'user_id', 'body', 'image_path'];
    
    
    // Comment นี้ถูกสร้างโดย User คนไหน (ความสัมพันธ์ Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    
    // Comment นี้อยู่ใน Task ไหน (ความสัมพันธ์ Many-to-One)
    public function task()
    {
        return $this->belongsTo(Task::class);
    }



}
