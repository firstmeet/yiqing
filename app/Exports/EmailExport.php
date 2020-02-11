<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmailExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    public $time;
    public function __construct($time)
    {
        $this->time=$time;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
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
        $time=$this->time;
        $data=$data->filter(function ($value,$key)use ($time){
            $create_time=date('Y-m-d',strtotime($value['createTime']));
            return strtotime($create_time)==strtotime($time);
        });
        $data = array_values($data->all());
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
            $arr[$key]['number'] = 0;
            $arr[$key]['fever'] = 0;
            $arr[$key]['contact_hb'] = 0;

        }
        foreach ($data as $key=>$value){
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
        return collect($arr);
    }
    public function headings(): array
    {
        return [
            "县/区",
            "当日总人数",
            "发热情况人数",
            "存在与湖北地区或病毒接触情况人数"
        ];
    }
}
