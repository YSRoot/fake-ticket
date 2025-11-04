<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

        <a href="/" class="flex items-center gap-2 font-bold text-xl text-indigo-600">
            <img src="{!! asset('images/logo.png') !!}" class="h-20" alt="Logo">
            {{ config('app.name') }}
        </a>

        <nav class="flex items-center gap-6 text-gray-600 font-medium">
            <a href="/" class="hover:text-indigo-600 transition">Авиабилеты</a>
            <a href="#" class="hover:text-indigo-600 transition">Отели</a>
            <a href="#" class="hover:text-indigo-600 transition">Поддержка</a>
        </nav>
    </div>
</header>
