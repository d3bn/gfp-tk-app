<x-common.layout>
    <x-slot:title>{{ $issue['title'] }}</x-slot:title>
    <div class="flex flex-col">
        <div class="flex justify-between items-center mb-5">
            <div>
                <h1 class="text-md/6 font-semibold text-gray-900">#{{$issue['number']}}: {{$issue['title']}}</h1>
                <span>{{ Carbon\Carbon::parse($issue['created_at'])->format('M d, Y') }}</span>

                <a href="{{route('edit', ['url' => urlencode($issue['url'])])}}">edit</a>
            </div>

            <a class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50" href="{{route('index')}}">
                Back
            </a>
        </div>

        <div>
            {{$issue['body']}}
        </div>
    </div>
</x-common.layout>
