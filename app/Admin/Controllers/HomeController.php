<?php

namespace App\Admin\Controllers;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $content=new Content();

        return $content->view('admin.man_list');
    }
    public function download()
    {
        return Excel::download(new UsersExport(),'list.xlsx');
    }
    public function getList(Request $request)
    {

        $id_card=request('id_card',null);
        $name=request('name',null);
        $areas=request('areas',null);
        $name=urlencode(trim($name));
        $id_card=urlencode(trim($id_card));
        $areas=urlencode(trim($areas));
        $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card."&name=".$name."&areas=".$areas."&currentPageNo=".request('page',1)."&pageSize=".request('pageSize',15));
        $body=json_decode($body,true);
        if (!empty($body['data']['rows'])){
            foreach ($body['data']['rows'] as $key=>$value){
                $value['createTime']=date('Y-m-d H:i:s',strtotime($value['createTime']));
            }
        }
        return response()->json($body);
    }
}
