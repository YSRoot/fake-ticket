<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2 text-center">Данные пассажиров ✈️</h1>
    <p class="text-gray-500 text-center mb-10">Заполните информацию для каждого пассажира</p>

    <x-filament-actions::modals />

    <form wire:submit.prevent="submit" class="space-y-8">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            class="w-full py-4 rounded-xl font-semibold text-lg text-white
                       bg-gradient-to-r from-indigo-600 to-purple-600
                       hover:from-indigo-700 hover:to-purple-700 transition shadow-lg
                       flex justify-center"
            wire:loading.attr="disabled"
        >
            Продолжить →
        </x-filament::button>
    </form>
</div>
