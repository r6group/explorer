<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use common\models\Profile;



/* @var $this yii\web\View */
$this->title = $admin_title;
$this->params['breadcrumbs'][] = $this->title;



$formatJs = <<< 'JS'
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var avatar_url = repo.avatar_url;
    if (avatar_url == null) {
    avatar_url = "unknown_user.png";
    }

    var markup =
'<div class="row">' +
    '<div class="col-sm-12">' +
        '<img src="http://www.sko.moph.go.th/images/avatars/' + avatar_url + '" class="img-circle" style="width:30px" />' +
        '<b style="margin-left:5px">' + repo.name + ' ' + repo.surname + ' <i class="fa fa-briefcase"></i> ' + repo.off_id + '</b>' +
    '</div>' +
'</div>';

    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    if (repo.name) {
        return repo.name + " " + repo.surname;
    } else {
        return repo.text;
    }

}
JS;

// Register the formatting script
$this->registerJs($formatJs, $this::POS_HEAD);

// script to parse the results into the format expected by Select2
$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data.items,
        pagination: {
            more: (params.page * 30) < data.total_count
        }
    };
}
JS;



?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>

<div class="project-section general-info">
<dl class="dl-horizontal">

    <dt>Team:</dt>
    <dd>
        <ul class="list-inline team-list">
            <?php
            $off_id = '';
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($off_id != $data[$i]['off_id']) {
                    $off_id = $data[$i]['off_id'];
                    echo '<p><span class="label label-success">'.common\models\CHospital::getHospitalName($data[$i]['off_id']).'</span></p>';
                }

               ?>

                <li>
                    <a href="<?=Url::toRoute(['setting/profile', 'id' => $data[$i]['user_id']])?>"><img src="<?=Profile::getAvatarByUserId($data[$i]['user_id'])?>" class="img-circle" alt="Avatar">
                    <p><strong><?=Profile::getFullNameByUserId($data[$i]['user_id'])?></strong></p></a>
                    <span class="text-muted"><?=common\models\CPosition::getPositionName($data[$i]['main_pst'])?></span>
                    <?= Html::beginForm([''], 'post', ['data-pjax' => '', 'class' => 'form-inline', 'id' => 'user'.$data[$i]['user_id']]); ?>

                    <input type="hidden" name="user_id" value="<?=$data[$i]['user_id']?>">
                    <input type="hidden" name="remove" value="true">
                    <?= Html::submitButton('remove[-]', ['class' => 'btn btn-xs btn-primary', 'name' => 'remove-btn', 'onclick' => 'return confirm("คุณยืนยันการลบหรือไม่?");return false;']) ?>

                    <?= Html::endForm() ?>
                </li>

            <?php
            }
            ?>

        </ul>

        <?= Html::beginForm([''], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
        <div class="form-group col-md-6">
            <?=Select2::widget([
                'name' => 'user_id',
                'value' => '',
                'initValueText' => '',
                'options' => ['placeholder' => 'เพิ่มบุคคล ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['user-list']),
                        'dataType' => 'json',
                        'delay' => 250,
                        'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                        'processResults' => new JsExpression($resultsJs),
                        'cache' => true
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('formatRepo'),
                    'templateSelection' => new JsExpression('formatRepoSelection'),
                ],
            ]);?>
        </div>
        <?= Html::submitButton('Add[+]', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>

        <?= Html::endForm() ?>
    </dd>
</dl>
</div>


<?php Pjax::end(); ?>

