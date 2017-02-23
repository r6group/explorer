<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Report;

/**
 * MenuSearch represents the model behind the search form about `app\models\Menu`.
 */
class MenuSearch extends Report
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['title', 'keyword', 'menutype'], 'safe'],
        ];
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
        $query = Report::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,

        ]);

        $keyword = explode(' ', $this->title);
        foreach ($keyword as $word) {
            $query->orFilterWhere(['like', 'title', $word])
                ->orFilterWhere(['like', 'keyword', $word])
                ->andFilterWhere(['=', 'active', '1'])
            ;
        }




        return $dataProvider;
    }


    public function userreport($params)
    {
        $query = Report::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,

        ]);

        $keyword = explode(' ', $this->title);
        foreach ($keyword as $word) {
            $query->andFilterWhere(['like', 'title', $word])
                ->orFilterWhere(['like', 'keyword', $word])
                ->andFilterWhere(['user_id' => Yii::$app->user->identity->getId()])
            ;
        }




        return $dataProvider;
    }
}
