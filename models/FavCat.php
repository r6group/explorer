<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fav_cat".
 *
 * @property integer $cat_id
 * @property string $cat_name
 * @property integer $sort_order
 * @property integer $user_id
 *
 * @property FavItem[] $favItems
 */
class FavCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fav_cat';
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
            [['sort_order', 'user_id'], 'integer'],
            [['cat_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'cat_name' => 'Cat Name',
            'sort_order' => 'Sort Order',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavItems()
    {
        return $this->hasMany(FavItem::className(), ['cat_id' => 'cat_id']);
    }
}
