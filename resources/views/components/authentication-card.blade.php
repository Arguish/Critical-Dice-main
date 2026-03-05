<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary-900">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-primary-800 border-2 border-accent-orange shadow-xl overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>