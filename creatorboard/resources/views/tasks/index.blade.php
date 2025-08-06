<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">
        <h2 class="text-2xl font-semibold mb-4">Tasks for "{{ $project->name }}"</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ route('projects.tasks.create', $project) }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + New Task
        </a>

        <div class="grid gap-4">
            @forelse ($tasks as $task)
                <div class="bg-white shadow rounded p-4 border">
                    <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                    <p class="text-gray-600">{{ $task->description }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Status: <strong>{{ $task->status }}</strong> |
                        Priority: {{ ucfirst($task->priority) }} |
                        Due: {{ $task->due_date ?? 'N/A' }} |
                        Assigned to: {{ $task->assignee->name ?? 'Unassigned' }}
                    </p>

                    <div class="mt-3 flex gap-3">
                        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-yellow-500 hover:underline">Edit</a>
                        <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No tasks yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
