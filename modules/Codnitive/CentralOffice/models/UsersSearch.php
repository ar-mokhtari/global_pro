<?php

namespace app\modules\Codnitive\CentralOffice\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Codnitive\CentralOffice\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\modules\Codnitive\CentralOffice\models\VwUsers`.
 */
class UsersSearch extends VwUsers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserID', 'UserGender', 'UserActivity'], 'integer'],
            [['UserName', 'UserFamily', 'UserUserName', 'UserPassword', 'UserEmail', 'UserPhone', 'UserMobile', 'UserPicture','UserSign','_gender','_activity'], 'safe'],
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
        $query = VwUsers::find();

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
            'UserID' => $this->UserID,
            'UserGender' => $this->UserGender,
            'UserActivity' => $this->UserActivity,
        ]);

        $query->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'UserFamily', $this->UserFamily])
            ->andFilterWhere(['like', 'UserUserName', $this->UserUserName])
            ->andFilterWhere(['like', 'UserPassword', $this->UserPassword])
            ->andFilterWhere(['like', 'UserEmail', $this->UserEmail])
            ->andFilterWhere(['like', 'UserPhone', $this->UserPhone])
            ->andFilterWhere(['like', 'UserMobile', $this->UserMobile])
            ->andFilterWhere(['like', '_gender', $this->_gender])
            ->andFilterWhere(['like', '_activity', $this->_activity])
            ->andFilterWhere(['like', 'UserPicture', $this->UserPicture])
            ->andFilterWhere(['like', 'UserSign', $this->UserSign]);

        return $dataProvider;
    }
}
