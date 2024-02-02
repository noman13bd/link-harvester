@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">Add URLs</div>
            <div class="card-body"  x-data="{ loading: false, message: '{{ session('message') }}', showToast: false }">
                <div
                    x-show="message"
                    x-text="message" @click.away="showToast = false"
                    x-init="() => { showToast = true; setTimeout(() => showToast = false, 3000) }"
                    x-show.transition="showToast" class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded">
                </div>
                <form @submit.prevent="loading = true; $el.submit()" action="{{ route('urls.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">URLs</label>
                        <div class="col-md-6">
                            <textarea
                            x-bind:disabled="loading"
                            name="urls"
                            id="urls"
                            rows="10"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                            required
                            style="width: 500px; border: 1px solid #ccc; padding: 0.5em; margin:auto; overflow: auto;"
                        ></textarea>
                        @error('urls')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <button
                            x-bind:disabled="loading"
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                            style="background: #c6c6c6; border-radius: 5px; border: 1px solid #aaa; padding: 5px 10px; margin: 10px 0px; font-size: 20px; font-weight: bold;"
                        >
                            <span x-show="!loading">Submit</span>
                            <span x-show="loading">Loading...</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{--

<div x-data="{ loading: false, message: '{{ session('message') }}', showToast: false }" class="container mx-auto p-6">
    <div class="bg-white rounded shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Add URLs</h2>

        <div x-show="message" x-text="message" @click.away="showToast = false" x-init="() => { showToast = true; setTimeout(() => showToast = false, 3000) }" x-show.transition="showToast" class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded"></div>

        <form @submit.prevent="loading = true; $el.submit()" action="{{ route('urls.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="urls" class="block text-sm font-semibold text-gray-600">URLs:</label>
                <textarea
                    x-bind:disabled="loading"
                    name="urls"
                    id="urls"
                    rows="10"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                    required
                    style="width: 500px; border: 1px solid #ccc; padding: 0.5em; margin:auto; overflow: auto;"
                ></textarea>
                @error('urls')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center">
                <button
                    x-bind:disabled="loading"
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                    style="border-radius: 5px; border: 1px solid #aaa; padding: 5px 10px; margin: 10px 0px; font-size: 20px; font-weight: bold;"
                >
                    <span x-show="!loading">Submit</span>
                    <span x-show="loading">Loading...</span>
                </button>
            </div>
        </form>
    </div>
</div> --}}
@endsection
