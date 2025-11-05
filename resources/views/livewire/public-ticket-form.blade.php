<div>
    @include('components.partials.hero')

    <div class="max-w-4xl mx-auto px-4 pb-24">

        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <form wire:submit.prevent="submit" class="space-y-6">
                {{ $this->form }}

                <x-filament::button
                    type="submit"
                    class="w-full py-4 rounded-xl font-semibold text-lg text-white
                       bg-gradient-to-r from-indigo-600 to-purple-600
                       hover:from-indigo-700 hover:to-purple-700 transition shadow-lg
                       flex justify-center"
                    wire:loading.attr="disabled"
                >
                    Найти билеты ✈️
                </x-filament::button>
            </form>
        </div>
    </div>
</div>
