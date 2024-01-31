@extends('auth.layouts')

@section('content')
<div x-data="{ search: '{{ e($search) }}' }" class="container mx-auto p-6">
    <div class="bg-white rounded shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Show URLs</h2>

        <div class="mb-4">
            <input
                x-model="search"
                x-on:input.debounce.500ms="window.location = '{{ url()->current() }}?search=' + search"
                type="text"
                placeholder="Search..."
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                style="padding: 5px 10px; margin: 10px 0px; border: 1px solid #ccc;"
            />
        </div>

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">
                        <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'domain.name', 'order' => $order === 'asc' ? 'desc' : 'asc'])) }}">
                            Domain
                            @if($sort === 'domain.name')
                                <span>{{ $order === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b" style="width: 10%;">URL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($urls as $url)
                    <tr x-data="{ url: '{{ e($url->url) }}', domainName: '{{ e($url->domain->name) }}', search: '{{ e($search) }}' }" x-show="!search || url.toLowerCase().includes(search.toLowerCase()) || domainName.toLowerCase().includes(search.toLowerCase())">
                        <td class="py-2 px-4 border-b" style="width: 10%;" >{{ $url->domain->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $url->url }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-2 px-4 border-b">No URLs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            <p>&nbsp;</p>
            <a href="{{ $urls->previousPageUrl() }}" rel="prev">Previous</a>
            @foreach(range(1, $urls->lastPage()) as $i)
                @if($i == $urls->currentPage())
                    <span>{{ $i }}</span>
                @else
                    <a href="{{ $urls->url($i) }}">{{ $i }}</a>
                @endif
            @endforeach
            <a href="{{ $urls->nextPageUrl() }}" rel="next">Next</a>
        </div>

        <!-- <div class="mt-4">
            {{ $urls->appends(['search' => $search])->links() }}
        </div> -->
    </div>
</div>
@endsection

