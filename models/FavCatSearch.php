<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FavCat;

/**
 * FavCatSearch represents the model behind the search form about `app\models\FavCat`.
 */
class FavCatSearch extends FavCat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'sort_order', 'user_id'], 'integer'],
            [['cat_name'], 'safe'],
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
        $query = FavCat::find();

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
            'cat_id' => $this->cat_id,
            'sort_order' => $this->sort_order,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'cat_name', $this->cat_name]);

        return $dataProvider;
    }
}
