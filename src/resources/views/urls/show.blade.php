@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">URLs</div>
            <div class="card-body">
                <div x-data="{ search: '{{ e($search) }}' }" class="container mx-auto p-6">
                    <div class="bg-white rounded shadow-md p-6">

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
                                    <tr >
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
                                    <span style="display: block; padding: 0 5px; border: 1px solid">{{ $i }}</span>
                                @else
                                    <a style="padding: 0 5px; border: 1px dotted" href="{{ $urls->url($i) }}">{{ $i }}</a>
                                @endif
                            @endforeach
                            <a href="{{ $urls->nextPageUrl() }}" rel="next">Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

