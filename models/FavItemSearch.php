<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FavItem;

/**
 * FavItemSearch represents the model behind the search form about `app\models\FavItem`.
 */
class FavItemSearch extends FavItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'report_id', 'sort_order', 'user_id'], 'integer'],
            [['report_url'], 'string'],
            [['report_title'], 'string', 'max' => 255]
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
        $query = FavItem::find()->where(['user_id' => Yii::$app->user->identity->id]);

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
            'cat_id' => $this->cat_id,
            'report_id' => $this->report_id,
            'report_title' => $this->report_title,
            'sort_order' => $this->sort_order,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
