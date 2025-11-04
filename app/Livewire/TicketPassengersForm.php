<?php

namespace App\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanOpenModal;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
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

    public function mount(): ?RedirectResponse
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
                Forms\Components\Repeater::make('passengers')
                    ->label('Пассажиры')
                    ->itemNumbers()
                    ->itemLabel('Пассажир')
                    ->schema([
                        Section::make()
                            ->icon(Heroicon::OutlinedUser)
                            ->description('Введите данные пассажира для оформления билета')
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
                            ->collapsible(false)
                            ->compact()
                        ,
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
                        ->icon(Heroicon::UserMinus)
                        ->requiresConfirmation()
                        ->modalHeading('Удалить пассажира?')
                        ->modalDescription('Вы уверены, что хотите удалить этого пассажира?')
                        ->modalSubmitActionLabel('Удалить')
                        ->modalCancelActionLabel('Отмена')
                    )
                    ->columnSpanFull(),
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
