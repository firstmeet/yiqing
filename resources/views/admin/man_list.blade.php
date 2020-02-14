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
<div id="app" v-cloak>
    <form role="form" class="form-inline">
        <div id="myAlert" class="alert alert-danger" @if(session()->has('url'))  @else style="display: none" @endif>
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>文件正在下载到服务器，请稍等几5分钟左右再点击下载按钮去下载文件</strong>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label" style="line-height: 34px">姓名</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" v-model="name" placeholder="请输入姓名">
            </div>
        </div>
        <div class="form-group">
            <label for="id_card" class="col-sm-4 control-label" style="line-height: 34px">身份证号</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="id_card" v-model="id_card" placeholder="请输入身份证号">
            </div>
        </div>
        <div class="form-group">
            <label for="areas" class="col-sm-4 control-label" style="line-height: 34px">来淮南入住县/区</label>
            <div class=" col-sm-8">
                <select name="areas" id="areas" v-model="areas" class="form-control">
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
        <button type="button" class="btn btn-primary search" @click="search">查询</button>
        <button type="button" class="btn btn-danger" @click="reset">重置</button>
        <button type="button" class="btn btn-default export">导出</button>
        @if(session()->has('url'))
            <button type="button" class="btn btn-default down" data="{{session()->get('url')}}">下载</button>
            <script>
                $(".close").click(function(){
                    $("#myAlert").alert();
                });
            </script>
            @endif
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
            <th>交通类型</th>
            <th>是否发热</th>
            <th>发热度数</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(item,index) in list">
            <td>@{{item.name}}</td>
            <td>@{{item['isSelf']}}</td>
            <td>@{{item['relation']}}</td>
            <td>@{{item['idCard']}}</td>
            <td>@{{item['mobile']}}</td>
            <td>@{{item['fromWhere']}}</td>
            <td>@{{item['arrivalTime']}}</td>
            <td>@{{item['areas']}}</td>
            <td>@{{item['beforeLocat']}}</td>
            <td>@{{item['beforeLocatAddr']}}</td>
            <td>@{{item['nowLocat']}}</td>
            <td>@{{item['nowLocatAddr']}}</td>
            <td>@{{item['carNum']}}</td>
            <td>@{{item['companyName']}}</td>
            <td>@{{ item['isToHubei'] | f1}}</td>
            <td>@{{ item['isContactHb'] | f1}}</td>
            <td>@{{ item['isContactFy'] | f1}}</td>
            <td>@{{item['trafficType']}}</td>
            <td>@{{  item['isFever'] }}</td>
            <td>@{{ item['feverDegree'] }}</td>
            <td>@{{item['createTime'] }}</td>
        </tr>



        </tbody>
    </table>
</div>
<div class="test">
    <navigation :pages="pages" :current.sync="current" @navpage="getMan" ></navigation>
    <ul class="pagination pagination-lg" >
        <li>
            <select name="pageSize"  class="form-control pageSize" v-model="pageSize" style="height: 46px">
                <option value="10">10</option>
                <option value="20" >20</option>
                <option value="50" >50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select></li>
    </ul>
</div>

<script>
    var pageComponent = Vue.extend({
        template: `<nav aria-label="Page navigation">
        <ul class="pagination pagination-lg" style="float: left">
            <li :class="{\'disabled\':curPage==1}">
                <a href="javascript:;" @click="goPage(curPage==1?1:curPage-1)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="page in showPageBtn" :class="{\'active\':page==curPage}">
                <a href="javascript:;" v-if="page" @click="goPage(page)">@{{page}}</a>
                <a href="javascript:;" v-else>...</a>
            </li>
            <li :class="{\'disabled\':curPage==pages}">
                <a href="javascript:;" @click="goPage(curPage==pages?pages:curPage+1)" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>`,
        props: {
            pages: {
                type: Number,
                default: 1
            },
            current: {
                type: Number,
                default: 1
            }
        },
        data(){
            return{
                curPage:1
            }
        },
        computed: {
            showPageBtn() {
                let pageNum = this.pages;
                let index = this.curPage;
                let arr = [];
                if (pageNum <= 5) {
                    for (let i = 1; i <= pageNum; i++) {
                        arr.push(i)
                    }
                    return arr
                }
                if (index <= 2) return [1, 2, 3, 0, pageNum];
                if (index >= pageNum - 1) return [1, 0, pageNum - 2, pageNum - 1, pageNum];
                if (index === 3) return [1, 2, 3, 4, 0, pageNum];
                if (index === pageNum - 2) return [1, 0, pageNum - 3, pageNum - 2, pageNum - 1, pageNum];
                return [1, 0, index - 1, index, index + 1, 0, pageNum];
            }
        },
        methods: {
            goPage(page) {
                if (page != this.curPage) {
                    this.curPage = page;
                    this.$emit('navpage', this.curPage);
                }else{
                }
            }
        }
    });
    Vue.component('navigation', pageComponent);

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
            pageSize:10
        },
        mounted(){
            this.getList()
        },
        watch:{
            pageSize:function (val) {
                this.getList(this.name,this.id_card,this.areas,this.current,val)
            }
        },
        methods:{
            getList:function (name,id_card,areas,page,pageSize) {
                var _this=this
                $.post("/admin/getList",{"name":name,"id_card":id_card,"areas":areas,"page":page,"pageSize":pageSize},function (res){
                    _this.list=res.data.rows
                    _this.total=res.data.total
                    _this.pages=res.data.pages

                })
            },
            search:function () {
                this.getList(this.name,this.id_card,this.areas,1,this.pageSize)
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
    $(".disabled").click(function () {
        return false
    })
    $(".down").click(function () {
        var url=$(this).attr("data")
        window.open(url);
    })
</script>
</body>
</html>
