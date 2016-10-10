<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>编辑楼盘</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    编辑楼盘
                </div>
                <div class="panel-body">
                    <form role="form">
                        <div class="form-group">
                            <label class="control-label">楼盘编号</label>
                            <input type="text" class="form-control" value="<?=$data->community_no?>" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">楼盘名称</label>
                            <input type="text" class="form-control" value="<?=$data->community_name?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘详细地址</label>
                            <input type="text" class="form-control" value="<?=$data->community_position?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘类型</label>
                            <input type="text" class="form-control" value="<?=$data->community_category?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘均价</label>
                            <input type="text" class="form-control" value="<?=$data->community_price?>" />(￥)
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘所在商圈</label>
                            <input type="text" class="form-control" value="<?=$data->community_cbd?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘性质</label>
                            <select class="form-control" style="width:40%;float:right;margin-right:50%;">
                                <option value="0" <?php echo $data->community_nature == "0"?"selected=\"selected\"":""?>>新建楼盘</option>
                                <option value="1" <?php echo $data->community_nature == "1"?"selected=\"selected\"":""?>>老楼盘</option>
                                <option value="2" <?php echo $data->community_nature == "2"?"selected=\"selected\"":""?>>改造楼盘</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘开盘时间</label>
                            <input type="text" class="form-control" value="<?=$data->community_opentime?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住时间</label>
                            <input type="text" class="form-control" value="<?=$data->community_staytime?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘户数</label>
                            <input type="text" class="form-control" value="<?=$data->community_units?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘入住人数</label>
                            <input type="text" class="form-control" value="<?=$data->community_households?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标(经度)</label>
                            <input type="text" class="form-control" value="<?=$data->community_longitudex?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">楼盘坐标(纬度)</label>
                            <input type="text" class="form-control" value="<?=$data->community_latitudey?>" />
                        </div>
                        <div class="form-group">
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
    });
</script>