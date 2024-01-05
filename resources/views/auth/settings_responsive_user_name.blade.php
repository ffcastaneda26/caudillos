<div class="flex items-center px-4">

    <div class="shrink-0 mr-3">
        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
            alt="{{ Auth::user()->name }}" />
    </div>

    <div>
        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
    </div>
</div>
