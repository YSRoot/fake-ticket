<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200"
>
    <div class="max-w-7xl mx-auto flex items-center justify-between py-2 px-4">

        <a href="/" class="flex items-center gap-2 font-bold text-lg sm:text-xl text-indigo-600">
            <img src="{{ asset('images/logo.png') }}" class="h-8 sm:h-10" alt="Logo">

            <!-- Показываем название везде, но меньше на мобиле -->
            <span class="text-base sm:text-xl leading-tight">
                {{ config('app.name') }}
            </span>
        </a>

        <!-- Desktop nav -->
        <nav class="hidden md:flex items-center gap-6 text-gray-600 font-medium">
            <a href="/" class="hover:text-indigo-600 transition">Авиабилеты</a>
            <a href="#" class="hover:text-indigo-600 transition">Отели</a>
            <a href="#" class="hover:text-indigo-600 transition">Поддержка</a>
        </nav>

        <!-- Mobile menu button -->
        <button
            class="md:hidden text-indigo-600 text-3xl"
            @click="open = !open"
        >
            <span x-show="!open">☰</span>
            <span x-show="open">✕</span>
        </button>
    </div>

    <!-- Mobile nav -->
    <nav
        class="md:hidden flex flex-col gap-3 bg-white/95 backdrop-blur p-4 border-t text-gray-700 font-medium"
        x-show="open"
        x-transition
        @click.away="open = false"
    >
        <a href="/" class="hover:text-indigo-600 transition">Авиабилеты</a>
        <a href="#" class="hover:text-indigo-600 transition">Отели</a>
        <a href="#" class="hover:text-indigo-600 transition">Поддержка</a>
    </nav>
</header>
