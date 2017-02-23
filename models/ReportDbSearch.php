<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportDb;

/**
 * ReportDbSearch represents the model behind the search form about `app\models\ReportDb`.
 */
class ReportDbSearch extends ReportDb
{
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['dsp_name', 'db_name', 'server', 'user', 'pass', 'port', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ReportDb::find()->where(['user_id' => Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'dsp_name', $this->dsp_name])
            ->andFilterWhere(['like', 'db_name', $this->db_name])
            ->andFilterWhere(['like', 'server', $this->server])
            ->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'pass', $this->pass])
            ->andFilterWhere(['like', 'port', $this->port])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
