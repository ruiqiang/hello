<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>楼盘列表</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    楼盘列表
                    <a href="javascript:;" class="btn btn-info" id="addCommunity" style="float:right;margin-top:-0.5rem;">添加楼盘</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>楼盘编号</th>
                                    <th>楼盘名称</th>
                                    <th>楼盘商圈</th>
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

    $("#addCommunity").click(function(){
       window.location.href = "/admin/community/add";
    });

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
                        $('.bindRole').click(function(){
                            var staffId = $(this).attr('staff_id');
                            $.ajax({
                                "type": "GET",
                                "url": "/admin/auth/getuserrole",
                                "data" : {'staff_id' : staffId},
                                "dataType": "json",
                                "success": function (data) {
                                    if(data != null) {
                                        $('select[name=role_id]').val(data.role_id);
                                    } else {
                                        $('select[name=role_id]').val('0');
                                    }
                                }
                            });
                            $('input[name=staff_id]').val(staffId);
                            bindDialog.show();
                        });
                        if(search == null) {
                            search =  $('input[type=search]');
                            search.before("(楼盘名称)&nbsp;");
                        }
                    }
                });
            },
            'columns' : <?=$columns?>
        }
    ).api();
});
</script>