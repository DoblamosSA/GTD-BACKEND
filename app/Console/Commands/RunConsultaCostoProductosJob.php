<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ConsultaCostoProductosJob;

class RunConsultaCostoProductosJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:consulta-costos'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the ConsultaCostoProductosJob';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Dispatch the job
        dispatch(new ConsultaCostoProductosJob());

        return 0;
    }
}
