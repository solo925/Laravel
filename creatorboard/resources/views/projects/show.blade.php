<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-2xl font-semibold mb-2">{{ $project->name }}</h2>

        <p class="text-sm text-gray-600 mb-2">
            Status: <strong>{{ $project->status }}</strong> | Deadline: {{ $project->deadline ?? 'None' }}
        </p>

        <p>{{ $project->description }}</p>

        <a href="{{ route('projects.edit', $project) }}" class="text-blue-500 hover:underline mt-4 inline-block">Edit Project</a>
    </div>
</x-app-layout>
