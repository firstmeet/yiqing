<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use App\Yiqing;
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
        $body = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?&currentPageNo=1&pageSize=1");
        $body = json_decode($body, true);
        $total = $body['data']['total'];
        $body1 = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?currentPageNo=1&pageSize=" . $total);
        $body1 = json_decode($body1, true);
        $data = collect($body1['data']['rows']);
        $len=count($data);
        $len_data=Yiqing::count();
        if ($len>$len_data){
            $slice = $data->slice(0,$len-$len_data);
           foreach ($slice->all() as $key=>$v){
                   Yiqing::create($v);
           }
        }
    }
}
