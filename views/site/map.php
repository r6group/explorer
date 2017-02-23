<?php
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;

/* @var $this yii\web\View */

$this->title = 'Map';
$this->params['breadcrumbs'][] = $this->title;

$coord = new LatLng(['lat' => 13.7000905, 'lng' => 102.3577421]);
$map = new Map(['center' => $coord, 'zoom' => 10, 'width' => '100%', 'height' => '600',]);

foreach($hospital as $c){
    $coords = new LatLng(['lat' => $c->h_latitude, 'lng' => $c->h_longitude]);
    $marker = new Marker(['position' => $coords]);

    if($c->hostype < '03'){
        $marker->icon = 'http://icons.iconarchive.com/icons/icons-land/gis-gps-map/16/Hospital-icon.png';
    } elseif ($c->hostype < '06'){
        $marker->icon = 'http://www.digitalhealth.net/includes/images/gfx/icons/jobs-plus-icon.png';
    } elseif ($c->hostype < '08'){
        $marker->icon = 'https://www.edmonton.ca/attractions_events/documents/Images/zoo_map_icon_first_aid.png';
    } else {
        $marker->icon = 'http://www.digitalhealth.net/includes/images/gfx/icons/jobs-plus-icon.png';
    }

    //$marker->icon = 'http://individual.icons-land.com/IconsPreview/GISGPSMAP/PNG/Places/16x16/Hospital2.png';
    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => ' <h4>' . $c->hosname
                . '</h4> <table class="table table-striped table-bordered table-hover"> <tr> <td>ที่อยู่</td> <td>'
                . $c->address . '</td> </tr> <tr> <td>ตำบล</td> <td>'
                . $c->subdistcode
                . '</td> </tr> <tr> <td>อำเภอ</td> <td>'
                . $c->distcode
                . '</td> </tr> <tr> <td>จังหวัด</td> <td>'
                . $c->provcode
                . '</td> </tr> <tr> <td>จำนวนเตียง</td> <td>'
                . $c->bed . '</td> </tr> </table> '
        ])
    );

    $map->addOverlay($marker);
}



?>

<div>

    <h3 class="panel-title mb5">แผนที่หน่วยบริการจังหวัดสระแก้ว</h3>


    <div class="panel panel-map-sidebar">
        <div class="row">
            <div class="col-md-8 main">
                <?php echo $map->display(); ?>
            </div>
            <div class="col-md-4 map-sidebar">
                <div class="panel-body">
                    <h4 class="panel-title mb20">ขอเส้นทาง</h4>
                    <p>Type or click the map to enter your starting point and end point of your trip.</p>


                    <form class="form" action="#">
                        <div class="form-group">
                            <label class="control-label">จาก:</label>
                            <input type="text" class="form-control" placeholder="San Francisco, CA, USA">
                        </div>
                        <div class="form-group">
                            <label class="control-label">ถึง:</label>
                            <input type="text" class="form-control" placeholder="New York, NY, USA">
                        </div>

                        <div class="form-group">
                            <label class="control-label">พาหนะ:</label>
                            <div class="btn-group">
                                <button class="btn btn-default" type="button"><i class="fa fa-bicycle"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-train"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-bus"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-ship"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-plane"></i></button>
                            </div>
                        </div>

                        <hr>

                        <button class="btn btn-success btn-block">Get Directions</button>

                    </form>
                </div>
            </div>
        </div>
    </div><!-- panel -->

</div><!-- col-md-4 -->

