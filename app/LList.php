<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LList extends Model
{
    public function paginate()
    {
        $perPage = Request::get('per_page', 10);

        $page = Request::get('page', 1);

        $start = ($page-1)*$perPage;

        $id_card=request('id_card',null);
        $name=request('name',null);
        $areas=request('areas',null);
        $name=urlencode(trim($name));
        $id_card=urlencode(trim($id_card));
        $areas=urlencode(trim($areas));
        $body=file_get_contents("http://112.29.244.243:9999/yiqing-register/register/querySomth?idCard=".$id_card."&name=".$name."&areas=".$areas);

        $data = json_decode($data, true);


        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }

    // 覆盖`orderBy`来收集排序的字段和方向
    public function orderBy($column, $direction = 'asc')
    {

    }

    // 覆盖`where`来收集筛选的字段和条件
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {

    }

}
