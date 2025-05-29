<?php

// Artisan::command('schedule:run-register', function (Schedule $schedule) {
//     $schedule->command('collection:run')->everyFifteenMinutes();
// })->purpose('Executa a coleta de dados de ONUs gerados pelo export do DMView Datacom.');

use App\Console\Commands\Analytics\Collection;
use Illuminate\Support\Facades\Schedule;

Schedule::command(Collection::class)->everyMinute(); //everyFifteenMinutes();
