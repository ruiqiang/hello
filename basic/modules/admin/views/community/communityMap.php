<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">楼盘管理/ <small>楼盘地图</small></h1>
        </div>
    </div>
    <!-- /. ROW  -->
    <div class="row">
        <!--<div style="float:left;width:30rem;">
            楼盘列表
            <ul class="mapul">
                <?php /*foreach($data as $key=>$value) {*/?>
                <li position="<?/*=$value['community_longitudex']*/?>,<?/*=$value['community_latitudey']*/?>"><?/*=$value['community_name']*/?></li>
                <?php /*}*/?>
            </ul>
        </div>-->
        <div class="col-md-12" id="map" style="width:85rem;height:50rem;/*float:left;*/">
        </div>
    </div>
    <!-- /. ROW  -->
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ab2CQa603kmx8tYXETWEEOjozKgdUXVL"></script>
<!-- /. PAGE INNER  -->
<script type="text/javascript">
    var data = <?=$datajson?>;
    var map = new BMap.Map("map");                    // 创建Map实例
    map.centerAndZoom("南京", 15);                    // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);


    // 复杂的自定义覆盖物
    function ComplexCustomOverlay(point, text, mouseoverText, id){
        this._point = point;
        this._text = text;
        this._id = id;
        this._overText = mouseoverText;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
        this._map = map;
        var div = this._div = document.createElement("div");
        div.style.position = "absolute";
        div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
        div.style.backgroundColor = "#EE5D5B";
        div.style.border = "1px solid #BC3B3A";
        div.style.color = "white";
        div.style.width = "80px";
        div.style.height = "24px";
        div.style.padding = "3px";
        div.style.lineHeight = "17px";
        div.style.whiteSpace = "nowrap";
        div.style.MozUserSelect = "none";
        div.style.fontSize = "12px";
        div.style.textAlign = "center";
        div.id = this._id;
        var span = this._span = document.createElement("span");
        div.appendChild(span);
        span.appendChild(document.createTextNode(this._text));
        var that = this;

        var arrow = this._arrow = document.createElement("div");
        arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
        arrow.style.position = "absolute";
        arrow.style.width = "11px";
        arrow.style.height = "10px";
        arrow.style.top = "22px";
        arrow.style.left = "10px";
        arrow.style.overflow = "hidden";
        div.appendChild(arrow);

        div.onmouseover = function(){
            this.style.backgroundColor = "#6BADCA";
            this.style.borderColor = "#0000ff";
            this.getElementsByTagName("span")[0].innerHTML = "广告数: 1";
            arrow.style.backgroundPosition = "0px -20px";
        }

        div.onclick = function(){
            window.location.href = "/admin/community/edit?id=" + $(this).attr("id");
        }

        div.onmouseout = function(){
            this.style.backgroundColor = "#EE5D5B";
            this.style.borderColor = "#BC3B3A";
            this.getElementsByTagName("span")[0].innerHTML = that._text;
            arrow.style.backgroundPosition = "0px 0px";
        }

        map.getPanes().labelPane.appendChild(div);

        return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
        var map = this._map;
        var pixel = map.pointToOverlayPixel(this._point);
        this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
        this._div.style.top  = pixel.y - 30 + "px";
    }

    for(var i in data) {
        var point = new BMap.Point(data[i]['community_longitudex'], data[i]['community_latitudey']);
        var myCompOverlay = new ComplexCustomOverlay(point, data[i]['community_name'], "", data[i]['id']);
        map.addOverlay(myCompOverlay);
        //var marker = new BMap.Marker(point);
        //map.addOverlay(marker);
        //marker.setAnimation(BMAP_ANIMATION_BOUNCE);
    }
</script>
<style type="text/css">
.mapul li {
    list-style: none;
    margin: 0.2rem;
}
</style>