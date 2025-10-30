<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Task; 
use Illuminate\Support\Facades\Auth; 

#[Layout('layouts.app')]
class TodoManager extends Component
{
    
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
        $tasks = Task::with('user')
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('livewire.todo-manager', [
            'tasks' => $tasks,
        ]);
    }
}
