<footer class="relative mt-24">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 py-12 text-sm text-gray-600">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-8">

            {{-- Left block --}}
            <div class="max-w-md">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    FakeTicket
                </h3>
                <p class="leading-relaxed">
                    Реалистичные авиабилеты для путешествий, подачи на визу и других задач.
                    Не является сервисом продажи авиабилетов.
                </p>
            </div>

            {{-- Right block: two-row navigation --}}
            <div class="flex flex-col text-gray-600 font-medium md:text-right">

                <div class="flex flex-wrap gap-x-8 gap-y-2 justify-start md:justify-end mb-2">
                    <a href="{{ route('privacy') }}" class="hover:text-gray-900">Политика конфиденциальности</a>
                    <a href="{{ route('terms') }}" class="hover:text-gray-900">Условия использования</a>
                </div>

                <div class="flex flex-wrap gap-x-8 gap-y-2 justify-start md:justify-end">
                    <a href="{{ route('faq') }}" class="hover:text-gray-900">FAQ</a>
                    <a href="{{ route('contacts') }}" class="hover:text-gray-900">Контакты</a>
                    <a href="mailto:support@faketicket.com" class="hover:text-gray-900">Поддержка</a>
                </div>
            </div>
        </div>

        {{-- bottom strip --}}
        <div class="mt-10 pt-6 border-t border-gray-200 text-xs text-gray-400">
            © {{ date('Y') }} FakeTicket. Все права защищены.
        </div>
    </div>
</footer>
