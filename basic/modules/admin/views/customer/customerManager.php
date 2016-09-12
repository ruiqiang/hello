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
                "url": "/assets/adminTemplate/js/dataTables/zh-cn.txt"
            },
            "aLengthMenu" : [10,20,50,100],
            "serverSide": true,
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.ajax( {
                    "type": "GET",
                    "contentType": "application/json",
                    "url": "<?=$jsonurl?>",
                    "dataType": "json",
                    "data": aoData, //以json格式传递
                    "success": fnCallback
                });
            },
            'columns' : <?=$columns?>
        }).api();
    });
</script>