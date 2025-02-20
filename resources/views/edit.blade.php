<x-common.layout>
    <x-slot:title>Edit — {{$issue['title']}}</x-slot:title>

    <form method="POST" action="{{route('update')}}">
        @csrf
        @method("PATCH")
        <input name="owner" value="{{ $issue['user']['login'] }}" type="hidden" />
        <input name="repo" value="{{ $issue['repo_name'] }}"  type="hidden" />
        <input name="issue_number" value="{{ $issue['number'] }}"  type="hidden" />

        <textarea name="body">{{ $issue['body'] }}</textarea>

        <button type="submit">submit</button>
    </form>
</x-common.layout>
