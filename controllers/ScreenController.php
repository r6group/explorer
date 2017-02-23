<?php
namespace phi\controllers;

use yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use common\models\Profile;


class ScreenController extends Controller
{
    public function actionSumhtscreen()
    {

        $where_sql = '';
        if (!\Yii::$app->user->isGuest) {
            $profileModel = Profile::findOne(['user_id' => Yii::$app->user->identity->getId()]);

            if (!empty($profileModel) & ($profileModel->off_id <> '')) {

                $where_sql = " AND t_person_ht_screen.hospcode = '". $profileModel->off_id ."'";
            }
        }


        $connection = Yii::$app->db_analysis;

        $sumhtscreen = $connection->createCommand("
        SELECT
        t_person_ht_screen.hospcode,
        REPLACE(REPLACE(chospital.hosname,'โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.'),'โรงพยาบาล','รพ.') AS hosname,
        SUM(IF(t_person_ht_screen.sbp <> '0','1','')) AS HT_screen,
        SUM(IF(t_person_ht_screen.sbp = '0','1','')) AS HT_No_screen
        ,COUNT(t_person_ht_screen.hospcode) target
        FROM
        t_person_ht_screen
        left JOIN chospital ON t_person_ht_screen.HOSPCODE = chospital.hoscode
        WHERE chospital.provcode = '27'".$where_sql."
        GROUP BY t_person_ht_screen.hospcode
        ")->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $sumhtscreen,
            'pagination' => [
                'pageSize' => 200,
            ],

        ]);

        return $this->render('sumhtscreen', [
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionHtscreen()
    {
        $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');
        if (!\Yii::$app->getRequest()->getQueryParam('hospcode')) {
            Yii::$app->session->setFlash('error', 'There was an error provid cannot be null.');
            return $this->render('error');
        }

        if ((Yii::$app->user->isGuest) || (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885']))) {
            $hospcode = Yii::$app->user->isGuest? 'Guest' : Yii::$app->user->identity->getHospcode();

            return $this->render('errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => '(' . $hospcode . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
                ]
            );
        } else {


            $connection = Yii::$app->db_analysis;

            $htscreen = $connection->createCommand("
            SELECT
            t_person_ht_screen.hospcode,
            t_person_ht_screen.cid,
            t_person_ht_screen.pid,
            CONCAT(p.`NAME`,'  ',p.LNAME) fullname,
            t_person_ht_screen.age_y,
            h.HOUSE,
            h.VILLAGE,
            ctambon.tambonname,
            t_person_ht_screen.date_screen
            FROM
            t_person_ht_screen
            LEFT JOIN person AS p ON p.HOSPCODE = t_person_ht_screen.hospcode AND p.CID = t_person_ht_screen.cid
            LEFT JOIN home AS h ON p.HOSPCODE = h.HOSPCODE AND p.HID = h.HID
            LEFT JOIN ctambon ON  LEFT(t_person_ht_screen.areacode,6) = ctambon.tamboncodefull
            WHERE t_person_ht_screen.sbp <> 0
            AND h.CHANGWAT = 27
            AND t_person_ht_screen.hospcode = $hospcode
            ORDER BY t_person_ht_screen.age_y DESC
            ")->queryAll();

            $dataProvider = new ArrayDataProvider([
                'allModels' => $htscreen,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
            return $this->render('htscreen', [
                'dataProvider' => $dataProvider
            ]);
        }
    }

    public function actionHtnoscreen()
    {
        $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');

        if (!\Yii::$app->getRequest()->getQueryParam('hospcode')) {
            Yii::$app->session->setFlash('error', 'There was an error provid cannot be null.');
            return $this->render('error');
        }

        if ((Yii::$app->user->isGuest) || (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885']))) {
            $hospcode = Yii::$app->user->isGuest? 'Guest' : Yii::$app->user->identity->getHospcode();

            return $this->render('errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => '(' . $hospcode . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
                ]
            );
        } else {
            $connection = Yii::$app->db_analysis;

            $htnoscreen = $connection->createCommand("
            SELECT
            t_person_ht_screen.hospcode,
            t_person_ht_screen.cid,
            t_person_ht_screen.pid,
            CONCAT(p.`NAME`,'  ',p.LNAME) fullname,
            t_person_ht_screen.age_y,
            h.HOUSE,
            h.VILLAGE,
            ctambon.tambonname,
            t_person_ht_screen.date_screen
            FROM
            t_person_ht_screen
            LEFT JOIN person AS p ON p.HOSPCODE = t_person_ht_screen.hospcode AND p.CID = t_person_ht_screen.cid
            LEFT JOIN home AS h ON p.HOSPCODE = h.HOSPCODE AND p.HID = h.HID
            LEFT JOIN ctambon ON  LEFT(t_person_ht_screen.areacode,6) = ctambon.tamboncodefull
            WHERE t_person_ht_screen.sbp = 0
            AND h.CHANGWAT = 27
            AND t_person_ht_screen.hospcode = $hospcode
            ORDER BY t_person_ht_screen.age_y DESC
            ")->queryAll();


            $dataProvider = new ArrayDataProvider([
                'allModels' => $htnoscreen,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);


            return $this->render('htnoscreen', [
                'dataProvider' => $dataProvider
            ]);
        }
    }

    public function actionSumdmscreen()
    {

        $where_sql = '';
        if (!\Yii::$app->user->isGuest) {
            $profileModel = Profile::findOne(['user_id' => Yii::$app->user->identity->getId()]);

            if (!empty($profileModel) & ($profileModel->off_id <> '')) {

                $where_sql = " AND t_person_dm_screen.hospcode = '". $profileModel->off_id ."'";
            }
        }


        $connection = Yii::$app->db_analysis;

        $sumdmscreen = $connection->createCommand("
        SELECT
        t_person_dm_screen.hospcode,
        REPLACE(REPLACE(chospital.hosname,'โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.'),'โรงพยาบาล','รพ.') AS hosname,
        SUM(IF(t_person_dm_screen.bslevel <> '0','1','')) AS DM_screen,
        SUM(IF(t_person_dm_screen.bslevel = '0','1','')) AS DM_No_screen
        ,COUNT(t_person_dm_screen.hospcode) target
        FROM
        t_person_dm_screen
        left JOIN chospital ON t_person_dm_screen.HOSPCODE = chospital.hoscode
        WHERE chospital.provcode = '27'".$where_sql."
        GROUP BY t_person_dm_screen.hospcode
        ")->queryAll();


        $dataProvider = new ArrayDataProvider([
            'allModels' => $sumdmscreen,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);


        return $this->render('sumdmscreen', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDmscreen()
    {
        $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');

        if (!\Yii::$app->getRequest()->getQueryParam('hospcode')) {
            Yii::$app->session->setFlash('error', 'There was an error provid cannot be null.');
            return $this->render('error');
        }

        if ((Yii::$app->user->isGuest) || (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885']))) {
            $hospcode = Yii::$app->user->isGuest? 'Guest' : Yii::$app->user->identity->getHospcode();

            return $this->render('errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => '(' . $hospcode . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
                ]
            );
        } else {


            $connection = Yii::$app->db_analysis;

            $dmscreen = $connection->createCommand("
            SELECT
            t_person_dm_screen.hospcode,
            t_person_dm_screen.cid,
            t_person_dm_screen.pid,
            CONCAT(p.`NAME`,'  ',p.LNAME) fullname,
            t_person_dm_screen.age_y,
            h.HOUSE,
            h.VILLAGE,
            ctambon.tambonname,
            t_person_dm_screen.date_screen
            FROM
            t_person_dm_screen
            LEFT JOIN person AS p ON p.HOSPCODE = t_person_dm_screen.hospcode AND p.CID = t_person_dm_screen.cid
            LEFT JOIN home AS h ON p.HOSPCODE = h.HOSPCODE AND p.HID = h.HID
            LEFT JOIN ctambon ON  LEFT(t_person_dm_screen.areacode,6) = ctambon.tamboncodefull
            WHERE t_person_dm_screen.bslevel <> 0
            AND h.CHANGWAT = 27
            AND t_person_dm_screen.hospcode = $hospcode
            ORDER BY t_person_dm_screen.age_y DESC
            ")->queryAll();


            $dataProvider = new ArrayDataProvider([
                'allModels' => $dmscreen,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);


            return $this->render('dmscreen', [
                'dataProvider' => $dataProvider
            ]);
        }
    }

    public function actionDmnoscreen()
    {
        $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');
        if (!\Yii::$app->getRequest()->getQueryParam('hospcode')) {
            Yii::$app->session->setFlash('error', 'There was an error hospcode cannot be null.');
            return $this->render('error',
                ['message' => '']
            );
        }

        if ((Yii::$app->user->isGuest) || (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885']))) {
            $hospcode = Yii::$app->user->isGuest? 'Guest' : Yii::$app->user->identity->getHospcode();

            return $this->render('errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => '(' . $hospcode . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
                ]
            );
        } else {

            $connection = Yii::$app->db_analysis;

            $dmnoscreen = $connection->createCommand("
            SELECT
            t_person_dm_screen.hospcode,
            t_person_dm_screen.cid,
            t_person_dm_screen.pid,
            CONCAT(p.`NAME`,'  ',p.LNAME) fullname,
            t_person_dm_screen.age_y,
            h.HOUSE,
            h.VILLAGE,
            ctambon.tambonname,
            '' date_screen
            FROM
            t_person_dm_screen
            LEFT JOIN person AS p ON p.HOSPCODE = t_person_dm_screen.hospcode AND p.CID = t_person_dm_screen.cid
            LEFT JOIN home AS h ON p.HOSPCODE = h.HOSPCODE AND p.HID = h.HID
            LEFT JOIN ctambon ON  LEFT(t_person_dm_screen.areacode,6) = ctambon.tamboncodefull
            WHERE t_person_dm_screen.bslevel = 0
            AND h.CHANGWAT = 27
            AND t_person_dm_screen.hospcode = $hospcode
            ORDER BY t_person_dm_screen.age_y DESC
            ")->queryAll();


            $dataProvider = new ArrayDataProvider([
                'allModels' => $dmnoscreen,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);


            return $this->render('dmnoscreen', [
                'dataProvider' => $dataProvider
            ]);
        }
    }
}
