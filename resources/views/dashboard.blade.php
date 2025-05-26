<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('JepretKu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('snapshots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}">
                        </div>

                        <div>
                            <label for="image">Upload Image:</label>
                            <input type="file" name="image" id="image" required>
                        </div>

                        <button type="submit">Save Snapshot</button>

                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>

                    @foreach ($snapshots as $snapshot)
                        <div class="snapshot-item">
                            <h2>{{ $snapshot->title }}</h2>
                            <img src="{{ route('snapshots.image', $snapshot->id) }}" alt="{{ $snapshot->title }}"
                                class="w-48 h-48 object-cover">
                            <p>{{ $snapshot->data }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
