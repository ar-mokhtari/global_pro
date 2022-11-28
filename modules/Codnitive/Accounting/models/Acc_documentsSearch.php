<?php

namespace app\modules\codnitive\accounting\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Acc_documentsSearch represents the model behind the search form of `app\modules\codnitive\accounting\models\Acc_documents`.
 */
class Acc_documentsSearch extends Acc_documents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'doc_id', 'TopicCode', 'DetailCode', 'CTopicCode1', 'CTopicCode2', 'CTopicCode3', 'Debit', 'Credit'], 'integer'],
            [['Comment'], 'safe'],
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
    public function search($params, $doc_id = 1)
    {
        $query = Acc_documents::find()->where(['doc_id' => $doc_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' =>
                [
                    'pageSizeParam' => false,
//                    'pageSize' => 2
                ],
            'sort' =>
                [
                    'defaultOrder' =>
                        ['id' => SORT_DESC],
                ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'TopicCode' => $this->TopicCode,
            'DetailCode' => $this->DetailCode,
            'CTopicCode1' => $this->CTopicCode1,
            'CTopicCode2' => $this->CTopicCode2,
            'CTopicCode3' => $this->CTopicCode3,
            'Debit' => $this->Debit,
            'Credit' => $this->Credit,
        ]);

        $query->andFilterWhere(['like', 'Comment', $this->Comment]);

        return $dataProvider;
    }
}
