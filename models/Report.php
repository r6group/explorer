<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $id
 * @property string $title
 * @property string $query_type
 * @property string $db_name
 * @property string $table_name
 * @property string $sql
 * @property string $fields
 * @property string $list_style
 * @property string $group_0
 * @property string $group_1
 * @property string $order_by
 * @property string $order_direction
 * @property integer $list_limit
 * @property string $area_fieldname
 * @property string $time_fieldname
 * @property string $area_visible
 * @property string $time_visible
 * @property string $hosp_fieldname
 * @property string $hosp_visible
 * @property integer $pagesize
 * @property string $menutype
 * @property string $column_header
 * @property string $chart_x
 * @property string $chart_y
 * @property string $chart_type
 * @property string $line1_caption
 * @property double $line1_value
 * @property string $line2_caption
 * @property double $line2_value
 * @property string $line3_caption
 * @property double $line3_value
 * @property string $line4_caption
 * @property double $line4_value
 * @property string $template
 * @property string $detail
 * @property string $note
 * @property string $keyword
 * @property integer $parent_id
 * @property string $active
 * @property string $permission
 * @property integer $user_id
 * @property string $last_update
 */
class Report extends \yii\db\ActiveRecord
{

    public $fields_param;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
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
            [['title', 'query_type'], 'required'],
            [['sql', 'fields', 'column_header', 'chart_x', 'template', 'detail', 'note', 'keyword'], 'string'],
            [['list_limit', 'pagesize', 'parent_id', 'user_id'], 'integer'],
            [['line1_value', 'line2_value', 'line3_value', 'line4_value'], 'number'],
            [['last_update','create_date'], 'safe'],
            [['title', 'table_name', 'time_fieldname', 'hosp_visible', 'chart_y', 'line1_caption', 'line2_caption', 'line3_caption', 'line4_caption', 'permission'], 'string', 'max' => 255],
            [['query_type', 'list_style', 'active'], 'string', 'max' => 1],
            [['db_name', 'hosp_fieldname'], 'string', 'max' => 80],
            [['group_0', 'group_1', 'order_by', 'order_direction', 'area_fieldname'], 'string', 'max' => 120],
            [['area_visible', 'time_visible'], 'string', 'max' => 20],
            [['menutype'], 'string', 'max' => 100],
            [['chart_type'], 'string', 'max' => 2]
        ];
    }


    public function beforeSave($insert)
    {
        !empty($this->area_visible) ? $this->area_visible = implode(",", $this->area_visible) : $this->area_visible = null;
        !empty($this->time_visible) ? $this->time_visible = implode(",", $this->time_visible) : $this->time_visible = null;
        !empty($this->hosp_visible) ? $this->hosp_visible = implode(",", $this->hosp_visible) : $this->hosp_visible = null;
        !empty($this->chart_x) ? $this->chart_x = implode(",", $this->chart_x) : $this->chart_x = null;

        if ($insert) {
            $this->user_id = Yii::$app->user->identity->getId();
            $this->create_date = date('Y-m-d h:i:sa');
        }

        return parent::beforeSave($insert);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'ชื่อรายงาน',
            'sql' => 'SQL',
            'area_fieldname' => 'Field ที่ใช้ระบุขอบเขตพื้นที่',
            'time_fieldname' => 'Field ที่ใช้ระบุช่วงเวลา',
            'area_visible' => 'ชอบเขตพื้นที่ ที่เป็นตัวเลือกให้แสดงรายงานได้',
            'time_visible' => 'ขอบเขตช่วงเวลา ที่เป็นตัวเลือกให้แสดงรายงานได้',
            'hosp_fieldname' => 'ชื่อ Filed รหัสหน่วยบริการ',
            'hosp_visible' => 'ขอบเขตหน่วยบริการ ที่เป็นตัวเลือกให้แสดงรายงานได้',
            'menutype' => 'ปรากฏในเมนู',
            'chart_type'=> 'Chart Type',
            'chart_x' => 'ชื่อ Field เพื่อแสดง Chart ในแกน X',
            'chart_y' => 'ชื่อ Field เพื่อแสดง Chart ในแกน Y',
            'template' => 'HTML Template',
            'parent_id' => 'Parent ID',
            'query_type' => 'วิธีประมวลผล',
            'table_name' => 'Table name',
            'group_0' => 'Group level #1',
            'group_1' => 'Group level #2',
            'order_by' => 'Order by',
            'order_direction' => 'Order Direction',
            'list_limit' => 'Limit',
            'db_name' => 'ฐานข้อมูล',
            'list_style'=> 'รูปแบบการแสดงผล',
            'pagesize'=> 'จำนวน Record per page',
            'note' => 'หมายเหตุ',
            'column_header' => 'Before columns header',
            'permission' => 'ผู้ที่เข้าถึงข้อมูลนี้ได้',
            'line1_caption' => 'Caption#1',
            'line1_value' => 'Value#1',
            'line2_caption' => 'Caption#2',
            'line2_value' => 'Value#2',
            'line3_caption' => 'Caption3',
            'line3_value' => 'Value3',
            'line4_caption' => 'Caption4',
            'line4_value' => 'Value4',
            'detail' => 'Detail',
            'keyword' => 'Keyword',
            'active' => 'เผยแพร่',
            'user_id' => 'User ID',
            'last_update' => 'Last Update',
        ];
    }
}
