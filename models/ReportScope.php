<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report_scope".
 *
 * @property string $region
 * @property string $province
 * @property string $district
 * @property string $subdistrict
 * @property string $village
 * @property string $hospcode
 * @property string $startdate
 * @property string $enddate
 * @property string $govyear
 * @property integer $user_id
 */
class ReportScope extends \yii\db\ActiveRecord
{
    public $id;
    public $reports;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_scope';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_phis');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['startdate', 'enddate'], 'date', 'format' => 'php:Y-m-d'],
            [['user_id'], 'integer'],
            [['region', 'province'], 'string', 'max' => 2],
            [['district', 'govyear'], 'string', 'max' => 4],
            [['subdistrict'], 'string', 'max' => 6],
            [['village'], 'string', 'max' => 8],
            [['hospcode'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'เขตสุขภาพ',
            'province' => 'จังหวัด',
            'district' => 'อำเภอ',
            'subdistrict' => 'ตำบล',
            'village' => 'หมู่บ้าน',
            'hospcode' => 'สถานบริการ',
            'startdate' => 'จากวันที่',
            'enddate' => 'ถึงวันที่',
            'govyear' => 'ปีงบประมาณ',
            'user_id' => 'User ID',
            'scope' => 'ขอบเขตข้อมูล',
            'timescope'=> 'ขอบเขตช่วงเวลา',
        ];
    }
}
