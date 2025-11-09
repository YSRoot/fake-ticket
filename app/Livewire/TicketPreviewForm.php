<?php

namespace App\Livewire;

use Spatie\LaravelPdf\Facades\Pdf;

final readonly class TicketPreviewForm
{
    public function __invoke()
    {
        return Pdf::view('templates.confirmation', session()->only(['ticket_form', 'passenger_form']))
            ->format('a4')
            ->margins(20, 20, 20, 20)
            ->name('booking-confirmation.pdf');
    }
}
