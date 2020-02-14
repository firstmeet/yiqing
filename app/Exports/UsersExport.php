<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class UsersExport extends StringValueBinder implements FromView,ShouldAutoSize,WithCustomValueBinder,ShouldQueue
{
    use Exportable;
    public $timeout=120;
    public $size=1;
    public function __construct($size=1)
    {
        $this->size=$size;
    }

    public function view(): View
    {
        $body1=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?currentPageNo=".$this->size."&pageSize=10000");
        $body1=json_decode($body1,true);
        return view('admin.export', [
            'list' => $body1
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
