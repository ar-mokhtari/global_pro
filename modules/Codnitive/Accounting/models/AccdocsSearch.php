<?php

namespace app\modules\codnitive\accounting\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Codnitive\Accounting\models\AccDocs;

/**
 * AccdocsSearch represents the model behind the search form of `app\modules\Codnitive\Accounting\models\AccDocs`.
 */
class AccdocsSearch extends AccDocs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'companyCode', 'SecondaryDocNo', 'PrimaryDocNo', 'DocTypeCode', 'Status', 'FirstUserID', 'SecondUserID', 'YearID'], 'integer'],
            [['DocDate', 'DocTopic', 'MakeDate', 'SecondDate', 'DocNote'], 'safe'],
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
        $query = AccDocs::find();

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
            'companyCode' => $this->companyCode,
            'SecondaryDocNo' => $this->SecondaryDocNo,
            'PrimaryDocNo' => $this->PrimaryDocNo,
            'DocDate' => $this->DocDate,
            'DocTypeCode' => $this->DocTypeCode,
            'Status' => $this->Status,
            'MakeDate' => $this->MakeDate,
            'SecondDate' => $this->SecondDate,
            'FirstUserID' => $this->FirstUserID,
            'SecondUserID' => $this->SecondUserID,
            'YearID' => $this->YearID,
        ]);

        $query->andFilterWhere(['like', 'DocTopic', $this->DocTopic])
            ->andFilterWhere(['like', 'DocNote', $this->DocNote]);

        return $dataProvider;
    }
}
