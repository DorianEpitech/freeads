<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
        @foreach($adds as $add)
            <div class="border p-4">
                <h2 class="font-bold text-lg">{{ $add->title }}</h2>
                <p class="text-gray-600">{{ $add->description }}</p>
                <p class="font-bold">{{ $add->price }} €</p>
                @if ($add->picture)
                    @if (strpos($add->picture, '-') !== false)
                        <?php $pictures = explode('-', $add->picture); ?>
                        <div class="flex" style="flex-wrap: wrap;">
                            @foreach ($pictures as $picture)
                                <img style="max-height: 400px; max-width: 400px;"  src="{{ asset('storage/images/' . $picture) }}" alt="{{ $add->title }}" class="mt-4">
                            @endforeach
                        </div>
                    @else
                        <img style="max-height: 400px; max-width: 400px;" src="{{ asset('storage/images/' . $add->picture) }}" alt="{{ $add->title }}" class="mt-4">
                    @endif
                @endif
                <div style="gap: 10px" class="mt-4 flex">
                    <form action="{{ route('editadd', ['id' => $add->id]) }}" method="GET" class="inline-block">
                        @csrf
                        <button type="post" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Edit</button>
                    </form>
                    <form action="{{ route('deleteadd', $add->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-white focus:bg-red-700 dark:focus:bg-white active:bg-red-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>