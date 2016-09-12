<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                权限管理/ <small>角色管理</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->

    <div class="row">

        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    角色列表
                    <a href="javascript:;" class="btn btn-primary" id="dialog" style="float:right;margin-top:-0.5rem;">弹出框</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>角色名称</th>
                                <th>角色代码</th>
                                <th>角色用户数</th>
                                <th>角色菜单数</th>
                                <th>编辑角色</th>
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
</div>


<div class="tree" id="tree" style="min-height:50rem;padding-top:1rem;display:none;width:45rem;max-height:60rem;min-height:30rem;">
    <ul>
        <li>控制台</li>
        <li>UI Elements</li>
        <li>Charts</li>
        <li>Tabs & Panels</li>
        <li>Responseive Tables</li>
        <li>Forms</li>
        <li data-jstree='{"opened" : true}'>权限管理
            <ul>
                <li>用户管理</li>
                <li>角色管理</li>
                <li>菜单管理</li>
            </ul>
        </li>
        <li>Empty Page</li>
    </ul>
</div>

<!-- /. PAGE INNER  -->
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {

    $.jstree.defaults.core.themes.responsive = true;

    $('#tree').jstree({ plugins : ["checkbox","","types","wholerow"], "core" : { "themes" : { "name" : "default-dark" } }, "types" : { "file" : { "icon" : "jstree-file" } } });

    var d = dialog({
        title:'可拖动弹出框',
        id:'demo',
        drag:true,
        content:$('#tree'),
        fixed:true,
        okValue: '确 定',
        ok: function () {
            this.close();
            return false;
        },
        cancelValue:'取消',
        cancel: function () {
            this.close();// 隐藏
            return false;
        },
        resize:true,
    });

    mybind("#dialog",function() {
        d.show();
    });

    mybind("#dialogSubmit",function() {
        d.close();
    });

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
        }
    ).api();
});

function mybind(func, fn) {
    $(func).bind("touchstart",fn);
    $(func).bind("click",fn);
}
</script>