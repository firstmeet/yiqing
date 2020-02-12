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
    <script src="/js/vue.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/moment.js/2.22.1/moment-with-locales.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.js"></script>
    <title>Document</title>
    <style>
        .test{
            display: flex;
            flex-direction: row;
        }
        .table>tbody>tr>td{
            white-space:nowrap;
        }
        [v-cloak]{
            display: none;
        }
    </style>
</head>
<body>
<div id="loading"></div>
<div id="app" v-cloak>
    <form role="form" class="form-inline">
        <div class="form-group">
            <label for="datetime" class="col-sm-4 control-label" style="line-height: 34px">选择日期</label>
            <div class="col-sm-8">
                <input type="text"  value="" class="form-control" id="datetime" />
            </div>
        </div>
        <button type="button" class="btn btn-primary search" @click="search">查询</button>
        <button type="button" class="btn btn-danger" @click="reset">重置</button>
        <button type="button" class="btn btn-default export_2">导出统计数据</button>
    </form>
</div>

<div class="table-responsive">

    <table class="table">
        <caption>统计</caption>
        <thead>
        <tr>
            <th>县/区</th>
            <th>当日总人数</th>
            <th>发热情况人数</th>
            <th>存在与湖北地区或病毒接触情况人数</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(item,index) in list">
            <td>@{{item.id}}</td>
            <td>@{{item['number']}}</td>
            <td>@{{item['fever']}}</td>
            <td>@{{item['contact_hb']}}</td>
        </tr>



        </tbody>
    </table>
</div>

<script>

    var vm=new Vue({
        el:"#app",
        data:{
            name:'',
            id_card:'',
            areas:'',
            list:[],
            total:0,
            pages:0,
            current:1,
            pageSize:10,
            datetime:''
        },
        mounted(){

            this.getList()
        },
        watch:{
            pageSize:function (val) {
                this.getList(this.time)
            },
            datetime:function (val) {
                console.log(val)
            }
        },
        methods:{
            getList:function (time) {
                $("#loading").busyLoad("show",{
                    background: "rgba(255, 152, 0, 0.86)",
                    spinner: "cube",
                    animation: "slide"
                });
                var _this=this
                $.post("/admin/tongji",{'time':time},function (res){
                    _this.list=res
                    $("#loading").busyLoad("hide")

                })
            },
            search:function () {
                var time=$("#datetime").val()
                this.time=time
                this.getList(time)
            },
            reset:function () {
                this.name=""
                this.id_card=""
                this.areas=""
                this.datetime=""
                this.getList()
            },
            getMan(cur){
                this.getList(this.name,this.id_card,this.areas,cur,this.pageSize)
            }
        },
        filters:{
            "f1":function (item) {
                if(item==0){
                    return "无"
                }
                if(item==null){
                    return "无"
                }
                return "有"
            },
            "ftime":function (item) {
                console.log(new Date(item))
            }
        },
    })
    $(".export").click(function () {
        var name=$("#name").val()
        var id_card=$("#id_card").val()
        var areas=$("#areas").val()

        window.location.href="admin/download?name="+name+"&id_card="+id_card+"&areas="+areas
    })
    $(".export_2").click(function () {
        var name=$("#name").val()
        var id_card=$("#id_card").val()
        var areas=$("#areas").val()
        var time=$("#datetime").val()

        window.location.href="download_template?name="+name+"&id_card="+id_card+"&areas="+areas+"&time="+time
    })
    $(".disabled").click(function () {
        return false
    })
    $("#datetime").datetimepicker(
        {
            format: 'YYYY-MM-DD',
        }
    );
    $("#datetime").on("change.datetimepicker", function (e) {
        if (e.oldDate !== e.date) {
            alert('You picked: ' + new Date(e.date).toLocaleDateString('en-US'))
        }
    })
    $("#datetime").change(function (val) {
        console.log(val)
    })
</script>
</body>
</html>
