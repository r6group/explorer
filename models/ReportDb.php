<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report_db".
 *
 * @property integer $id
 * @property string $dsp_name
 * @property string $db_name
 * @property string $server
 * @property string $user
 * @property string $pass
 * @property string $port
 * @property integer $user_id
 * @property string $status
 */
class ReportDb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_db';
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
            [['user_id'], 'integer'],
            [['dsp_name', 'db_name'], 'string', 'max' => 60],
            [['server'], 'string', 'max' => 20],
            [['user', 'pass'], 'string', 'max' => 80],
            [['port'], 'integer'],
            [['status'], 'string', 'max' => 2]
        ];
    }


    public function beforeSave($insert)
    {
        if ($insert) {$this->user_id = Yii::$app->user->identity->getId();}

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dsp_name' => 'Display Name',
            'db_name' => 'DB Name',
            'server' => 'DB Server Address',
            'user' => 'DB Username',
            'pass' => 'DB Password',
            'port' => 'DB Port',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
}
