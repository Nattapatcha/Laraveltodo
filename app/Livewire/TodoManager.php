<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Comment;
use App\Models\Task; 
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class TodoManager extends Component
{
    use WithFileUploads;

    public $commentText = [];
    public $commentImage = [];
    
    public string $title = ''; 

    public function createTask()
    {
        
        $this->validate([
            'title' => 'required|string|min:3',
        ]);

       
        Task::create([
            'title' => $this->title,
            'user_id' => Auth::id(), // ระบุว่าใครเป็นคนสร้าง
        ]);

        
        $this->reset('title'); 
    }
    public function render()
    {
        $tasks = Task::with('user', 'completer', 'comments.user')
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('livewire.todo-manager', [
            'tasks' => $tasks,
        ]);
    }

    public function addComment(Task $task)
    {
        $text = $this->commentText[$task->id] ?? null;
        $image = $this->commentImage[$task->id] ?? null;

        // ต้องมีข้อความ หรือ รูปภาพ อย่างใดอย่างหนึ่ง
        if (empty($text) && empty($image)) {
            
            return;
        }
        
        $imagePath = null;
        if ($image) {
            $imagePath = $image->store('comments', 'public');
        }


        $task->comments()->create([
            'user_id' => Auth::id(),
            'body' => $text,
            'image_path' => $imagePath,
        ]);

        unset($this->commentText[$task->id]);
        unset($this->commentImage[$task->id]);
        

        $this->reset('commentImage'); 
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);


        if ($comment->image_path) {
            Storage::disk('public')->delete($comment->image_path);
        }

        $comment->delete();
    }
    public function completeTask(Task $task)
    {
        if (!$task->is_completed) {
            $task->update([
                'is_completed' => true,
                'completed_at' => now(),
                'completed_by_user_id' => Auth::id(),
            ]);
        }
    }


    public function unCompleteTask(Task $task)
    {
         $task->update([
            'is_completed' => false,
            'completed_at' => null,
            'completed_by_user_id' => null,
        ]);
    }


    public function deleteTask(Task $task)
    {
        $this->authorize('delete', $task);

        // (ต้องลบรูปใน comment ก่อน ถ้ามี)
        foreach($task->comments as $comment) {
            if($comment->image_path) {
                Storage::disk('public')->delete($comment->image_path);
            }
        }
        
        $task->delete();
    }
}
# test
