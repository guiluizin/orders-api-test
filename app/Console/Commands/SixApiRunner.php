<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SixApiRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'six:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read Six API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->handleConnection();
    }

    private function handleConnection() {

        // try {

        //     $request = Http::timeout(30)
        //         ->get('https://dev-crm.ogruposix.com/candidato-teste-pratico-backend/dashboard/test-orders');

            
        // } catch
        
        
    }
}
