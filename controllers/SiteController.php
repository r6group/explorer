<?php
namespace phi\controllers;

use common\models\CDistrict;
use common\models\CHospital;
use Yii;
use common\models\LoginForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//use yii\data\ArrayDataProvider;
//use app\models\s;
//use yii\helpers\ArrayHelper;
use common\models\Profile;
use app\models\MenuSearch;
use yii\authclient\OAuth2;
//use yii\authclient\OpenId;
//use app\models\ReportSearch;


/**
 * Site controller
 */
class SiteController extends Controller
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

        //return $this->renderContent(null);
        $searchModel = new MenuSearch();


        $lock_locate = Yii::$app->getRequest()->getQueryParam('lock_locate');
        $active_tab = Yii::$app->getRequest()->getQueryParam('tab');

        if ($lock_locate == 'no') {
            $cookies = Yii::$app->response->cookies;

            $cookies->remove('scope');
            unset($cookies['scope']);
            $cookies->remove('region');
            unset($cookies['region']);
            $cookies->remove('province');
            unset($cookies['province']);
            $cookies->remove('district');
            unset($cookies['district']);
            $cookies->remove('subdistrict');
            unset($cookies['subdistrict']);
            $cookies->remove('hospcode');
            unset($cookies['hospcode']);
            $cookies->remove('lock_locate');
            unset($cookies['lock_locate']);
        }

        $models = CDistrict::find()->where(['changwatcode' => Yii::$app->config->get('PHI.DEFAULT_PROVINCE')])->all();
        $models_tambon = \common\models\CSubdistrict::find()->where(['changwatcode' => Yii::$app->config->get('PHI.DEFAULT_PROVINCE')])->orderBy('`tamboncodefull` ASC')->all();
        $models_hos = CHospital::find()->where('hostype NOT IN (\'01\', \'02\', \'09\', \'10\', \'11\', \'12\', \'13\', \'14\', \'15\',\'16\',\'20\')')->andWhere(['provcode' => Yii::$app->config->get('PHI.DEFAULT_PROVINCE')])->orderBy('`provcode` ASC,`distcode` ASC,`hostype` DESC')->all();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'models' => $models,
            'models_tambon' => $models_tambon,
            'models_hos' => $models_hos,
            'active_tab' => $active_tab,

        ]);

    }

    public function actionMap(){
        $hospital = CHospital::find()->where(['provcode' => 27])->all();
        return $this->render('map', ['hospital' => $hospital]);
    }


    public function actionKpi(){
        return $this->render('kpi');
    }


    public function actionHealthProfile()
    {

        //return $this->renderContent(null);
        $searchModel = new MenuSearch();



        $lock_locate = Yii::$app->getRequest()->getQueryParam('lock_locate');

        if (isset($lock_locate)) {
            $cookies = Yii::$app->response->cookies;

            $cookies->remove('scope');
            unset($cookies['scope']);
            $cookies->remove('region');
            unset($cookies['region']);
            $cookies->remove('province');
            unset($cookies['province']);
            $cookies->remove('district');
            unset($cookies['district']);
            $cookies->remove('subdistrict');
            unset($cookies['subdistrict']);
            $cookies->remove('hospcode');
            unset($cookies['hospcode']);

            if ($lock_locate == 'yes'){

                $cookies->add(new \yii\web\Cookie([
                    'name' => 'lock_locate',
                    'value' => 'yes',
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'scope',
                    'value' => Yii::$app->getRequest()->getQueryParam('scope'),
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'region',
                    'value' => Yii::$app->getRequest()->getQueryParam('region'),
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'province',
                    'value' => Yii::$app->getRequest()->getQueryParam('province'),
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'district',
                    'value' => Yii::$app->getRequest()->getQueryParam('district'),
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'subdistrict',
                    'value' => Yii::$app->getRequest()->getQueryParam('subdistrict'),
                ]));
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'hospcode',
                    'value' => Yii::$app->getRequest()->getQueryParam('hospcode'),
                ]));

            } else {
                $cookies->remove('lock_locate');
                unset($cookies['lock_locate']);

            }
        }


        $lock_locate_request = $lock_locate;
        $lock_locate_request = isset($lock_locate_request) ? $lock_locate_request : '';
        $cookies = Yii::$app->request->cookies;
        $lock_locate_cookie = $cookies->getValue('lock_locate', 'no');

        $scope = '';
        $region = '';
        $province = '';
        $district = '';
        $subdistrict = '';
        $hospcode= '';
        $locate = '';

        if (($lock_locate_cookie == 'yes' || $lock_locate_request == 'yes') && $lock_locate_request <> 'no') {
            if ($lock_locate_request == 'yes') {
                $scope = Yii::$app->getRequest()->getQueryParam('scope');
                $region = Yii::$app->getRequest()->getQueryParam('region');
                $province = Yii::$app->getRequest()->getQueryParam('province');
                $district = Yii::$app->getRequest()->getQueryParam('district');
                $subdistrict = Yii::$app->getRequest()->getQueryParam('subdistrict');
                $hospcode = Yii::$app->getRequest()->getQueryParam('hospcode');

            } else if ($lock_locate_cookie == 'yes') {
                $scope = $cookies->getValue('scope', '');
                $region = $cookies->getValue('region', '');
                $province = $cookies->getValue('province', '');
                $district = $cookies->getValue('district', '');
                $subdistrict = $cookies->getValue('subdistrict', '');
                $hospcode = $cookies->getValue('hospcode', '');
            }



            switch ($scope) {
                case '1'://SCOPE_REGION
                    $locate = 'เขตสุขภาพที่ ' . $region;
                    break;
                case '2'://SCOPE_PROVINCE
                    $locate = 'จังหวัด' . \common\models\CProvince::getProvinceName($province);
                    break;
                case '3'://SCOPE_DISTRICT
                    $locate = 'อ.' . \common\models\CDistrict::getDistrictName($district) . ' จ.' . \common\models\CProvince::getProvinceName($province);
                    break;
                case '4'://SCOPE_SUBDISTRICT
                    $locate = 'ต.' . \common\models\CSubdistrict::getSubdistrictName($subdistrict) . ' อ.' . \common\models\CDistrict::getDistrictName($district) . ' จ.' . \common\models\CProvince::getProvinceName($province);
                    break;
                case '5'://SCOPE_CUP
                    $locate = 'CUP ' . \common\models\CHospital::getHospitalName($hospcode);
                    break;
                case '6'://SCOPE_HEALTH_UNIT
                    $locate = '['.$hospcode. '] '.\common\models\CHospital::getHospitalName($hospcode) . ' อ.' . \common\models\CDistrict::getDistrictName($district) . ' จ.' . \common\models\CProvince::getProvinceName($province);
                    break;
            }
        }

//        $models = CDistrict::find()->where(['changwatcode' => Yii::$app->config->get('PHI.DEFAULT_PROVINCE')])->all();
        $models_hos = CHospital::findOne(['hoscode'=> $hospcode]);


        return $this->render('health-profile', [
            'searchModel' => $searchModel,
//            'models' => $models,
            'models_hos' => $models_hos,
            'locate' => $locate,
            'scope' => $scope,
            'region' => $region,
            'province' => $province,
            'district' => $district,
            'subdistrict' => $subdistrict,
            'hospcode' => $hospcode,

        ]);

    }


    public function actionClearCache()
    {

        //return $this->renderContent(null);


        $r = Yii::$app->cache->flush();


        return $this->render('about');

    }




    public function actionAuth()
    {
        $accessToken = '';
        $oauthClient = new OAuth2();
        $oauthClient->authUrl = 'https://www.getpostman.com/oauth2/callback';
        $oauthClient->tokenUrl = 'http://api.loc/oauth2/token';
        $oauthClient->clientId = 'testclient';
        $oauthClient->clientSecret = 'testpass';


//        $url = $oauthClient->buildAuthUrl(); // Build authorization URL
//        $accessToken = $oauthClient->getAccessToken();

        $url = $oauthClient->buildAuthUrl(); // Build authorization URL
        Yii::$app->getResponse()->redirect($url); // Redirect to authorization URL.
// After user returns at our site:
        //$code = $_GET['code'];
        //$accessToken = $oauthClient->fetchAccessToken($code); // Get access token


        return $accessToken;

    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = '/login_layout';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        //return $this->render('../../../frontend/modules/user/views/default/index');
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                \Yii::$app->session->setFlash('success', 'กรุณาตรวจสอบใน email ของคุณเพื่อยืนยันการลงทะเบียน: ' . $model->email);
                return $this->goHome();
            }
        }

        $this->layout = '/login_layout';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionConfirm($id, $key)
    {
        $user = \common\models\User::find()->where([
            'id' => $id,
            'auth_key' => $key,
            'status' => \common\models\User::STATUS_NEW,
        ])->one();
        if (!empty($user)) {
            $user->generateAuthKey();
            $user->changeUserStatusNewToActive(); //$user will be save in this step.

            Yii::$app->getSession()->setFlash('success', 'ยินดีต้อนรับ คุณ '.$user->FullName.', การลงทะเบียนได้รับการยืนยันแล้ว.');

            if (Yii::$app->user->login($user, 0)) {
                return $this->goHome();
            }

//            $model = new LoginForm();
//            $model->email = $user->email;
//
//            Yii::$app->user->logout();
//            return $this->render('login', [
//                'model' => $model,
//            ]);

        } else {
            Yii::$app->getSession()->setFlash('warning', 'Failed!');

        }
        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
