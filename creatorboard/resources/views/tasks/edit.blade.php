<x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <h2 class="text-xl font-semibold mb-6">Edit Task: {{ $task->title }}</h2>

        <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
            @csrf @method('PUT')

            <x-input-label for="title" value="Title" />
            <x-text-input name="title" class="w-full" value="{{ $task->title }}" required />

            <x-input-label for="description" value="Description" class="mt-4" />
            <textarea name="description" class="w-full border-gray-300 rounded">{{ $task->description }}</textarea>

            <x-input-label for="status" value="Status" class="mt-4" />
            <select name="status" class="w-full border-gray-300 rounded">
                @foreach(['todo', 'in-progress', 'done'] as $status)
                    <option value="{{ $status }}" {{ $task->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <x-input-label for="priority" value="Priority" class="mt-4" />
            <select name="priority" class="w-full border-gray-300 rounded">
                @foreach(['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" {{ $task->priority === $priority ? 'selected' : '' }}>
                        {{ ucfirst($priority) }}
                    </option>
                @endforeach
            </select>

            <x-input-label for="due_date" value="Due Date" class="mt-4" />
            <x-text-input name="due_date" type="date" class="w-full" value="{{ $task->due_date }}" />

            <x-input-label for="assigned_to" value="Assign To" class="mt-4" />
            <select name="assigned_to" class="w-full border-gray-300 rounded">
                <option value="">— None —</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Task</button>
        </form>
    </div>
</x-app-layout>
