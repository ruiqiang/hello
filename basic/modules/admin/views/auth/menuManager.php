<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                权限管理/ <small>菜单管理</small>
            </h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <div class="tree" id="tree" style="min-height:50rem;padding-top:1rem;">
                <ul>
                    <?php foreach($menus as $menu) {?>
                    <?php
                            if(is_array($menu->childMenus) && count($menu->childMenus) > 0) {
                                echo '<li data-jstree=\'{"opened" : true}\' menu_id="'.$menu->id.'">' . $menu->menu_name;
                                echo '<ul>';
                                foreach($menu->childMenus as $childMenu) {
                                    echo '<li menu_id="'.$childMenu->id.'">' . $childMenu->menu_name . '</li>';
                                }
                                echo '</ul></li>';
                            } else
                                echo '<li menu_id="'.$menu->id.'">' . $menu->menu_name . '</li>';
                        ?>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>


<div  id="dialogForm" style="width:32rem;">
    <div class="form-group">
        <label>菜单名称：</label>
        <input class="form-control" type="text" name="menu_name" />

        <label>菜单地址：</label>
        <input class="form-control" type="text" name="menu_url" />
    </div>
</div>


<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<!-- /. PAGE INNER  -->
<script src="/assets/artDialog/dist/dialog.js"></script>
<script src="/assets/artDialog/dist/dialog-plus.js"></script>
<link href="/assets/artDialog/css/ui-dialog.css" rel="stylesheet" />
<script type="text/javascript">
var d = null;
$(window).ready(function(){
    $.jstree.defaults.core.themes.responsive = true;
    $('#tree').jstree({
        plugins : ["","types","wholerow"], "core" : { "themes" : { "name" : "default-dark" } },
            "types" : { "file" : { "icon" : "jstree-file" }}
    }).bind('click.jstree', function(event) {
        var eventNodeName = event.target.nodeName;
        if (eventNodeName == 'INS' || eventNodeName == 'A') {
            var $subject = $(event.target).parent();
            var menu_id = $(event.target).parents('li').attr('menu_id');
            $.ajax( {
                "type": "GET",
                "contentType": "application/json",
                "url": "/admin/auth/getmenuinfo?menu_id="+menu_id,
                "dataType": "json",
                "success": function(data) {
                    $("input[name=menu_name]").val(data.menu_name);
                    $("input[name=menu_url]").val(data.menu_url);
                    if(data.childMenus > 0) {
                        $("input[name=menu_url]").attr('readonly',true).attr('title',"此菜单无实际地址");
                    } else {
                        $("input[name=menu_url]").attr('readonly',false);
                    }
                    if (d != null) {
                        d.content($("#dialogForm"));
                        d.show();
                    } else {
                        d = dialog({
                            title: '编辑菜单',
                            id: 'menu_dialog_id',
                            drag: true,
                            content: $("#dialogForm"),
                            fixed: true,
                            okValue: '确 定',
                            ok: function () {
                                $.ajax({
                                    "type": "POST",
                                    "contentType": "application/json",
                                    "url": "/admin/auth/updatemenuinfo",
                                    "data":"{menu_id:\"" + data.id + "\",menu_name:\"" + $("input[name=menu_name]").val() +
                                        "\",menu_url:\"" + $("input[name=menu_url]").val()+"\"}",
                                    "dataType": "json",
                                    "success": function (response) {

                                    }
                                });
                                this.close();
                                return false;
                            },
                            cancelValue: '取消',
                            cancel: function () {
                                this.close();
                                return false;
                            },
                            resize: true,
                        });
                        d.show();
                    }
                }
            });

        }
    });
});
</script>