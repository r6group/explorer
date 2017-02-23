<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2/10/59
 * Time: 17:14
 */

?>
<style>
    .info {
        padding: 6px 8px;
        background: white;
        background: rgba(255,255,255,0.8);
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
    }
    .info h4 {
        margin: 0 0 5px;
        color: #777;
    }
    .legend {
        line-height: 18px;
        color: #555;
    }
    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }

</style>


<link rel="stylesheet" href="http://203.157.145.19/leaflet/leaflet.css" />
<script src="http://203.157.145.17/hdc/main/includes/geojson_ext.php?a=27&t=1&r=442f204be9d6aec9da15786ad707d5a4&year=2016"></script>
<script src="http://203.157.145.19/leaflet/leaflet.js"></script>





<div style="width:100%; height:700px" id="map"></div>
<script type='text/javascript'>
    function getColor(d) {
        return d > 1000 ? '#800026' :
            d > 99  ? '#BD0026' :
                d > 98  ? '#E31A1C' :
                    d > 97  ? '#FC4E2A' :
                        d > 96   ? '#FD8D3C' :
                            d > 95   ? '#FEB24C' :
                                d > 10   ? '#FED976' :
                                    '#FFEDA0';
    }



    function style(feature) {
        return {
            fillColor: getColor(feature.properties.data),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }

    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }

        info.update(layer.feature.properties);
    }


    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
    }

    var mapboxAccessToken = 'pk.eyJ1Ijoic2hvbmdwb24iLCJhIjoiY2l0c295d3o3MDAwNzJ6cjI2b3prbGo2MCJ9.Ns27-EE-cdcw1N0JuyZdww';
    var map = L.map('map',{scrollWheelZoom:false}).setView([37.8, -96], 4);

//    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
//        id: 'mapbox.light',
//        //attribution: ...
//    }).addTo(map);


    geojson = L.geoJson(json_data, {style: style, onEachFeature: onEachFeature}).addTo(map);
    map.fitBounds(geojson.getBounds());


    var info = L.control();

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };

    // method that we will use to update the control based on feature properties passed
    info.update = function (props) {
        this._div.innerHTML = '<h4>Key Performance Indicator</h4>' +  (props ?
            '<b>' + props.name + '</b><br />' + props.data + ' people / mi<sup>2</sup>'
                : 'Hover over a map polygon');
    };

    info.addTo(map);


    var legend = L.control({position: 'bottomright'});

    legend.onAdd = function (map) {

        var div = L.DomUtil.create('div', 'info legend'),
            grades = [0, 10, 20, 50, 100, 200, 500, 1000],
            labels = [];

        // loop through our density intervals and generate a label with a colored square for each interval
        for (var i = 0; i < grades.length; i++) {
            div.innerHTML +=
                '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
        }

        return div;
    };

    legend.addTo(map);


</script>



