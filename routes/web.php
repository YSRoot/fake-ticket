<?php

use App\Livewire\TicketMainForm;
use App\Livewire\TicketPassengersForm;
use App\Livewire\TicketPreviewForm;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ticket')->name('home');
Route::get('/ticket', TicketMainForm::class)->name('ticket.form');
Route::get('/ticket/passengers', TicketPassengersForm::class)->name('ticket.passengers');
Route::get('/ticket/preview', TicketPreviewForm::class)->name('ticket.preview');

Route::redirect('privacy', '/')->name('privacy');
Route::redirect('terms', '/')->name('terms');
Route::redirect('faq', '/')->name('faq');
Route::redirect('contacts', '/')->name('contacts');
