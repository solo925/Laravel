<x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <h2 class="text-xl font-semibold mb-6">Create Task for "{{ $project->name }}"</h2>

        <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
            @csrf

            <x-input-label for="title" value="Title" />
            <x-text-input name="title" class="w-full" required />

            <x-input-label for="description" value="Description" class="mt-4" />
            <textarea name="description" class="w-full border-gray-300 rounded"></textarea>

            <x-input-label for="status" value="Status" class="mt-4" />
            <select name="status" class="w-full border-gray-300 rounded">
                <option value="todo">To Do</option>
                <option value="in-progress">In Progress</option>
                <option value="done">Done</option>
            </select>

            <x-input-label for="priority" value="Priority" class="mt-4" />
            <select name="priority" class="w-full border-gray-300 rounded">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>

            <x-input-label for="due_date" value="Due Date" class="mt-4" />
            <x-text-input name="due_date" type="date" class="w-full" />

            <x-input-label for="assigned_to" value="Assign To" class="mt-4" />
            <select name="assigned_to" class="w-full border-gray-300 rounded">
                <option value="">— Select —</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Task</button>
        </form>
    </div>
</x-app-layout>
