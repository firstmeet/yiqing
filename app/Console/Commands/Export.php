<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export';

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
        $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?currentPageNo=".request('page',1)."&pageSize=".request('pageSize',1));
        $body=json_decode($body,true);
        $total=$body['data']['total'];
        $size=ceil($total/10000);
        for ($i=1;$i<=$size;$i++){
            Excel::store(new UsersExport($size),date('Ymd').'_'.$size.'.xlsx');
        }
    }
}
