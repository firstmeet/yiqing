<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table>tbody>tr>td{
            white-space:nowrap;
        }
    </style>
</head>
<body>
<table class="table">
    <caption>填报列表</caption>
    <thead>
    <tr>
        <th>姓名</th>
        <th>是否本人</th>
        <th>与填报者关系</th>
        <th>身份证号</th>
        <th>联系方式</th>
        <th>来源地区</th>
        <th>抵淮南时间</th>
        <th>来淮南入住县/区</th>
        <th>来淮南前居住地点</th>
        <th>来淮南前居住具体地址</th>
        <th>来淮南拟入住地址</th>
        <th>来淮南拟入住具体地址</th>
        <th>车牌号码</th>
        <th>在淮南工作单位名称</th>
        <th>湖北地区旅游史</th>
        <th>与湖北地区人员接触史</th>
        <th>新型冠状病毒感染的肺炎病例接触史</th>
        <th>创建时间</th>
    </tr>
    </thead>
    <tbody>
    @empty($list['data'])
        <td>无</td>
    @endempty
    @foreach($list['data']['rows'] as $key=>$value)
        <tr>
            <td>{{$value['name']}}</td>
            <td>{{$value['isSelf']}}</td>
            <td>{{$value['relation']}}</td>
            <td>{{$value['idCard']}}</td>
            <td>{{$value['mobile']}}</td>
            <td>{{$value['fromWhere']}}</td>
            <td>{{$value['arrivalTime']}}</td>
            <td>{{$value['areas']}}</td>
            <td>{{$value['beforeLocat']}}</td>
            <td>{{$value['beforeLocatAddr']}}</td>
            <td>{{$value['nowLocat']}}</td>
            <td>{{$value['nowLocatAddr']}}</td>
            <td>{{$value['carNum']}}</td>
            <td>{{$value['companyName']}}</td>
            <td>{!! $value['isToHubei']?"有":"无" !!}</td>
            <td>{!! $value['isContactHb']?"有":"无" !!}</td>
            <td>{!! $value['isContactFy']?"有":"无" !!}</td>
            <td>{!! date('Y-m-d H:i:s',strtotime($value['createTime'])) !!}</td>
        </tr>

    @endforeach

    </tbody>
</table>
</body>
</html>
