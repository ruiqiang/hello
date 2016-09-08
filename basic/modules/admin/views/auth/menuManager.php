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
        </div>
    </div>
</div>
<!-- JsTree Styles-->
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default/style.min.css">
<link rel="stylesheet" href="/assets/adminTemplate/js/jstree/dist/themes/default-dark/style.min.css">
<!-- JsTree Js-->
<script src="/assets/adminTemplate/js/jstree/dist/jstree.min.js"></script>
<script type="text/javascript">
$(window).ready(function(){
    $.jstree.defaults.core.themes.responsive = true;
    $('#tree').jstree({ plugins : ["checkbox","","types","wholerow"], "core" : { "themes" : { "name" : "default-dark" } }, "types" : { "file" : { "icon" : "jstree-file" } } });
});
</script>