<x-app-layout>
    <div class="max-w-md mx-auto py-10">
        <h2 class="text-xl font-semibold mb-4">Create Team</h2>

        <form method="POST" action="{{ route('teams.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Team Name</label>
                <input type="text" name="name" id="name" class="w-full rounded border-gray-300" required>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
        </form>
    </div>
</x-app-layout>
