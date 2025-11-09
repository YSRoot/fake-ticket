<?php

namespace App\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanOpenModal;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

#[Layout('components.layouts.app')]
final class TicketPassengersForm extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;
    use CanOpenModal;

    public array $data = [];

    public function mount(): RedirectResponse|Redirector|null
    {
        if (!session()->has('ticket_form')) {
            return to_route('ticket.form');
        }

        $this->form->fill();

        return null;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(4)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Информация о рейсе')
                                    ->icon(Heroicon::Ticket)
                                    ->description('Здесь будет информация о рейсе')
                                    ->schema([
                                        EmptyState::make('Данные рейса: ')
                                            ->description('Здесь будет информация о рейсе.')
                                            ->icon('gmdi-airplanemode-active')
                                    ]),
                                Section::make('Введите данные пассажира для оформления билета')
                                    ->icon(Heroicon::OutlinedUser)
                                    ->schema([
                                        Forms\Components\Repeater::make('passengers')
                                            ->label('Пассажиры')
                                            ->itemNumbers()
                                            ->itemLabel('Пассажир')
                                            ->schema([
                                                Grid::make()->schema([
                                                    Forms\Components\TextInput::make('first_name')
                                                        ->label('Имя')
                                                        ->default(fake()->firstName())
                                                        ->required(),
                                                    Forms\Components\TextInput::make('last_name')
                                                        ->label('Фамилия')
                                                        ->default(fake()->lastName())
                                                        ->required(),
                                                    Forms\Components\DatePicker::make('birthdate')
                                                        ->label('Дата рождения')
                                                        ->default(fake()->date())
                                                        ->required(),
                                                    Forms\Components\TextInput::make('document')
                                                        ->label('Паспорт')
                                                        ->default(fake()->numerify('#######'))
                                                        ->required(),
                                                ]),
                                            ])
                                            ->defaultItems(fn () => (int) session('ticket_form.passenger_count', 1))
                                            ->minItems(1)
                                            ->columns(1)
                                            ->reorderable(false)
                                            ->addAction(fn(Action $action) => $action
                                                ->label('Добавить пассажира')
                                                ->icon(Heroicon::UserPlus)
                                            )
                                            ->cloneable()
                                            ->deleteAction(fn(Action $action) => $action
                                                ->label('Удалить пассажира')
                                                ->icon(Heroicon::XMark)
                                                ->requiresConfirmation()
                                                ->modalHeading('Удалить пассажира?')
                                                ->modalDescription('Вы уверены, что хотите удалить этого пассажира?')
                                                ->modalSubmitActionLabel('Удалить')
                                                ->modalCancelActionLabel('Отмена')
                                            )
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Контактная информация')
                                    ->aside()
                                    ->icon(Heroicon::EnvelopeOpen)
                                    ->description('На e-mail вышлем маршрут-квитанцию электронного билета после оплаты')
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('E-mail')
                                            ->required()
                                            ->default(fake()->email())
                                            ->email(),
                                    ]),
                            ])
                            ->columnSpan(3),
                        Section::make()
                            ->schema([
                                EmptyState::make('Стоимость')
                                    ->description('Здесь будет итоговая сводка по стоимости.')
                                    ->icon(Heroicon::CurrencyDollar),
                                Forms\Components\Select::make('currency')
                                    ->label('Валюта для квитанции')
                                    ->options([
                                        'rub' => 'Российский рубль - ₽',
                                    ])
                                    ->default('rub')
                                    ->required(),
                                Radio::make('payment_method')
                                    ->options([
                                        'bank_ru'  => 'Банковская карта',
                                        'bank_int' => 'Банковская карта',
                                        'crypt'    => 'Криптовалюта',
                                    ])
                                    ->descriptions([
                                        'bank_ru'  => 'Российский банк',
                                        'bank_int' => 'Международный банк',
                                        'crypt'    => 'USDT, BTC, Binance, Bybit, ...',
                                    ]),
                                Action::make('pay')
                                    ->label('Перейти к оплате')
                                    ->color('primary')
                                    ->icon(Heroicon::DocumentCurrencyPound)
                                    ->size(Size::ExtraLarge)
                                    ->button()
                                    ->extraAttributes(['class' => 'w-full'])
                                    ->slideOver()
                                    ->modalSubmitActionLabel('Оплатить')
                                    ->schema([
                                        EmptyState::make('Форма оплаты')
                                            ->description('Здесь будет форма оплаты выбранным платежным методом.')
                                            ->icon(Heroicon::DocumentCurrencyEuro),
                                    ])
                                    ->action(function () {
                                        $passengerForm = $this->form->getRawState();
                                        session(['passenger_form' => $passengerForm]);

                                        return to_route('ticket.preview');
                                    }),
                            ])
                            ->columnSpan(1),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): Redirector|RedirectResponse
    {
        $state = $this->form->getState();

        session(['ticket_passengers' => $state['passengers']]);

        return to_route('ticket.preview');
    }

    public function render(): View
    {
        return view('livewire.ticket-passengers-form');
    }
}
