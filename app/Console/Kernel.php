<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $expired = Archive::where('is_deleted', true)
            ->where('deleted_at', '<=', now()->subDays(30))
            ->get();

        foreach ($expired as $item) {
            $storagePath = storage_path('app/public/uploads/' . $item->path);
            if (File::isFile($storagePath)) File::delete($storagePath);
            elseif (File::isDirectory($storagePath)) File::deleteDirectory($storagePath);
            $item->delete();
        }
    })->daily();
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
