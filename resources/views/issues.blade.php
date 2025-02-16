<x-common.layout>
    <x-slot:title>Open Issues</x-slot:title>

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 ">Open Issues</h1>

    <ul role="list" class="divide-y divide-gray-100 my-10">
        @forelse ($issues as $issue)
        <li class="flex justify-between gap-x-6 py-5">
            <div class="flex flex-col min-w-0 gap-x-4">
                <h2 class="text-md/6 text-gray-900 focus:text-purple">
                    <a href="{{ route('show', ['issue'=> $issue['number'], 'url' => urlencode($issue['url'])])}}">{{ $issue['title'] }}
                    </a>
                </h2>

                <div class="flex gap-1 justify-start">
                    <span class="text-xs/5 text-gray-500">#{{ $issue['number'] }}</span>
                    <span class="text-xs/5 text-gray-500">{{ Carbon\Carbon::parse($issue['created_at'])->format('M d, Y') }}</span>
                </div>
            </div>

            <a class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50" href="{{ route('show', ['issue'=> $issue['number'], 'url' => urlencode($issue['url'])])}}">
                View
            </a>
        </li>
        @empty
        <li class="flex justify-between gap-x-6 py-5">
            <h2>No issues found.</h2>
        </li>
        @endforelse
    </ul>
</x-common.layout>
