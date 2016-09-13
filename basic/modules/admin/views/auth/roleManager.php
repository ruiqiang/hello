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
                    <a href="javascript:;" class="btn btn-info" id="dialog" style="float:right;margin-top:-0.5rem;">添加角色</a>
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


<div class="tree" id="tree" style="min-height:10rem;padding-top:1rem;padding-bottom:1rem;display:none;width:40rem;max-height:40rem;overflow:auto;">
</div>

<div id="roleAdd" style="display:none;width:40rem;">
    <div class="form-group" id="roleAddDialogDiv">
        <label>角色名称(不可重复)：</label>
        <br>
        <input class="form-control" type="text" name="new_role_name" />
        <br>
        <label>角色代码(角色的唯一标识,不可重复)：</label>
        <br>
        <input class="form-control" type="text" name="new_role_code" />

        <div id="addroleinfo" style="display:none;margin-top:10px;">
            <label>角色名已经存在!</label>
        </div>
    </div>
</div>

<input name="roleId" type="hidden" />
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
var tree;
$(document).ready(function () {

    $.jstree.defaults.core.themes.responsive = true;
    $.jstree.defaults.core.themes.name = "default-dark";
    $.jstree.defaults.plugins = ["checkbox","","types","wholerow"];

    var d = dialog({
        //align: 'left',
        title:'',
        id:'roleEdit',
        drag:true,
        content:$('#tree'),
        fixed:true,
        okValue: '确 定',
        ok: function () {
            var checkedIds = $('#tree').jstree().get_checked();
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/auth/updaterolemenu",
                "data" : {'ids' : checkedIds,'role_id' : $('input[name=roleId]').val()},
                "dataType": "json",
                "success": function (data) {
                    if(data != '1') {
                        alert("修改失败!");
                    }
                }
            });
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

    $('input[name=new_role_code]').keydown(function(){
        if($(this).hasClass('alert-danger')) {
            $('#addroleinfo').hide();
            $('input[name=new_role_code]').removeClass('alert-danger');
        }
    });

    $('input[name=new_role_name]').keydown(function(){
        if($(this).hasClass('alert-danger')) {
            $('#addroleinfo').hide();
            $('input[name=new_role_name]').removeClass('alert-danger');
        }
    });

    var addDialog = dialog({
        title:'添加角色',
        id:'roleAdd',
        drag:true,
        content:$('#roleAdd'),
        fixed:true,
        okValue: '确 定',
        ok: function () {
            var roleName = $('input[name=new_role_name]').val();
            var roleCode = $('input[name=new_role_code]').val();
            if(roleName == '') {
                $('#addroleinfo').html('角色名称不能为空!');
                $('input[name=new_role_name]').addClass('alert-danger').focus();
            } else if(roleCode == '') {
                $('#addroleinfo').html('角色代码不能为空!');
                $('input[name=new_role_code]').addClass('alert-danger').focus();
            }
            $.ajax({
                "type": "POST",
                "contentType": "application/x-www-form-urlencoded",
                "url": "/admin/auth/addrole",
                "data" : {'roleName' : roleName,'roleCode' : roleCode},
                "dataType": "json",
                "success": function (data) {
                    if(data != '1') {
                        $('#addroleinfo').addClass('text-danger').show();
                        if(data == '-3') {//角色代码存在
                            $('#addroleinfo').html('角色代码存在!');
                            $('input[name=new_role_code]').addClass('alert-danger').focus();
                        }
                        if(data == '-2') {//角色名存在
                            $('#addroleinfo').html('角色名称存在!');
                            $('input[name=new_role_name]').addClass('alert-danger').focus();
                        }
                        if(data == '-1.1') {
                            $('#addroleinfo').html('角色名称存在非法字符,不要输入空格!');
                            $('input[name=new_role_name]').addClass('alert-danger').focus();
                        }
                        if(data == '-1.2') {
                            $('#addroleinfo').html('角色代码存在非法字符,不要输入空格!');
                            $('input[name=new_role_code]').addClass('alert-danger').focus();
                        }
                        return false;
                    } else {
                        window.location.reload();
                    }
                }
            });
            //this.close();
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
        addDialog.show();
    });

    mybind("#dialogSubmit",function() {
        addDialog.close();
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
                "success": function(data) {
                    fnCallback(data);
                    $('.roleEdit').bind("click", function(){
                        var roleId = $(this).attr('role_id');
                        $('input[name=roleId]').val(roleId);
                        tree = $('#tree').jstree({});
                        $('#tree').jstree(true).settings.core.data = {
                            url:'/admin/auth/getmenutreedata?role_id=' + roleId,
                            "dataType" : "json",
                            "type" : "GET"
                        };
                        $('#tree').jstree(true).refresh();
                        tree = $('#tree').jstree({
                            "core" : {
                                "data" : {
                                "url": '/admin/auth/getmenutreedata?role_id=' + roleId,
                                "dataType" : "json",
                                "type" : "GET"
                                }
                            }
                        }).refresh();
                        d.show();
                    });

                    $('.roleDelete').bind("click", function(){
                        if(confirm('确定要删除该角色吗？')) {
                            var roleId = $(this).attr('role_id');
                            $.ajax({
                                "type": "POST",
                                "contentType": "application/x-www-form-urlencoded",
                                "url": "/admin/auth/deleterole",
                                "data": {'role_id': roleId},
                                "dataType": "json",
                                "success": function (data) {
                                    if (data == '1') {
                                        window.location.reload();
                                    } else {
                                        alert("删除失败!");
                                    }
                                }
                            });
                        }
                    });
                }
            });
        },
        'columns' : <?=$columns?>
        }
    ).api();

    $('#tree').bind("select_node.jstree", function (e, data) {
        console.log(data);
    });
});

function mybind(func, fn) {
    $(func).bind("touchstart",fn);
    $(func).bind("click",fn);
}
</script>