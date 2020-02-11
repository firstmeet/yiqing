<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email_export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'email_export';

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
     * @return mixed
     */
    public function handle()
    {
      return  \Maatwebsite\Excel\Facades\Excel::store(new \App\Exports\EmailExport(),date('Ymd').'_export.xlsx');
    }
}
