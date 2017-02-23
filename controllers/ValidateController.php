<?php
namespace phi\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use app\models\s;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use app\models\MenuSearch;

/**
 * Site controller
 */
class ValidateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $connection = Yii::$app->db_varidate_icd;

        $querytype = $connection->createCommand("
            SELECT
tt.hospcode,
tt.hosname,
CASE tt.`DISTCODE`
  WHEN '01' THEN 'เมืองสระแก้ว'
  WHEN '02' THEN 'คลองหาด'
  WHEN '03' THEN 'ตาพระยา'
  WHEN '04' THEN 'วังน้ำเย็น'
  WHEN '05' THEN 'วัฒนานคร'
  WHEN '06' THEN 'อรัญประเทศ'
  WHEN '07' THEN 'เขาฉกรรจ์'
  WHEN '08' THEN 'โคกสูง'
  WHEN '09' THEN 'วังสมบูรณ์'
 END as 'อำเภอ',
tt.typearea1,
            tt.typearea2,
            tt.typearea3,
            tt.typearea4,
            tt.typearea5,
            tt.TYPEAREA1 + tt.TYPEAREA3 AS sum1_3,
            IFNULL(s.repeatedly,0) repeatedly
            FROM
            total_type tt
            LEFT JOIN
            (SELECT
            HOSPCODE,
            COUNT(CID) AS repeatedly
            FROM
            check_type
            GROUP BY HOSPCODE) s ON tt.HOSPCODE = s.HOSPCODE
            ORDER BY tt.distcode ASC, s.repeatedly DESC")->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $querytype,
            'sort' => ['attributes' => ['hospcode','hosname', 'อำเภอ', 'typearea1', 'typearea2', 'typearea3', 'typearea4', 'typearea5','sum1_3','repeatedly']
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionHospcode()
    {
        $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');

        if (\Yii::$app->user->isGuest) {
            return $this->render('/site/error', [
                'name' => '403 Forbidden',
                'message' => 'คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้' , //$e->getMessage(),

            ]);
        }


        if (!\Yii::$app->user->identity->checkHospcode([$hospcode], ['3250200214431', '1251100063885'])) {
            return $this->render('errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => '(' . Yii::$app->user->identity->getHospcode() . ') คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลนี้'
                ]
            );
        } else {

            $connection = Yii::$app->db_varidate_icd;
            //$searchModel = new ChecktypeSearch();
            $querytype = $connection->createCommand("
SELECT check_type.HOSPCODE,
	check_type.PID,
	check_type.CID,
	check_type.`NAME`,
	check_type.LNAME,
	check_type.TYPEAREA,
	check_type.HOUSENO,
	check_type.VILLAGE,
	check_type.TAMBON,
	check_type.AMPUR,
	check_type.CHANGWAT,
	d.HOSPCODE_T,
	check_type.D_UPDATE
FROM check_type
INNER JOIN (SELECT
	check_type.CID,
	GROUP_CONCAT(check_type.HOSPCODE ) AS HOSPCODE_T
FROM check_type
GROUP BY CID
HAVING FIND_IN_SET('" . $hospcode . "',HOSPCODE_T) > 0
) d ON d.CID = check_type.CID
WHERE check_type.HOSPCODE = '" . $hospcode . "'
ORDER BY check_type.D_UPDATE DESC

        "
            )->queryAll();
            // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider = new ArrayDataProvider([
                'allModels' => $querytype,
                'sort' => ['attributes' => ['CID', 'HOSPCODE',]
                ],
            ]);
            return $this->render('hospcode', [
                'dataProvider' => $dataProvider,


            ]);
        }
    }

    /**
     * Displays a single Checktype model.
     * @param string $HOSPCODE
     * @param string $PID
     * @return mixed
     */
    public function actionPersondulp($HOSPCODE, $CID)
    {
        $connection = Yii::$app->db_varidate_icd;
        //$searchModel = new ChecktypeSearch();
        $querytype = $connection->createCommand("
        SELECT
        CID,
        CONCAT(NAME,' ',LNAME) as FULLNAME,
        TYPEAREA,
        PID,
        HOSPCODE,
        HOSNAME,
        HOUSENO,
        VILLAGE,
        TAMBON,
        AMPUR,
        CHANGWAT,
        D_UPDATE
        FROM
        check_type
        where CID = '".$CID."'
        order by D_UPDATE DESC
        ")->queryAll();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $querytype,
            'sort' => ['attributes' => ['CID', 'HOSPCODE', ]
            ],
        ]);
        return $this->render('persondulp', [
            'dataProvider' => $dataProvider,
        ]);

    }


}