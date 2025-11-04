<?php

namespace App\Livewire;

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
final class PublicTicketForm extends Component implements HasForms
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
                            Forms\Components\TextInput::make('from')
                                ->label('Откуда')
                                ->placeholder('Москва (SVO)')
                                ->required()
                                ->prefixIcon('heroicon-o-paper-airplane'),

                            Forms\Components\TextInput::make('to')
                                ->label('Куда')
                                ->placeholder('Стамбул (IST)')
                                ->required()
                                ->prefixIcon('heroicon-o-paper-airplane'),
                        ]),

                    Grid::make(3)
                        ->schema([
                            Forms\Components\DatePicker::make('date_from')
                                ->label('Дата вылета')
                                ->required(),

                            Forms\Components\DatePicker::make('date_to')
                                ->label('Дата обратно')
                                ->hidden(fn ($get) => $get('trip_type') === 'one_way'),

                            Forms\Components\TextInput::make('passengers')
                                ->label('Пассажиров')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->maxValue(6)
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

        return redirect('/ticket/passengers');
    }

    public function render(): View
    {
        return view('livewire.public-ticket-form');
    }
}
