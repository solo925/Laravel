<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <h2 class="text-2xl font-semibold mb-6">Projects</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('status') }}</div>
        @endif

        <a href="{{ route('projects.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + New Project
        </a>

        <div class="grid gap-4">
            @forelse ($projects as $project)
                <div class="p-4 border rounded bg-white shadow">
                    <h3 class="text-lg font-bold">{{ $project->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $project->status }} | Deadline: {{ $project->deadline ?? 'N/A' }}</p>
                    <p class="mt-2">{{ Str::limit($project->description, 100) }}</p>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:underline">View</a>
                        <a href="{{ route('projects.edit', $project) }}" class="text-yellow-500 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No projects yet. Create one.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
