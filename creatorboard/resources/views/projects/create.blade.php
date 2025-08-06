<x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <h2 class="text-xl font-semibold mb-6">Create Project</h2>

        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <x-input-label for="name" value="Project Name" />
            <x-text-input name="name" id="name" class="w-full" required />

            <x-input-label for="description" value="Description" class="mt-4" />
            <textarea name="description" class="w-full border-gray-300 rounded"></textarea>

            <x-input-label for="status" value="Status" class="mt-4" />
            <select name="status" class="w-full border-gray-300 rounded">
                <option value="planning">Planning</option>
                <option value="active">Active</option>
                <option value="on-hold">On Hold</option>
                <option value="completed">Completed</option>
            </select>

            <x-input-label for="deadline" value="Deadline" class="mt-4" />
            <x-text-input type="date" name="deadline" class="w-full" />

            <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create
            </button>
        </form>
    </div>
</x-app-layout>
