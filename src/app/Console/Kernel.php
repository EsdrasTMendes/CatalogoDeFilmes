<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\TestTmdbApi::class,
        // Adicione outros comandos personalizados aqui
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Agenda de tarefas (não precisa usar por enquanto)
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
