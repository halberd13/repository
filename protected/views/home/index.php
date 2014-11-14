<style>
.choose-map  {
/*    border: 3px dashed #ffffff;
    background: #46a546;*/
    top: 60px;
    left: 20px;
    height: 50px;
    width: 200px;
    padding: 20px;
}

.list-map{
    min-height: 1px;
    max-height: 400px;
    padding: 0px;
    margin-bottom: 5px;
    background: rgba(255, 255, 224, 0.4);
    border-radius: 15px;
    overflow: hidden;
    -webkit-transition: height 0.35s ease;
     -moz-transition: height 0.35s ease;
       -o-transition: height 0.35s ease;
          transition: height 0.35s ease;
      /*background:#000;opacity:0.4;filter:alpha(opacity=40);*/
}

.list-map:hover  {
    min-height: 1px;
    max-height: 400px;
    padding: 1px;
    margin-bottom: 5px;
    background: rgba(255, 255, 224, 0.9);
    border-radius: 15px;
    border-color: windowframe;
    overflow: auto;
    -webkit-transition: height 0.35s ease;
     -moz-transition: height 0.35s ease;
       -o-transition: height 0.35s ease;
          transition: height 0.35s ease;
}
.map {
    min-width: 600px;
    width: 100%;
    height: 600px;
}

</style>

        <div id="map-canvas" class="map"></div>
        <div id="choose-map" class="btn-group choose-map" data-toggle="buttons-checkbox">
            <button id="click-kec" type="button" class="btn btn-small btn-danger"><strong>Kecamatan</strong></button>
            <button id="click-kel" type="button" class="btn btn-small btn-danger"><strong>Kelurahan</strong></button>
            <!--<button id="click-pusk" type="button" class="btn btn-danger">Puskesmas</button>-->
            <button id="btn-search" data-toggle="modal" data-target="#show-search" type="button" class="btn btn-small btn-success"><strong>Pencarian</strong></button>
            <button id="btn-route" data-toggle="modal" data-target="#show-direction" type="button" class="btn btn-small btn-primary"><strong>Route</strong></button>
            <button id="callback_direct" data-toggle="modal" data-target="#show-path" type="button" class="btn btn-small btn-warning"><strong>Show Directions Path</strong></button>
            
        </div>
        <div id="list-map" class="list-map">
            <div class="span3 bs-docs-sidebar">
            <ul id="list-kec" class="nav nav-list bs-docs-sidenav affix-top fade"></ul>
            <ul id="list-kel" class="nav nav-list bs-docs-sidenav affix-top fade"></ul>
            <ul id="list-pusk" class="nav nav-list bs-docs-sidenav affix-top fade"></ul>
            </div>
<!--            <div id="list-kel" class="span3 fade"></div><br/>
            <div id="list-pusk" class="span3 fade"></div><br/>-->
        </div>
        
        <div class="modal fade bs-example-modal-sm" tabindex="-1" id="show-search" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>Input Pencarian</h4>
            </div>
            <div class="modal-body">
                <?php 
                   $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'name'=>'input_search',
                        'source'=>json_decode($model),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'1',
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;', 'class' =>'input-xlarge' ,
                        ),
                    ));
                ?>
            </div>        
            <div class="modal-footer">
                <button type="button" id="search-map" class="btn btn-primary" data-dismiss="modal">Cari</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        <div class="modal fade bs-example-modal-sm" tabindex="-1" id="show-direction" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4>Route Direction</h4>
            </div>
            <div class="modal-body">
                <label>Input Asal</label>
                <?php 
                   $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'name'=>'input_origin',
                        'source'=>json_decode($model),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'1',
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;', 'class' =>'input-xlarge' ,
                        ),
                    ));
                ?>
                <label>Input Tujuan</label>
                <?php 
                   $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'name'=>'input_destination',
                        'source'=>json_decode($model),
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'1',
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;','class' =>'input-xlarge' ,
                        ),
                    ));
                ?>
            </div>        
            <div class="modal-footer">
                <button type="button" id="calc-route" class="btn btn-primary" data-dismiss="modal">Route Directions</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        <div class="modal fade" id="show-path" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Direction Path</h4>
                </div>
                <div class="modal-body well span-14" id="panel-option" data-dismiss="modal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
        
<script type="text/javascript">
$(window).load(function() { // makes sure the whole site is loaded
    $("#statusloader").fadeOut(); // will first fade out the loading animation
    $("#preloader").delay(750).fadeOut("slow"); // will fade out the white DIV that covers the website.
})     
    
    
var tDataPuskesmas = [<?php echo json_encode($dtpuskesmas);?>];
var tDataKecamatan = [<?php echo json_encode($dtkecamatan);?>];
var tDataKelurahan = [<?php echo json_encode($dtkelurahan);?>];
var infoWindowPuskesmas = null;
var infoWindowKecamatan = null;
var infoWindowKelurahan = null;
var infoWindowSearch = null;
var infoAllPuskesmas = [];
var infoAllKecamatan = [];
var infoAllKelurahan = [];
var pusk_marker;
var kec_marker;
var kel_marker;

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

var map;
var Pmarkers = [];
var Kmarkers = [];
var Lmarkers = [];
var Smarkers;
    
    function initialize(){
        map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 12,
            center: new google.maps.LatLng(-6.127181,106.829198 ),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true

        });
        var chMap = document.getElementById("choose-map");
        var lsMap = document.getElementById("list-map");
        var lsKec = document.getElementById("list-kec");
        var lsKel = document.getElementById("list-kel");
//        var lsPusk = document.getElementById("list-pusk");
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(chMap);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(lsMap);
//        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(lsKec);
//        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(lsKel);
//        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(lsPusk);
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('panel-option'));
    
       
      var NorthJakarta = [
                            new google.maps.LatLng(-6.095068,106.711149),
                            new google.maps.LatLng(-6.091995,106.718445),
                            new google.maps.LatLng(-6.092507,106.719046),
                            new google.maps.LatLng(-6.091312,106.721191),
                            new google.maps.LatLng(-6.091739,106.722050),
                            new google.maps.LatLng(-6.089179,106.724453),
                            new google.maps.LatLng(-6.089520,106.725054),
                            new google.maps.LatLng(-6.088923,106.725569),
                            new google.maps.LatLng(-6.089520,106.726513),
                            new google.maps.LatLng(-6.089691,106.727028),
                            new google.maps.LatLng(-6.091483,106.726084),
                            new google.maps.LatLng(-6.095409,106.730289),
                            new google.maps.LatLng(-6.097713,106.732607),
                            new google.maps.LatLng(-6.098481,106.734324),
                            new google.maps.LatLng(-6.098652,106.734924),
                            new google.maps.LatLng(-6.099591,106.736298),
                            new google.maps.LatLng(-6.099932,106.737413),
                            new google.maps.LatLng(-6.099506,106.737928),
                            new google.maps.LatLng(-6.101298,106.740675),
                            new google.maps.LatLng(-6.101724,106.744967),
                            new google.maps.LatLng(-6.100700,106.745739),
                            new google.maps.LatLng(-6.101298,106.746254),
                            new google.maps.LatLng(-6.100359,106.746683),
                            new google.maps.LatLng(-6.099847,106.746769),
                            new google.maps.LatLng(-6.099762,106.749945),
                            new google.maps.LatLng(-6.101383,106.751575),
                            new google.maps.LatLng(-6.103687,106.755695),
                            new google.maps.LatLng(-6.103773,106.760330),
                            new google.maps.LatLng(-6.102749,106.763506),
                            new google.maps.LatLng(-6.101298,106.764965),
                            new google.maps.LatLng(-6.100444,106.765394),
                            new google.maps.LatLng(-6.100103,106.766253),
                            new google.maps.LatLng(-6.101383,106.767540),
                            new google.maps.LatLng(-6.103602,106.771402),
                            new google.maps.LatLng(-6.103431,106.776295),
                            new google.maps.LatLng(-6.108381,106.783934),
                            new google.maps.LatLng(-6.106760,106.789942),
                            new google.maps.LatLng(-6.093361,106.790886),
                            new google.maps.LatLng(-6.092422,106.794748),
                            new google.maps.LatLng(-6.093958,106.796379),
                            new google.maps.LatLng(-6.091910,106.801014),
                            new google.maps.LatLng(-6.119220,106.810112),
                            new google.maps.LatLng(-6.119732,106.816292),
                            new google.maps.LatLng(-6.115977,106.818008),
                            new google.maps.LatLng(-6.115977,106.827278),
                            new google.maps.LatLng(-6.120756,106.836891),
                            new google.maps.LatLng(-6.120073,106.846848),
                            new google.maps.LatLng(-6.114611,106.858521),
                            new google.maps.LatLng(-6.110856,106.859207),
                            new google.maps.LatLng(-6.111198,106.861267),
                            new google.maps.LatLng(-6.113587,106.861267),
                            new google.maps.LatLng(-6.111880,106.864014),
                            new google.maps.LatLng(-6.105394,106.871910),
                            new google.maps.LatLng(-6.093787,106.878090),
                            new google.maps.LatLng(-6.099249,106.917915),
                            new google.maps.LatLng(-6.097884,106.926498),
                            new google.maps.LatLng(-6.096177,106.935768),
                            new google.maps.LatLng(-6.098225,106.940918),
                            new google.maps.LatLng(-6.095153,106.956367),
                            new google.maps.LatLng(-6.093105,106.967354),
                            new google.maps.LatLng(-6.092422,106.969414),
                            new google.maps.LatLng(-6.154550,106.970615),
                            new google.maps.LatLng(-6.157793,106.960144),
                            new google.maps.LatLng(-6.158476,106.955853),
                            new google.maps.LatLng(-6.151990,106.955166),
                            new google.maps.LatLng(-6.151819,106.953621),
                            new google.maps.LatLng(-6.153697,106.948814),
                            new google.maps.LatLng(-6.151819,106.948128),
                            new google.maps.LatLng(-6.151819,106.941605),
                            new google.maps.LatLng(-6.163254,106.933022),
                            new google.maps.LatLng(-6.183052,106.928387),
                            new google.maps.LatLng(-6.182540,106.913624),
                            new google.maps.LatLng(-6.182540,106.910362),
                            new google.maps.LatLng(-6.178102,106.897316),
                            new google.maps.LatLng(-6.166838,106.879635),
                            new google.maps.LatLng(-6.163766,106.880493),
                            new google.maps.LatLng(-6.163084,106.876888),
                            new google.maps.LatLng(-6.153355,106.860752),
                            new google.maps.LatLng(-6.151649,106.857147),
                            new google.maps.LatLng(-6.152673,106.850281),
                            new google.maps.LatLng(-6.153526,106.844788),
                            new google.maps.LatLng(-6.150454,106.841183),
                            new google.maps.LatLng(-6.145163,106.843586),
                            new google.maps.LatLng(-6.141920,106.838779),
                            new google.maps.LatLng(-6.146528,106.836033),
                            new google.maps.LatLng(-6.141408,106.833458),
                            new google.maps.LatLng(-6.134410,106.831570),
                            new google.maps.LatLng(-6.138336,106.814060),
                            new google.maps.LatLng(-6.131167,106.810455),
                            new google.maps.LatLng(-6.133728,106.801186),
                            new google.maps.LatLng(-6.142091,106.800327),
                            new google.maps.LatLng(-6.145334,106.775093),
                            new google.maps.LatLng(-6.141920,106.775265),
                            new google.maps.LatLng(-6.135434,106.752434),
                            new google.maps.LatLng(-6.117001,106.726856),
                            new google.maps.LatLng(-6.095665,106.711407)
                            ];

      var polyOptions = {
            path: NorthJakarta,
            strokeColor: "#FF0000",
            strokeOpacity: 1,
            strokeWeight: 3
            }
        var it = new google.maps.Polyline(polyOptions);
        it.setMap(map);
    
    }
    
    
    
    function calcRoute(data) {
        var originLat = data.origin[0];
        var originLng = data.origin[1];
        var start = new google.maps.LatLng(originLat , originLng );
        var destiLat = data.desti[0];
        var destinLng = data.desti[1];
        var end = new google.maps.LatLng(destiLat , destinLng );
        
      var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
      };
      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          $('#show-direction').hide();
          $('#callback_direct').show();
          
        }else{
            alert("Direction is Not Found");
        }
      });
    }
    
    function searchMap(data){
        var searchLat = data.point[0];
        var searchLng = data.point[1];
        var nama = data.point[2];
        var alamat = data.point[3];
        var icon_map = "<?php echo Yii::app()->baseUrl;?>/images/" + data.point[4];
        var id = data.point[5];
        var url = data.point[6];
        var point = new google.maps.LatLng(searchLat , searchLng);
        Smarkers = new google.maps.Marker({
            position : point,
            map: map,
            icon: icon_map,
            animation: google.maps.Animation.BOUNCE
        });
        Smarkers.setMap(map);
        if(url=='kecamatan'){
            url= "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kecamatan/detil&kec_id=" + id +"' target='_blank'>"
        }else if(url=='kelurahan'){
            url= "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/detil&kel_id=" + id +"' target='_blank'>"
        }else if(url=='puskesmas'){
            url= "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=puskesmas/detil&pusk_id=" + id +"' target='_blank'>"
        }
        latlng = new google.maps.LatLng(searchLat, searchLng);
        map.panTo(latlng);
        var info = "Nama : " + nama 
                    + "<br/> Alamat :" + alamat 
                    +  "<br/>Latitude : " 
                    + searchLat + "<br/> Longitude : " 
                    + searchLng +"<br/><a href='" 
                    + url + "Selengkapnya . . .</a>";
        
        infoWindowSearch = new google.maps.InfoWindow();
        infoWindowSearch.setOptions({
            content: info,
        });
        infoWindowSearch.open(map,Smarkers);
        
        
    }
    
    function showPositionPuskesmas(id){
        clearMarkerKelurahan();
        clearMarkerPuskesmas();
        clearMarkerKecamatan();
        var tData = JSON.parse(tDataPuskesmas);
        var i, lat, lng;
        for(i=0;i<tData.length;i++){
            if(tData[i][4]===id){
                var nama = tData[i][2];
                var lat = tData[i][0];
                var lng = tData[i][1];
                var id = tData[i][4];
                var alamat = tData[i][5];
                var positionMarker = new google.maps.LatLng(lat , lng );
                var image = "<?php echo Yii::app()->baseUrl;?>/images/" + tData[i][3];
                pusk_marker = new google.maps.Marker({
                  position: positionMarker,
                  map: map,
                  icon: image,
                  animation: google.maps.Animation.BOUNCE
                 });
                Pmarkers.push(pusk_marker); 
            }
            
        }
        latlng = new google.maps.LatLng(lat, lng);
        map.panTo(latlng);
        var info = "Nama Puskesmas : " + nama 
                    + "<br/>Alamat :" + alamat 
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=puskesmas/detil&pusk_id=" + id +"' target='_blank'>Selengkapnya . . .</a>";
        
        infoWindowPuskesmas = new google.maps.InfoWindow();
        infoWindowPuskesmas.setOptions({
            content: info,
        });
        infoWindowPuskesmas.open(map,pusk_marker);
        
    }
    
    function showPositionKecamatan(id){
        clearMarkerKelurahan();
        clearMarkerPuskesmas();
        clearMarkerKecamatan();
        var tData = JSON.parse(tDataKecamatan);
        var i, lat, lng;
        for(i=0;i<tData.length;i++){
            if(tData[i][4]===id){
                var nama = tData[i][2];
                var lat = tData[i][0];
                var lng = tData[i][1];
                var id = tData[i][4];
                var alamat = tData[i][5];
                var positionMarker = new google.maps.LatLng(lat , lng );
                var image = "<?php echo Yii::app()->baseUrl;?>/images/" + tData[i][3];
                kec_marker = new google.maps.Marker({
                  position: positionMarker,
                  map: map,
                  icon: image,
                  animation: google.maps.Animation.BOUNCE
                 });
                Kmarkers.push(kec_marker); 
            }
            
        }
        latlng = new google.maps.LatLng(lat, lng);
        map.panTo(latlng);
        var info = "Nama Kecamatan : " + nama 
                    + "<br/>Alamat :" + alamat
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kecamatan/detil&kec_id=" + id +"' target='_blank'>Selengkapnya . . .</a>";
        
        infoWindowKecamatan = new google.maps.InfoWindow();
        infoWindowKecamatan.setOptions({
            content: info,
        });
        infoWindowKecamatan.open(map,kec_marker);
        
    }
    
    function showPositionKelurahan(id){
        clearMarkerKelurahan();
        clearMarkerPuskesmas();
        clearMarkerKecamatan();
        var tData = JSON.parse(tDataKelurahan);
        var i, lat, lng;
        for(i=0;i<tData.length;i++){
            if(tData[i][4]===id){
                var nama = tData[i][2];
                var lat = tData[i][0];
                var lng = tData[i][1];
                var id = tData[i][4];
                var alamat = tData[i][5];
                var positionMarker = new google.maps.LatLng(lat , lng );
                var image = "<?php echo Yii::app()->baseUrl;?>/images/" + tData[i][3];
                kel_marker = new google.maps.Marker({
                  position: positionMarker,
                  map: map,
                  icon: image,
                  animation: google.maps.Animation.BOUNCE
                 });
                Lmarkers.push(kel_marker); 
            }
            
        }
        latlng = new google.maps.LatLng(lat, lng);
        map.panTo(latlng);
        var info = "Nama Kelurahan : " + nama 
                    + "<br/>Alamat :" + alamat
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/detil&kel_id=" + id +"' target='_blank'>Selengkapnya . . .</a>";
        
        infoWindowKelurahan = new google.maps.InfoWindow();
        infoWindowKelurahan.setOptions({
            content: info,
        });
        infoWindowKelurahan.open(map,kel_marker);
        
    }

    function createMarkerPuskemas(dt){
        clearMarkerPuskesmas();
        var i;
        if(dt==null){var data=[];}
        else {var data = JSON.parse(dt);}
        var infowindow = new google.maps.InfoWindow();
        var info = [];
        for (i = 0; i < data.length; i++) {
            var nama = data[i][2];
            var lat = data[i][0];
            var lng = data[i][1];
            var id = data[i][4];
            var alamat = data[i][5];
            var positionMarker = new google.maps.LatLng(lat , lng );
            var image = "<?php echo Yii::app()->baseUrl;?>/images/" + data[i][3];
            pusk_marker = new google.maps.Marker({
              position: positionMarker,
              map: map,
              icon: image,
              animation: google.maps.Animation.DROP
             });
            Pmarkers.push(pusk_marker);
            
            infoAllPuskesmas[i] = "Nama Puskesmas : " + nama 
                    + "<br/>Alamat :" + alamat 
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=puskesmas/detil&pusk_id=" + id +"' target='_blank'>Selengkapnya . . .</a>";


            infowindow = new google.maps.InfoWindow({
                                                    content : infoAllPuskesmas[i]
                                                }); 
                                                
           google.maps.event.addListener(pusk_marker, 'click', (function(pusk_marker, i) {
                return function() {
                    infowindow.setContent(infoAllPuskesmas[i]);
                    infowindow.open(map, pusk_marker);
                }
            })(pusk_marker,i));                                                    
        }
                                                
            
        
    }
    
    function createMarkerKecamatan(dt){
        clearMarkerKecamatan();
        var i;
        if(dt==null){var data=[];}
        else {var data = JSON.parse(dt);}
        var infowindow = new google.maps.InfoWindow();
        var info = [];
        for (i = 0; i < data.length; i++) {
            var nama = data[i][2];
            var lat = data[i][0];
            var lng = data[i][1];
            var id = data[i][4];
            var alamat = data[i][5];
            var positionMarker = new google.maps.LatLng(lat , lng );
            var image = "<?php echo Yii::app()->baseUrl;?>/images/" + data[i][3];
            kec_marker = new google.maps.Marker({
              position: positionMarker,
              map: map,
              icon: image,
              animation: google.maps.Animation.DROP
             });
            Kmarkers.push(kec_marker);
            infoAllKecamatan[i] = "Nama Kecamatan : " + nama 
                    + "<br/>Alamat :" + alamat 
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kecamatan/detil&kec_id=" + id +"'>Selengkapnya . . .</a>";


            var infowindow = new google.maps.InfoWindow({
                                                    content : infoAllKecamatan[i]
                                                }); 
                                                
            google.maps.event.addListener(kec_marker, 'click', (function(kec_marker, i) {
                return function() {
                    infowindow.setContent(infoAllKecamatan[i]);
                    infowindow.open(map, kec_marker);
                }
            })(kec_marker,i));
        }
    }
    
    function createMarkerKelurahan(dt){
        clearMarkerKelurahan();
        var i;
        if(dt==null){var data=[];}
        else {var data = JSON.parse(dt);}
        var infowindow = new google.maps.InfoWindow();
        var info = [];
        for (i = 0; i < data.length; i++) {
            var nama = data[i][2];
            var lat = data[i][0];
            var lng = data[i][1];
            var id = data[i][4];
            var alamat = data[i][5];
            var positionMarker = new google.maps.LatLng(lat , lng );
            var image = "<?php echo Yii::app()->baseUrl;?>/images/" + data[i][3];
            kel_marker = new google.maps.Marker({
              position: positionMarker,
              map: map,
              icon: image,
              animation: google.maps.Animation.DROP
             });
            Lmarkers.push(kel_marker);
            infoAllKelurahan[i] = "Nama Kelurahan : " + nama 
                    + "<br/>Alamat :" + alamat 
                    +  "<br/>Latitude : " 
                    + lat + "<br/> Longitude : " 
                    + lng +"<br/><a href='" 
                    + "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/detil&kel_id=" + id +"'>Selengkapnya . . .</a>";


//            var infowindow = new google.maps.InfoWindow({
//                                                    content : infoAllKelurahan[i]
//                                                }); 
                                                
            google.maps.event.addListener(kel_marker, 'click', (function(kel_marker, i) {
                return function() {
                    infowindow.setContent(infoAllKelurahan[i]);
                    infowindow.open(map, kel_marker);
                }
            })(kel_marker,i));
        }
    }
    
    function setMarkerPuskesmas(map){
        for (var i = 0; i < Pmarkers.length; i++) {
            Pmarkers[i].setMap(map);
        }
    }
    function setMarkerKecamatan(map){
        for (var i = 0; i < Kmarkers.length; i++) {
            Kmarkers[i].setMap(map);
        }
    }
    function setMarkerKelurahan(map){
        for (var i = 0; i < Lmarkers.length; i++) {
            Lmarkers[i].setMap(map);
        }
    }
    
    function clearMarkerPuskesmas(){
        if(infoWindowPuskesmas!=null){infoWindowPuskesmas.close();}
        setMarkerPuskesmas(null);
    }
    function clearMarkerKecamatan(){
        if(infoWindowKecamatan!=null){infoWindowKecamatan.close();}
        setMarkerKecamatan(null);
    }
    function clearMarkerKelurahan(){
        if(infoWindowKelurahan!=null){infoWindowKelurahan.close();}
        setMarkerKelurahan(null);
    }
    function clearMarkerSearch(){
        if(Smarkers!=null)Smarkers.setMap(null);
    }
    
    
    
    
//============================ HTML ==================================================     
    
    function listKecamatan(){
        var list_kec = <?php echo $dtkecamatan;?>;
        var jml_kec = list_kec.length;
        $("#jml-kec").append(jml_kec);
        for(i=0;i<list_kec.length;i++){
            if(i==0){
                $("#list-kec").append("<li id='header-kec' class='nav-header'><h4>Kecamatan</h4></li>");
            }
            $("#list-kec").append("<li class='mark-kec' id='" + list_kec[i][4] + "'> <a  href='#' style='font-size:14px;'> " + list_kec[i][2] + " <i class='icon-chevron-right' style='float:right'></i></a></li>");
        }
    }
    function listKelurahan(){
        var list_kel = <?php echo $dtkelurahan;?>;
        var jml_kel = list_kel.length;
        $("#jml-kel").append(jml_kel);
        for(i=0;i<list_kel.length;i++){
            if(i==0){
                $("#list-kel").append("<li class='nav-header'><h4>Kelurahan</h4></li>");
            }
            $("#list-kel").append("<li href='#' class='mark-kel' id='" + list_kel[i][4] + "'><a href='#' style='font-size:14px;'>  " + list_kel[i][2] + "<i class='icon-chevron-right' style='float:right'></i> </a></li>");
        }
    }
    function listPuskesmas(){
        var list_pusk = <?php echo $dtpuskesmas;?>;
        var jml_pusk = list_pusk.length;
        $("#jml-pusk").append(jml_pusk);
        for(i=0;i<list_pusk.length;i++){
            if(i==0){
                $("#list-pusk").append("<li class='nav-header'><h4>Puskesmas</h4></li>");
            }
            $("#list-pusk").append(
                    "<li class='mark-pusk' id='" 
                    + list_pusk[i][4] 
                    + "'> <a href='#' style='font-size:14px;'> " 
                    + list_pusk[i][2] 
                    + "<i class='icon-chevron-right' style='float:right'></i></a></li>");
        }
    }
    
    $(document).ready(function() {
        listKecamatan();
        listKelurahan();
        listPuskesmas();
        $("#list-kec").hide();
        $("#list-kel").hide();
        $("#list-pusk").hide();
        $("#callback_direct").hide();
        $("#show-direction").hide();
        $("#show-path").hide();
        $("#show-search").hide();
        $('#calc-route').click(function (){
            var input_origin = $('#input_origin').val();
            var input_destination = $('#input_destination').val();
            var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=home/getRoute";      
            $.post(url , { origin : input_origin, desti : input_destination } )
                .done(function (data){
                    var d =JSON.parse(data);
                    calcRoute(d);
                });
        });
        
        
        $("#click-kec").click(function (){
            clearMarkerSearch();
            if ($("#click-kec").hasClass("active")){
                clearMarkerKecamatan();
            }else{
                createMarkerKecamatan(tDataKecamatan);
                
            }
            $("#list-kec").toggleClass("in");
            $("#list-kec").slideToggle("slow");
        });
        $("#click-kel").click(function (){
            clearMarkerSearch();
            if ($("#click-kel").hasClass("active")){
                clearMarkerKelurahan();
            }else{
                createMarkerKelurahan(tDataKelurahan);
                
            }
            $("#list-kel").toggleClass("in");
            $("#list-kel").slideToggle('slow');
        });
        $("#click-pusk").click(function (){
            clearMarkerSearch();
            if ($("#click-pusk").hasClass("active")){
                clearMarkerPuskesmas();
            }else{
                createMarkerPuskemas(tDataPuskesmas);
                
            }
            
            $("#list-pusk").toggleClass("in");
            $("#list-pusk").slideToggle("slow");
            
        });
        
        $(".mark-pusk").click(function() {
            if(infoWindowPuskesmas!=null){infoWindowPuskesmas.close();}
            if(pusk_marker!=null){pusk_marker.setMap(null);}
            var position = $(this).attr("id");
            showPositionPuskesmas(position);
        });
        
        $(".mark-kec").click(function() {
            if(infoWindowKecamatan!=null){infoWindowKecamatan.close();}
            if(kec_marker!=null){kec_marker.setMap(null);}
            var position = $(this).attr("id");
            showPositionKecamatan(position);
        });
        
        $(".mark-kel").click(function() {
            if(infoWindowKelurahan!=null){infoWindowKelurahan.close();}
            if(kel_marker!=null){kel_marker.setMap(null);}
            var position = $(this).attr("id");
            showPositionKelurahan(position);
        });
        
        
        $('#search-map').click(function (){
            if(Smarkers!=null){Smarkers.setMap(null);}
            var input_search = $('#input_search').val();
            var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=home/search";      
            $.post(url , { search : input_search } )
                .done(function (data){
                    var d =JSON.parse(data);
                    searchMap(d);
                });
                
            
        });
        
        
        
    });
     
google.maps.event.addDomListener(window, 'load', initialize);

</script>
