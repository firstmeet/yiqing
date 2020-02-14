<?php

namespace App\Exports;

use App\Yiqing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class UsersExport extends StringValueBinder implements FromQuery,WithHeadings,ShouldQueue,WithCustomChunkSize
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
      return Yiqing::query()->select('name','idCard','mobile','isSelf','relation','arrivalTime','fromWhere','areas','nowLocatAddr','carNum','companyName','isToHubei','isContactHb','isContactFy','createTime')->orderBy('createTime','desc');
    }
    public function headings(): array
    {
        return [
           "姓名",
            "身份证",
            "手机号",
            "是否本人",
            "与填报者关系",
            "抵淮南时间",
            "来源地区",
            "来淮南入住县/区",
            "来淮南拟入住具体地址",
            "车牌号",
            "在淮南工作单位名称",
            "湖北地区旅游史",
            "与湖北地区人员接触史",
            "新型冠状病毒感染的肺炎病例接触史",
            "创建时间"
        ];
    }
    public function chunkSize(): int
    {
       return 10000;
    }
}
