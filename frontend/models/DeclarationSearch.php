<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Declaration;

/**
 * DeclarationSearch represents the model behind the search form of `frontend\models\Declaration`.
 */
class DeclarationSearch extends Declaration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'total', 'viewed', 'user_id'], 'integer'],
            [['title', 'description', 'date', 'city', 'category', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Declaration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'total' => $this->total,
            'viewed' => $this->viewed,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'city', $this->city])
            ->andFilterWhere(['ilike', 'category', $this->category])
            ->andFilterWhere(['ilike', 'status', $this->status]);

        return $dataProvider;
    }
}
