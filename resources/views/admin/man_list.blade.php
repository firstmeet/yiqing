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
    <script src="/js/extendPagination.js"></script>
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
{{--        <div class="form-group">--}}
{{--            <label for="name" class="col-sm-3 control-label" style="line-height: 34px">姓名</label>--}}
{{--            <div class="col-sm-9">--}}
{{--                <input type="text" class="form-control" id="name" v-model="name" placeholder="请输入姓名">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="id_card" class="col-sm-4 control-label" style="line-height: 34px">身份证号</label>--}}
{{--            <div class="col-sm-8">--}}
{{--                <input type="text" class="form-control" id="id_card" v-model="id_card" placeholder="请输入身份证号">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="areas" class="col-sm-4 control-label" style="line-height: 34px">来淮南入住县/区</label>--}}
{{--            <div class="col-sm-8">--}}
{{--                <select name="areas" id="areas" v-model="areas" class="form-control">--}}
{{--                    <option value>请选择...</option>--}}
{{--                    <option value="寿县">寿县</option>--}}
{{--                    <option value="凤台县">凤台县</option>--}}
{{--                    <option value="大通区">大通区</option>--}}
{{--                    <option value="田家庵区">田家庵区</option>--}}
{{--                    <option value="谢家集区">谢家集区</option>--}}
{{--                    <option value="八公山区">八公山区</option>--}}
{{--                    <option value="潘集区">潘集区</option>--}}
{{--                    <option value="淮南市毛集社会发展综合实验区">淮南市毛集社会发展综合实验区</option>--}}
{{--                    <option value="淮南经济技术开发区">淮南经济技术开发区</option>--}}
{{--                    <option value="淮南高新区管委会">淮南高新区管委会</option>--}}
{{--                    <option value="淮南新桥国际产业园">淮南新桥国际产业园</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group">
            <label for="datetime" class="col-sm-4 control-label" style="line-height: 34px">选择日期</label>
            <div class="col-sm-8">
                <input type="text"  v-model="datetime" class="form-control" id="datetime" />
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
{{--<div class="test">--}}
{{--    <navigation :pages="pages" :current.sync="current" @navpage="getMan" ></navigation>--}}
{{--    <ul class="pagination pagination-lg" >--}}
{{--        <li>--}}
{{--            <select name="pageSize"  class="form-control pageSize" v-model="pageSize" style="height: 46px">--}}
{{--                <option value="10">10</option>--}}
{{--                <option value="20" >20</option>--}}
{{--                <option value="50" >50</option>--}}
{{--                <option value="100">100</option>--}}
{{--                <option value="500">500</option>--}}
{{--            </select></li>--}}
{{--    </ul>--}}
{{--</div>--}}

<script>
    // var pageComponent = Vue.extend({
    //     template: `<nav aria-label="Page navigation">
    //     <ul class="pagination pagination-lg" style="float: left">
    //         <li :class="{\'disabled\':curPage==1}">
    //             <a href="javascript:;" @click="goPage(curPage==1?1:curPage-1)" aria-label="Previous">
    //                 <span aria-hidden="true">&laquo;</span>
    //             </a>
    //         </li>
    //         <li v-for="page in showPageBtn" :class="{\'active\':page==curPage}">
    //             <a href="javascript:;" v-if="page" @click="goPage(page)">@{{page}}</a>
    //             <a href="javascript:;" v-else>...</a>
    //         </li>
    //         <li :class="{\'disabled\':curPage==pages}">
    //             <a href="javascript:;" @click="goPage(curPage==pages?pages:curPage+1)" aria-label="Next">
    //                 <span aria-hidden="true">&raquo;</span>
    //             </a>
    //         </li>
    //     </ul>
    // </nav>`,
    //     props: {
    //         pages: {
    //             type: Number,
    //             default: 1
    //         },
    //         current: {
    //             type: Number,
    //             default: 1
    //         }
    //     },
    //     data(){
    //         return{
    //             curPage:1
    //         }
    //     },
    //     computed: {
    //         showPageBtn() {
    //             let pageNum = this.pages;
    //             let index = this.curPage;
    //             let arr = [];
    //             if (pageNum <= 5) {
    //                 for (let i = 1; i <= pageNum; i++) {
    //                     arr.push(i)
    //                 }
    //                 return arr
    //             }
    //             if (index <= 2) return [1, 2, 3, 0, pageNum];
    //             if (index >= pageNum - 1) return [1, 0, pageNum - 2, pageNum - 1, pageNum];
    //             if (index === 3) return [1, 2, 3, 4, 0, pageNum];
    //             if (index === pageNum - 2) return [1, 0, pageNum - 3, pageNum - 2, pageNum - 1, pageNum];
    //             return [1, 0, index - 1, index, index + 1, 0, pageNum];
    //         }
    //     },
    //     methods: {
    //         goPage(page) {
    //             if (page != this.curPage) {
    //                 this.curPage = page;
    //                 this.$emit('navpage', this.curPage);
    //             }else{
    //             }
    //         }
    //     }
    // });
    // Vue.component('navigation', pageComponent);

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
            $("#loading").busyLoad("show",{
                background: "#000",
                spinner: "cube",
                animation: "slide"
            });
            this.getList()
        },
        watch:{
            pageSize:function (val) {
                this.getList(this.time)
            }
        },
        methods:{
            getList:function (time) {
                var _this=this
                $.post("/admin/getList",{'time':time},function (res){
                    _this.list=res
                    $("#loading").busyLoad("hide")

                })
            },
            search:function () {
                var time=$("#datetime").val()
              this.getList(time)
            },
            reset:function () {
              this.name=""
                this.id_card=""
                this.areas=""
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

        window.location.href="admin/download_template?name="+name+"&id_card="+id_card+"&areas="+areas+"&time="+time
    })
    $(".disabled").click(function () {
        return false
    })
    $("#datetime").datetimepicker({format: 'YYYY-MM-DD'}

    );
</script>
</body>
</html>
