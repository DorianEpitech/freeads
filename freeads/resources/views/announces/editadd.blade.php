<x-app-layout>
    <div class="border p-4">
        <h2 class="font-bold text-lg">{{ $add->title }}</h2>
        <p class="text-gray-600">{{ $add->description }}</p>
        <p class="font-bold">{{ $add->price }} €</p>
        @if ($add->picture)
            @if (strpos($add->picture, '-') !== false)
                <?php $pictures = explode('-', $add->picture); ?>
                <div class="flex" style="flex-wrap: wrap;">
                    @foreach ($pictures as $picture)
                    <img style="max-height: 400px; max-width: 400px;" src="{{ asset('storage/images/' . $picture) }}" alt="{{ $add->title }}" class="mt-4">
                    @endforeach
                </div>
            @else
                <img style="max-height: 400px; max-width: 400px;" src="{{ asset('storage/images/' . $add->picture) }}" alt="{{ $add->title }}" class="mt-4">
            @endif
        @endif
    </div>
    <x-guest-layout>
        <form method="POST" action="{{ route('updateadd', ['id' => $add->id]) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="add_id" value="{{ $add->id }}">
            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $add->title }}" required autofocus autocomplete="title" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
    
            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $add->description }}" required autocomplete="description" />
            </div>
    
            <!-- Price -->
            <div class="mt-4">
                <x-input-label for="price" :value="__('Price')" />
    
                <x-text-input id="price" class="block mt-1 w-full"
                                type="text"
                                name="price"
                                required autocomplete="price"
                                value="{{ $add->price }}"/>
    
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
    
            <!-- Image -->
            <div class="mt-4">
                <x-input-label for="pictures" :value="__('Pictures')" />
    
                <x-text-input id="pictures" class="block mt-1 w-full"
                                type="file"
                                name="pictures[]"
                                multiple />
    
                <x-input-error :messages="$errors->get('picture')" class="mt-2" />
            </div>
                <br>
                <x-primary-button class="ml-4">
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
    
</x-app-layout>