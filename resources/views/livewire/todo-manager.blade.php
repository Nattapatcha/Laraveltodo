<div>
    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <form wire:submit.prevent="createTask">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">สร้างรายการใหม่</h3>
            <div class="flex space-x-2">
                
                <input 
                    type="text" 
                    wire:model="title" 
                    class="flex-grow form-input rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700" 
                    placeholder="ป้อนสิ่งที่ต้องทำ...">
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    เพิ่ม
                </button>
            </div>
            
            @error('title') 
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
            @enderror
        </form>
    </div>

    <div class="space-y-4">
        
        @forelse ($tasks as $task)
            <div wire:key="task-{{ $task->id }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-4">
                
                <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $task->title }}</h4>
                
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    สร้างโดย: {{ $task->user->name }} ({{ $task->created_at->diffForHumans() }})
                </p>

            </div>
        @empty
            <div class="text-center text-gray-500 dark:text-gray-400 p-4">
                ยังไม่มีรายการที่ต้องทำ
            </div>
        @endforelse
    </div>
</div>