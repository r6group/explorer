<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fav_item".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $report_id
 * @property string $report_title
 * @property string $report_url
 * @property integer $sort_order
 * @property integer $user_id
 *
 * @property FavCat $cat
 */
class FavItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fav_item';
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
            [['cat_id', 'report_id', 'sort_order', 'user_id'], 'integer'],
            [['report_url'], 'string'],
            [['report_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'report_id' => 'Report ID',
            'report_title' => 'Report Title',
            'report_url' => 'Report Url',
            'sort_order' => 'Sort Order',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(FavCat::className(), ['cat_id' => 'cat_id']);
    }
}
