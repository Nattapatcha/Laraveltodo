<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
        $table->id();
        
        // เชื่อมโยงกับ Task
        $table->foreignId('task_id')->constrained()->onDelete('cascade');
        
        // Requirement: ระบุว่าใครเป็นผู้ comment
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        // Requirement: ใส่ข้อความ หรือรูปภาพ
        $table->text('body')->nullable();
        $table->string('image_path')->nullable(); // เก็บ Path ที่ Upload รูป
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
