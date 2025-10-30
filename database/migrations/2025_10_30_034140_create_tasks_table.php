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
       Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // ชื่อสิ่งที่ต้องทำ
        $table->text('description')->nullable(); // (เผื่อไว้ใส่รายละเอียด)

        // Requirement: ระบุว่าใครคือผู้สร้าง
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 

        // Requirement: สถานะการ Checklist
        $table->boolean('is_completed')->default(false);
        $table->timestamp('completed_at')->nullable();
        
        // Requirement: ระบุว่าใครเป็นผู้ทำ
        $table->foreignId('completed_by_user_id')->nullable()->constrained('users')->onDelete('set null'); 

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
