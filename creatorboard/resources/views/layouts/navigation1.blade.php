<form action="{{ route('teams.switch') }}" method="POST" class="inline-block">
    @csrf
    <select name="team_id" onchange="this.form.submit()" class="text-sm bg-white border rounded px-2 py-1">
        @foreach(auth()->user()->teams as $team)
            <option value="{{ $team->id }}" {{ auth()->user()->current_team_id === $team->id ? 'selected' : '' }}>
                {{ $team->name }}
            </option>
        @endforeach
    </select>
</form>
