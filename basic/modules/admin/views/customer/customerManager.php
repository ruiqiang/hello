<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">客户管理/ <small>客户列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    客户列表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>公司名称</th>
                                <th>公司地址</th>
                                <th>联系人</th>
                                <th>联系号码</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<!-- /. PAGE INNER  -->
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
    $(window).ready(function(){
        $('#dataTables-example').dataTable({
                "language": {
                    "sLengthMenu": "每页显示  _MENU_ 条",
                    "sZeroRecords": "没有找到符合条件的数据",
                    "sInfo": "当前第 _START_ - _END_ 条　共计 _TOTAL_ 条",
                    "sInfoEmpty": "没有记录",
                    "sInfoFiltered": "(从 _MAX_ 条记录中过滤)",
                    "sSearch": "搜索：",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    },
                },
                "aLengthMenu" : [10,20,50,100],
                "serverSide": true,
                "fnServerData": function(sSource, aoData, fnCallback) {
                    console.log(aoData);
                    //将客户名称加入参数数组
                    $.ajax( {
                        "type": "GET",
                        "contentType": "application/json",
                        "url": '/admin/customer/json',
                        "dataType": "json",
                        "data": aoData, //以json格式传递
                        "success": fnCallback
                    });
                },
                'columns': [
                    { "data": "company" },
                    { "data": "contact" },
                    { "data": "edit" },
                    { "data": "name" },
                    { "data": "phone" },
                ]
            }
        ).api();
    });
</script>