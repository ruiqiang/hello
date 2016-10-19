<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>添加楼盘</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    楼盘添加
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="form-group">
                            <label class="control-label">楼盘编号</label>
                            <input type="text" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">楼盘名称</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘详细地址</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘类型</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘均价(￥)</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘所在商圈</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘性质</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">新建楼盘</option>
                                <option value="1">老楼盘</option>
                                <option value="2">改造楼盘</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘开盘时间</label>
                            <input type="text" id="selectDate1" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住时间</label>
                            <input type="text" id="selectDate2" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘户数</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住人数</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标</label>
                            <input type="text" class="form-control" id="position" />
                        </div>
                        <div id="map" style="width:50rem;height:50rem;margin-left:10%;">

                        </div>
                        <div class="form-group" style="margin-top:2rem;">
                            <label class="control-label">楼盘门头图片</label>
                            <input type="file" style="float:right;margin-right:67%;"  />
                        </div>
                        <div class="form-group1">
                            <label class="control-label"></label>
                            <a href="javascript:;" class="btn btn-info" id="addCommunity" style="float:right;width:5rem;text-align:center;margin-right:50%;">提&nbsp;交</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<script src="/assets/datepicker/jquery.ui.datepicker.js"></script>
<script src="/assets/datepicker/jquery-ui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ab2CQa603kmx8tYXETWEEOjozKgdUXVL"></script>
<link rel="stylesheet" href="/css/jquery-ui.css">
<style type="text/css">
    .form-group:after {
        content:":";
        clear:both;
    }
    .form-group input.form-control {
        float:right;width:40%;margin-right:50%;
    }
    .form-group label.control-label {
        line-height:34px;
    }
</style>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    var map = new BMap.Map("map");                    // 创建Map实例
    map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);
    map.addEventListener("click", function(e){
        $("#position").val(e.point.lng + "," + e.point.lat);
        map.clearOverlays();
        var point = new BMap.Point(e.point.lng, e.point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
    });
    $(window).ready(function() {
        $('#selectDate1').datepicker().datepicker("option", "dateFormat", "yy-mm-dd");

        $('#selectDate2').datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
    });
</script>