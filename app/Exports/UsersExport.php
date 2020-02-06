<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        $id_card=request('id_card',null);
        $name=request('name',null);
        $name=urlencode(trim($name));
        $id_card=urlencode(trim($id_card));
        if ($id_card&&$name){
            $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card."&name=".$name);
        }elseif ($id_card){

            $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card);
        }elseif ($name){
            $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?name=".$name);
        }else{
            $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=&name=");
        }

        $body=json_decode($body,true);
        return view('admin.export', [
            'list' => $body
        ]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $id_card=request('id_card',null);
        $name=request('name',null);
        $areas=request('areas',null);
        $name=urlencode(trim($name));
        $id_card=urlencode(trim($id_card));
        $areas=urlencode(trim($areas));
        $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card."&name=".$name."&areas=".$areas);

        $body=json_decode($body,true);
        $body=collect($body['data']['rows']);
    }
}
