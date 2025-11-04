<form wire:submit.prevent="submit" class="space-y-6">

    <div class="grid grid-cols-1 gap-6">
        {{ $this->form }}
    </div>

    <button
        type="submit"
        class="w-full py-4 text-lg rounded-xl font-bold text-white
               bg-gradient-to-r from-indigo-600 to-blue-500
               hover:from-indigo-700 hover:to-blue-600
               shadow-lg hover:shadow-xl transition-all"
    >
        Найти билеты
    </button>
</form>
