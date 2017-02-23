<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\ReportScope;

/**
 * s represents the model behind the search form about `app\models\ReportScope`.
 */
class s extends ReportScope
{
    public $id;
    public $repid;
    public $catid;
    public $reports;
    public $scope;
    Public $timescope;
    public $cup;
    public $hospcode;


    /** Scope */
    const SCOPE_REGION = 1;
    const SCOPE_PROVINCE = 2;
    const SCOPE_DISTRICT = 3;
    const SCOPE_SUBDISTRICT = 4;
    const SCOPE_CUP = 5;
    const SCOPE_HEALTH_UNIT = 6;

    /** Time Scope */
    const SCOPE_TIME_DATE = 1;
    const SCOPE_TIME_YEAR = 2;
    const SCOPE_TIME_GOVYEAR = 3;

    /** Region */
    const REGION_1 = '01';
    const REGION_2 = '02';
    const REGION_3 = '03';
    const REGION_4 = '04';
    const REGION_5 = '05';
    const REGION_6 = '06';
    const REGION_7 = '07';
    const REGION_8 = '08';
    const REGION_9 = '09';
    const REGION_10 = '10';
    const REGION_11 = '11';
    const REGION_12 = '12';
    const REGION_13 = '13';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'repid', 'user_id', 'catid'], 'integer'],
            //[['reports'], 'required'],
            [['reports'], 'string'],
            [['scope', 'timescope'], 'integer'],
            //[['scope'], 'required'],
            [['startdate', 'enddate'], 'date', 'format' => 'php:Y-m-d'],
            [['region', 'province', 'district', 'subdistrict', 'village', 'hospcode', 'govyear', 'cup'], 'safe'],
        ];
    }

    /**
     * @return array Scope array.
     */
    public static function getAreaScope()
    {
        return [
            self::SCOPE_REGION => 'ระดับเขตสุขภาพ',
            self::SCOPE_PROVINCE => 'ระดับจังหวัด',
            self::SCOPE_DISTRICT => 'ระดับอำเภอ',
            self::SCOPE_SUBDISTRICT => 'ระดับตำบล',
            self::SCOPE_CUP => 'ระดับ CUP',
            self::SCOPE_HEALTH_UNIT => 'ระดับสถานพยาบาล'
        ];
    }


    /**
     * @return array Scope array.
     */
    public static function getHostype()
    {
        return ArrayHelper::map(\common\models\CHostype::find()->orderBy('hostypecode')->all(), 'hostypecode', 'hostypename');
    }

    /**
     * @return array Time Scope array.
     */
    public static function getTimeScope()
    {
        return [
            self::SCOPE_TIME_DATE => 'ช่วงวันที่',
            self::SCOPE_TIME_YEAR => 'ปี พ.ศ.',
            self::SCOPE_TIME_GOVYEAR => 'ปีงบประมาณ',

        ];
    }


    /**
     * @return array Region array.
     */
    public static function getRegion()
    {
        return [
            self::REGION_1 => 'เขตสุขภาพที่ 1',
            self::REGION_2 => 'เขตสุขภาพที่ 2',
            self::REGION_3 => 'เขตสุขภาพที่ 3',
            self::REGION_4 => 'เขตสุขภาพที่ 4',
            self::REGION_5 => 'เขตสุขภาพที่ 5',
            self::REGION_6 => 'เขตสุขภาพที่ 6',
            self::REGION_7 => 'เขตสุขภาพที่ 7',
            self::REGION_8 => 'เขตสุขภาพที่ 8',
            self::REGION_9 => 'เขตสุขภาพที่ 9',
            self::REGION_10 => 'เขตสุขภาพที่ 10',
            self::REGION_11 => 'เขตสุขภาพที่ 11',
            self::REGION_12 => 'เขตสุขภาพที่ 12',
            self::REGION_13 => 'เขตสุขภาพที่ 13',
        ];
    }


    /**
     * @return array Province array.
     */
    public static function getProvince()
    {
        return \common\models\Profile::getProvinceArray();

    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ReportScope::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'startdate' => $this->startdate,
            //'enddate' => $this->enddate,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'subdistrict', $this->subdistrict])
            ->andFilterWhere(['like', 'village', $this->village])
            ->andFilterWhere(['like', 'hospcode', $this->hospcode])
            ->andFilterWhere(['like', 'govyear', $this->govyear]);

        return $dataProvider;
    }
}
