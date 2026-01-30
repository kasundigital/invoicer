<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('invoicer:run-recurring', function () {
    $this->comment('Running recurring invoices...');
})->purpose('Generate recurring invoices');

Artisan::command('invoicer:send-reminders', function () {
    $this->comment('Sending invoice reminders...');
})->purpose('Send reminder emails for due/overdue invoices');
