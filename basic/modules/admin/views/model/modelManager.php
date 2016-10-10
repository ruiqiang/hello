<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">设备管理/ <small>设备列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    广告位列表
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>设备名称</th>
                                <th>设备类别</th>
                                <th>生产厂家</th>
                                <th>所属公司</th>
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
    var search = null;
    $(window).ready(function(){
        var table = $('#dataTables-example').dataTable({
                "ordering" : false,
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
                        "success": function(data) {
                            fnCallback(data);
                            $('.roleEdit').click(function(){

                            });
                            $('.roleDelete').click(function(){

                            });
                            if(search == null) {
                                search =  $('input[type=search]');
                                search.before("(设备名称)&nbsp;");
                            }
                        }
                    });
                },
                'columns' : <?=$columns?>
            }
        ).api();
    });
</script>