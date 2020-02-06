<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Document</title>
    <style>
        .test{
            display: flex;
            flex-direction: row;
        }
        .table>tbody>tr>td{
            white-space:nowrap;
        }
    </style>
</head>
<body>
<div>
    <form role="form" class="form-inline">
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label" style="line-height: 34px">姓名</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" value="{{request('name')}}" placeholder="请输入姓名">
            </div>
        </div>
        <div class="form-group">
            <label for="id_card" class="col-sm-4 control-label" style="line-height: 34px">身份证号</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="id_card" value="{{request('id_card')}}" placeholder="请输入身份证号">
            </div>
        </div>
        <div class="form-group">
            <label for="areas" class="col-sm-4 control-label" style="line-height: 34px">来淮南入住县/区</label>
            <div class=" col-sm-8">
                <select name="areas" id="areas" class="form-control">
                    <option value>请选择...</option>
                    <option value="寿县">寿县</option>
                    <option value="凤台县">凤台县</option>
                    <option value="大通区">大通区</option>
                    <option value="田家庵区">田家庵区</option>
                    <option value="谢家集区">谢家集区</option>
                    <option value="八公山区">八公山区</option>
                    <option value="潘集区">潘集区</option>
                    <option value="淮南市毛集社会发展综合实验区">淮南市毛集社会发展综合实验区</option>
                    <option value="淮南经济技术开发区">淮南经济技术开发区</option>
                    <option value="淮南高新区管委会">淮南高新区管委会</option>
                    <option value="淮南新桥国际产业园">淮南新桥国际产业园</option>
                </select>
            </div>

        </div>
        <button type="button" class="btn btn-primary search">查询</button>
        <button type="button" class="btn btn-danger reset">重置</button>
        <button type="button" class="btn btn-default export">导出</button>
    </form>
</div>

<div class="table-responsive">

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
        @empty($list['data']['rows'])
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
                <td>{{$value['createTime']}}</td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>
<div class="test">
    @if(!empty($list['data']['rows']))
        <ul class="pagination pagination-lg" >
            <li class="{{request('page',1)==1?"disabled":""}}"><a href="?name={{request('name')}}&id_card={{request('id_card')}}&areas={{request('areas')}}&page={{request('page')-1}}&pageSize={{request('pageSize')}}"  >&laquo;</a></li>
            @for($i=1;$i<=$list['data']['pages'];$i++)
                <li><a href="?name={{request('name')}}&id_card={{request('id_card')}}&areas={{request('areas')}}&page={{$i}}&pageSize={{request('pageSize')}}">{{$i}}</a></li>
            @endfor
            <li class="{{request('page',1)==$list['data']['pages']?"disabled":""}}"><a href="?name={{request('name')}}&id_card={{request('id_card')}}&areas={{request('areas')}}&page={{request('page')+1}}&pageSize={{request('pageSize')}}"  >&raquo;</a></li>
        </ul>
        <ul class="pagination pagination-lg" >
          <li>
              <select name="pageSize"  id="pageSize" class="form-control pageSize" style="height: 46px">
                  <option value>请选择条目</option>
                  <option value="10" @if(request('pageSize')==10) selected @endif>10</option>
                  <option value="20" @if(request('pageSize')==20) selected @endif>20</option>
                  <option value="50" @if(request('pageSize')==50) selected @endif>50</option>
                  <option value="100" @if(request('pageSize')==100) selected @endif>100</option>
                  <option value="500" @if(request('pageSize')==500) selected @endif>500</option>
              </select></li>
        </ul>
    @endif
</div>

<script>
   $(".search").click(function () {
       var name=$("#name").val()
       var id_card=$("#id_card").val()
       var areas=$("#areas").val()
       window.location.href="?name="+name+"&id_card="+id_card+"&areas="+areas
   })
   $(".export").click(function () {
       var name=$("#name").val()
       var id_card=$("#id_card").val()
       var areas=$("#areas").val()

       window.location.href="admin/download?name="+name+"&id_card="+id_card+"&areas="+areas
   })
   $(".reset").click(function () {
       window.location.href="?name=&id_card=&areas="
   })
    $(".disabled").click(function () {
        return false
    })
    $(".pageSize").change(function () {
        var name=$("#name").val()
        var id_card=$("#id_card").val()
        var areas=$("#areas").val()
        window.location.href="?name="+name+"&id_card="+id_card+"&areas="+areas+"&pageSize="+$(".pageSize").val()
    })
</script>
</body>
</html>
