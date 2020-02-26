<?php

namespace App\Admin\Controllers;

use App\Exports\EmailExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Yiqing;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $content=new Content();
        var_dump(\session('url'));
        return $content->view('admin.man_list');
    }
    public function tongji_ui()
    {
        $content=new Content();

        return $content->view('admin.tongji');
    }
    public function tongji()
    {
        $id_card = request('id_card', null);
        $name = request('name', null);
        $areas = request('areas', null);
        $name = urlencode(trim($name));
        $id_card = urlencode(trim($id_card));
        $areas = urlencode(trim($areas));
        $body = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=" . $id_card . "&name=" . $name . "&areas=" . $areas . "&currentPageNo=" . request('page', 1) . "&pageSize=" . request('pageSize', 1));
        $body = json_decode($body, true);
        $total = $body['data']['total'];
        $body1 = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=" . $id_card . "&name=" . $name . "&areas=" . $areas . "&currentPageNo=" . request('page', 1) . "&pageSize=" . $total);
        $body1 = json_decode($body1, true);
        $data = collect($body1['data']['rows']);
        $time=\request('time',date('Y-m-d',time()));

        $data=$data->filter(function ($value,$key)use ($time){
            $create_time=date('Y-m-d',strtotime($value['createTime']));
            return strtotime($create_time)==strtotime($time);
        });
        $data = $data->all();

        $body1['data']['rows'] = $data;
        $areas_str = "田家庵区
大通区
淮南经济技术开发区
淮南高新区管委会
潘集区
谢家集区
八公山区
凤台县
寿县
淮南市毛集社会发展综合实验区
淮南新桥国际产业园
其他
";
        $areas_list = explode("\n", $areas_str);

        $areas_list = array_filter($areas_list);
        $arr = [];
        foreach ($areas_list as $key => $value) {
            $arr[$key]['id'] = $value;
            $arr[$key]['fever'] = 0;
            $arr[$key]['contact_hb'] = 0;
            $arr[$key]['number'] = 0;
        }
        foreach ($body1['data']['rows'] as $key=>$value){
            $flag=false;
            foreach ($arr as $key1=>$value1){
                if (mb_strpos($value['areas'],$value1['id'])===0){
                    $flag=true;
                    $arr[$key1]['number']+=1;
                    if ($value['isFever']){
                        $arr[$key1]['fever']+=1;
                    }
                    if ($value['isContactHb']){
                        $arr[$key1]['contact_hb']+=1;
                    }
                    if ($value['isContactFy']){
                        $arr[$key1]['contact_hb']+=1;
                    }
                }
            }
            if (!$flag){
                $arr[11]['number']++;
                if ($value['isFever']){
                    $arr[11]['fever']+=1;
                }
                if ($value['isContactHb']){
                    $arr[11]['contact_hb']+=1;
                }
                if ($value['isContactFy']){
                    $arr[11]['contact_hb']+=1;
                }
            }
        }
        $arr_total=["id"=>"总计",'number'=>0,'fever'=>0,'contact_hb'=>0];
        foreach ($arr as $key=>$value){
            $arr_total['number']+=$value['number'];
            $arr_total['fever']+=$value['fever'];
            $arr_total['contact_hb']+=$value['contact_hb'];
        }
        array_push($arr,$arr_total);
        return response()->json($arr);
    }
    public function download()
    {
        set_time_limit(0);
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
         Excel::store(new UsersExport(),'public/'.date('Ymd').'.xlsx');
        session()->flash('url','storage/'.date('Ymd').'.xlsx');
        dd(Session::get('url'));
        return back()->with("Success");
    }
    public function getList(Request $request)
    {
        $id_card=request('id_card',null);
        $name=request('name',null);
        $areas=request('areas',null);
        $name=urlencode(trim($name));
        $id_card=urlencode(trim($id_card));
        $areas=urlencode(trim($areas));
        $body1=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card."&name=".$name."&areas=".$areas."&currentPageNo=".request('page',1)."&pageSize=".\request('pageSize',10));
        $body1=json_decode($body1,true);
        return response()->json($body1);

    }
    public function test()
    {
        $id_card = request('id_card', null);
        $name = request('name', null);
        $areas = request('areas', null);
        $name = urlencode(trim($name));
        $id_card = urlencode(trim($id_card));
        $areas = urlencode(trim($areas));
        $body = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=" . $id_card . "&name=" . $name . "&areas=" . $areas . "&currentPageNo=" . request('page', 1) . "&pageSize=" . request('pageSize', 1));
        $body = json_decode($body, true);
        $total = $body['data']['total'];
        $body1 = file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=" . $id_card . "&name=" . $name . "&areas=" . $areas . "&currentPageNo=" . request('page', 1) . "&pageSize=" . $total);
        $body1 = json_decode($body1, true);
        $data = collect($body1['data']['rows'])->keyBy("idCard");
        $time=\request('time');
        $data->filter(function ($value,$key)use ($time){
              $create_time=date('Y-m-d',strtotime($value['createTime']));
              return strtotime($create_time)==$time;
        });
        $data = array_values($data->toArray());
        $body1['data']['rows'] = $data;
        $areas_str = "田家庵区
大通区
淮南经济技术开发区
淮南高新区管委会
潘集区
谢家集区
八公山区
凤台县
寿县
淮南市毛集社会发展综合实验区
淮南新桥国际产业园
其他
";
        $areas_list = explode("\n", $areas_str);

        $areas_list = array_filter($areas_list);
        $arr = [];
        foreach ($areas_list as $key => $value) {
            $arr[$key]['id'] = $value;
            $arr[$key]['fever'] = 0;
            $arr[$key]['contact_hb'] = 0;
            $arr[$key]['number'] = 0;
        }
        foreach ($body1['data']['rows'] as $key=>$value){
            $flag=false;
            foreach ($arr as $key1=>$value1){
                    if (mb_strpos($value['areas'],$value1['id'])===0){
                        $flag=true;
                        $arr[$key1]['number']+=1;
                        if ($value['isFever']){
                            $arr[$key1]['fever']+=1;
                        }
                        if ($value['isContactHb']){
                            $arr[$key1]['contact_hb']+=1;
                        }
                        if ($value['isContactFy']){
                            $arr[$key1]['contact_hb']+=1;
                        }
                    }
                }
            if (!$flag){
                $arr[11]['number']++;
                if ($value['isFever']){
                    $arr[11]['fever']+=1;
                }
                if ($value['isContactHb']){
                    $arr[11]['contact_hb']+=1;
                }
                if ($value['isContactFy']){
                    $arr[11]['contact_hb']+=1;
                }
            }
        }
        $arr_total=["id"=>"总计",'number'=>0,'fever'=>0,'contact_hb'=>0];
        foreach ($arr as $key=>$value){
            $arr_total['number']+=$value['number'];
            $arr_total['fever']+=$value['fever'];
            $arr_total['contact_hb']+=$value['contact_hb'];
        }
        array_push($arr,$arr_total);
        dd($arr);
    }
    public function download_template()
    {
        $time=\request('time',date('Y-m-d',time()));
        return Excel::download(new EmailExport($time),date('Ymd').'_export.xlsx');
    }

}
