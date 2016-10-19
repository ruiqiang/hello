<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">广告位管理/ <small>添加广告位</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加广告位
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="form-group">
                            <label class="control-label">广告位编号</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">所属楼盘</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <?php foreach($list as $key=>$value){?>
                                    <option value="<?=$value->id?>"><?=$value->community_name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位名称</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位开始时间</label>
                            <input type="text" class="form-control" id="selectDate1" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位结束时间</label>
                            <input type="text" class="form-control" id="selectDate2" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位画面</label>
                            <input type="file" style="float:right;margin-right:67%;" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位性质</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">
                                    电梯广告</option>
                                <option value="1">
                                    道闸广告</option>
                                <option value="2">
                                    道杆广告</option>
                                <option value="3">
                                    灯箱</option>
                                <option value="4">
                                    行人门禁</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">广告位详细地址</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">设备型号</label>
                            <input type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">当前状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">
                                    未安装</option>
                                <option value="1">
                                    待维修(损坏)</option>
                                <option value="2">
                                    正常使用</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">使用状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">
                                    新增</option>
                                <option value="1">
                                    未使用</option>
                                <option value="2">
                                    已使用</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">销售状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">
                                    销售</option>
                                <option value="1">
                                    赠送</option>
                                <option value="2">
                                    置换</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">画面状态</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0">
                                    预定</option>
                                <option value="1">
                                    待上刊</option>
                                <option value="2">
                                    已上刊</option>
                                <option value="3">
                                    待下刊</option>
                                <option value="4">
                                    已下刊</option>
                            </select>
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
    $(window).ready(function() {
        $('#selectDate1').datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
        $('#selectDate2').datepicker().datepicker("option", "dateFormat", "yy-mm-dd");
    });
</script>