<?php

namespace App\Livewire;

use App\Airports;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

#[Layout('components.layouts.app')]
final class TicketMainForm extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Forms\Components\Radio::make('trip_type')
                                ->label('Тип поездки')
                                ->inline()
                                ->options([
                                    'one_way' => 'В одну сторону',
                                    'round_trip' => 'Туда-обратно',
                                ])
                                ->default('round_trip')
                                ->reactive(),

                            Forms\Components\Radio::make('class')
                                ->label('Класс')
                                ->options([
                                    'economy' => 'Эконом',
                                    'business' => 'Бизнес',
                                ])
                                ->default('economy')
                                ->inline()
                                ->required(),
                        ]),

                    Grid::make()
                        ->schema([
                            Forms\Components\Select::make('from')
                                ->label('Откуда')
                                ->options(Airports::options())
                                ->default('SVO')
                                ->searchable()
                                ->placeholder('Москва (SVO)')
                                ->required()
                                ->prefixIcon('gmdi-flight-takeoff-r'),

                            Forms\Components\Select::make('to')
                                ->label('Куда')
                                ->options(Airports::options())
                                ->default('IST')
                                ->searchable()
                                ->placeholder('Стамбул (IST)')
                                ->required()
                                ->prefixIcon('gmdi-flight-land-r'),
                        ]),

                    Grid::make(3)
                        ->schema([
                            Forms\Components\DatePicker::make('date_from')
                                ->label('Дата вылета')
                                ->default(now()->format('d.m.Y'))
                                ->required(),

                            Forms\Components\DatePicker::make('date_to')
                                ->label('Дата обратно')
                                ->default(now()->addDay()->format('d.m.Y'))
                                ->hidden(fn ($get) => $get('trip_type') === 'one_way'),

                            Forms\Components\TextInput::make('passenger_count')
                                ->label('Пассажиров')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->maxValue(20)
                                ->required(),
                        ]),
                ])
                ->columnSpan('full')
                ->columns(1)
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function submit(): RedirectResponse|Redirector
    {
        $state = $this->form->getState();
        session(['ticket_form' => $state]);

        return to_route('ticket.passengers');
    }

    public function render(): View
    {
        return view('livewire.public-ticket-form');
    }
}
