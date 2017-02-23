<?php
namespace phi\controllers;
use yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use common\models\Profile;


class EpiController extends Controller
{

  public function actionSumepi()
  {

    if (!\Yii::$app->user->isGuest) {
      $profileModel = Profile::findOne(['user_id' => Yii::$app->user->identity->getId()]);

      if (!empty($profileModel) & ($profileModel->off_id <> '')) {

        $this->redirect(
            [
                'epi',
                'hospcode' => $profileModel->off_id
            ]
        );
      }
    }



    $connection = Yii::$app->db_analysis;

    $sumepi = $connection->createCommand("
    SELECT
    tepi.hospcode,
    ch.hosname,
    COUNT(tepi.cid) as total
    FROM
    t_person_epi tepi

    LEFT JOIN chospital ch ON tepi.hospcode = ch.hoscode
        WHERE
     tepi.typearea in (1,3)
        AND timestampdiff(year,tepi.birth,NOW()) < 7
    GROUP BY tepi.hospcode
    ORDER BY ch.distcode, tepi.hospcode ASC
    " )->queryAll();

    $dataProvider = new ArrayDataProvider([
        'allModels' => $sumepi,
        'pagination' => [
            'pageSize' => 200,
        ],
      ]);

    return $this->render('sumepi',[
        'dataProvider'=>$dataProvider
      ]);
      }

      public function actionEpi($hospcode)
      {


        if ((Yii::$app->user->isGuest) || (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885', '3250400716316']))) {
          $hospcode = Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->getHospcode();

          return $this->render('//screen/errorpermission',
              [
                  'name' => '403 Forbidden',
                  'message' => '(' . $hospcode . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
              ]
          );
        } else {

          $hospname = \common\models\CHospital::findOne(['hoscode' => $hospcode])->toArray(['hosname'])['hosname'];

          $connection = Yii::$app->db_analysis;

          $epi = $connection->createCommand("
        SELECT
`t_person_epi`.`hospcode`,
`t_person_epi`.`pid`,
`t_person_epi`.`cid`,
CONCAT(person.`NAME`,'  ',person.LNAME) AS `fullname`,
`home`.`HOUSE`,
`home`.`VILLAGE`,
`home`.`VILLANAME`,
`t_person_epi`.`birth`,
IF(timestampdiff(year,t_person_epi.birth,NOW())=0,CONCAT(timestampdiff(MONTH,t_person_epi.birth,NOW()) MOD 12,' เดือน'),CONCAT(timestampdiff(year,t_person_epi.birth,NOW()),' ปี ',timestampdiff(MONTH,t_person_epi.birth,NOW()) MOD 12,' เดือน')) AS `age`,
`t_person_epi`.`bcg_hospcode`,
`t_person_epi`.`hbv1_hospcode`,
`t_person_epi`.`opv1_hospcode`,
`t_person_epi`.`dtp1_hospcode`,
`t_person_epi`.`opv2_hospcode`,
`t_person_epi`.`hbv2_hospcode`,
`t_person_epi`.`dtp2_hospcode`,
`t_person_epi`.`ipv2_hospcode`,
`t_person_epi`.`hbv3_hospcode`,
`t_person_epi`.`opv3_hospcode`,
`t_person_epi`.`dtp3_hospcode`,
`t_person_epi`.`mmr1_hospcode`,
IFNULL(je1_hospcode,j11_hospcode) AS je1_hospcode,
`t_person_epi`.`dtp4_hospcode`,
`t_person_epi`.`opv4_hospcode`,
IFNULL(je2_hospcode,j12_hospcode) AS je2_hospcode,
`t_person_epi`.`mmr2_hospcode`,
`t_person_epi`.`dtp5_hospcode`,
`t_person_epi`.`opv5_hospcode`,
CONCAT(`t_person_cid`.`NAME`, ' ' ,`t_person_cid`.`LNAME`) MOM
FROM
`t_person_epi`
JOIN `person`
ON `t_person_epi`.`hospcode` = `person`.`HOSPCODE`
AND `t_person_epi`.`cid` = `person`.`CID`
LEFT JOIN `home`
ON `person`.`HOSPCODE` = `home`.`HOSPCODE`
AND `person`.`HID` = `home`.`HID`
LEFT JOIN `t_person_cid`
ON `person`.`MOTHER` = `t_person_cid`.`CID`
WHERE
t_person_epi.hospcode = $hospcode
        AND t_person_epi.typearea in (1,3)
        AND timestampdiff(year,t_person_epi.birth,NOW()) < 7
ORDER BY
`home`.`VILLAGE` ASC,
timestampdiff(MONTH,t_person_epi.birth,NOW()) ASC
        ")->queryAll();

          $dataProvider = new ArrayDataProvider([
              'allModels' => $epi,
              'pagination' => [
                  'pageSize' => 50,
              ],
          ]);

          return $this->render('epi', [
              'dataProvider' => $dataProvider,
            'hospname'=>$hospname
          ]);
        }

      }

}
