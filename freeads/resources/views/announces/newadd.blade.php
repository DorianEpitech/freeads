<x-app-layout>
    <div class="mt-10 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
    <form method="POST" action="{{ url('newadd') }}" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autocomplete="description" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />

            <x-text-input id="price" class="block mt-1 w-full"
                            type="text"
                            name="price"
                            required autocomplete="price" />

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
                {{ __('Post') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>
</x-app-layout>
