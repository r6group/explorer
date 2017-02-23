<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CHospital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chospital-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'h_polygon_boundary')->widget('kolyunya\yii2\widgets\MapInputWidget',
        [

            // Google maps browser key.
            'key' => 'AIzaSyDzmgRj855NVszCo-WvCMqGTGO4qad9PAM',

            // Initial map center latitude. Used only when the input has no value.
            // Otherwise the input value latitude will be used as map center.
            // Defaults to 0.
            'latitude' => $model->h_latitude,

            // Initial map center longitude. Used only when the input has no value.
            // Otherwise the input value longitude will be used as map center.
            // Defaults to 0.
            'longitude' => $model->h_longitude,

            // Initial map zoom.
            // Defaults to 0.
            'zoom' => 12,

            // Map container width.
            // Defaults to '100%'.
            'width' => '100%',

            // Map container height.
            // Defaults to '300px'.
            'height' => '520px',

            // Coordinates representation pattern. Will be use to construct a value of an actual input.
            // Will also be used to parse an input value to show the initial input value on the map.
            // You can use two macro-variables: '%latitude%' and '%longitude%'.
            // Defaults to '(%latitude%,%longitude%)'.
            'pattern' => '%latitude%,%longitude%',

            // Google map type. See official Google maps reference for details.
            // Defaults to 'roadmap'
            'mapType' => 'roadmap',

            // Marker animation behavior defines if a marker should be animated on position change.
            // Defaults to false.
            'animateMarker' => true,

            // Map alignment behavior defines if a map should be centered when a marker is repositioned.
            // Defaults to true.
            'alignMapCenter' => false,

            // A flag which defines if a search bar should be rendered over the map.
            'enableSearchBar' => true,

        ]
    ) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
