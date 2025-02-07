<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

Artisan::command('schedule:run-register', function (Schedule $schedule) {
    // Agendar o comando collection:run a cada 15 minutos
    // $schedule->command('collection:run')->everyMinute(); //->everyFifteenMinutes();
})->purpose('Executa a coleta de dados de ONUs gerados pelo export do DMView Datacom.');
