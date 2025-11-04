<?php

use App\Livewire\PublicTicketForm;
use App\Livewire\TicketPassengersForm;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicTicketForm::class)->name('ticket.form');
Route::get('/ticket/passengers', TicketPassengersForm::class)->name('ticket.passengers');


Route::redirect('privacy', '/')->name('privacy');
Route::redirect('terms', '/')->name('terms');
Route::redirect('faq', '/')->name('faq');
Route::redirect('contacts', '/')->name('contacts');
