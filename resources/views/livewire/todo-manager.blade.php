<div> <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
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

            <div wire:key="task-{{ $task->id }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                
                <div class="p-4 border-b dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            @if ($task->is_completed)
                                <span class="text-green-500 font-semibold cursor-pointer line-through" wire:click="unCompleteTask({{ $task->id }})">
                                    [✓] {{ $task->title }}
                                </span>
                            @else
                                <span class="text-gray-900 dark:text-gray-100 font-semibold cursor-pointer" wire:click="completeTask({{ $task->id }})">
                                    [ ] {{ $task->title }}
                                </span>
                            @endif

                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                สร้างโดย: {{ $task->user->name }} ({{ $task->created_at->diffForHumans() }})
                            </p>

                            @if ($task->is_completed)
                                <p class="text-sm text-green-600 dark:text-gray-400">
                                    ทำเสร็จโดย: {{ $task->completer->name ?? 'N/A' }} เมื่อ {{ $task->completed_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                        
                        <div>
                            @can('delete', $task)
                                <button 
                                    wire:click="deleteTask({{ $task->id }})" 
                                    wire:confirm="คุณแน่ใจหรือไม่ว่าต้องการลบ Task นี้?"
                                    class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                    ลบ
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-800/50">
                    <h4 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Comments</h4>
                    
                    <form wire:submit.prevent="addComment({{ $task->id }})" class="mb-4">
                        <textarea 
                            wire:model="commentText.{{ $task->id }}" 
                            class="form-textarea w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 mb-2" 
                            rows="2" 
                            placeholder="แสดงความคิดเห็น...">
                        </textarea>
                        
                        <div class="flex justify-between items-center">
                            <input type="file" wire:model="commentImage.{{ $task->id }}" class="text-sm text-gray-600 dark:text-gray-400">
                            
                            <div wire:loading wire:target="commentImage.{{ $task->id }}" class="text-sm text-blue-500">
                                กำลังอัปโหลด...
                            </div>

                            <button type="submit" class="px-3 py-1 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                                ส่ง
                            </button>
                        </div>
                    </form>

                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @forelse ($task->comments as $comment)
                            <div wire:key="comment-{{ $comment->id }}" class="flex space-x-3">
                                <div class="flex-grow bg-white dark:bg-gray-700 p-3 rounded-md border dark:border-gray-600">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</span>
                                        
                                        @can('delete', $comment)
                                            <button 
                                                wire:click="deleteComment({{ $comment->id }})" 
                                                wire:confirm="คุณแน่ใจหรือไม่ว่าต้องการลบ Comment นี้?"
                                                class="text-gray-400 hover:text-red-500 text-xs font-bold">
                                                X
                                            </button>
                                        @endcan
                                    </div>
                                    
                                    @if ($comment->body)
                                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>
                                    @endif
                                    
                                    @if ($comment->image_path)
                                        <img src="{{ Storage::url($comment->image_path) }}" alt="Comment Image" class="mt-2 rounded-md max-w-xs max-h-40">
                                    @endif
                                    <span class="text-xs text-gray-400 mt-1 block">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">ยังไม่มี Comment</p>
                        @endforelse
                    </div>
                </div>

            </div> @empty
            <div class="text-center text-gray-500 dark:text-gray-400 p-4">
                ยังไม่มีรายการที่ต้องทำ
            </div>
        @endforelse </div>

</div> ```