<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use app\modules\Codnitive\Calendar\models\Persian;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * LettersSearch represents the model behind the search form of `app\modules\Codnitive\OfficeAutomation\models\Letters`.
 */
class LettersSearch extends Letters
{
    protected $_searchParams = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK'], 'integer'],
            [['LettersSubject', 'LettersText', 'LettersAbstract', 'LettersCreateDate', 'LettersNumber', 'LettersResponseDate', 'LettersAttachmentUrl', 'LettersAttachmentFileName'], 'safe'],
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
        $AllModals = Letters::find();
        $query = $AllModals;
        if (isset($params['LettersSearch'])) {
            $this->_searchParams = $params['LettersSearch'];
            $collection = $this->_filterCollection($AllModals);
            foreach ($collection as $object) {
                $data = $this->jsonDecodeFields($object);
                $object->setAttributes($data);
            }
            // grid filtering conditions
            $query->Where([
                'IN', 'id', $collection
            ]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' =>
                [
                    'pageSizeParam' => false,
                    'pageSize' => 10
                ],
            'sort' =>
                [
                    'defaultOrder' =>
                        ['LettersID' => SORT_DESC],
                ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'LettersID' => $this->LettersID,
//            'LettersDraftType' => $this->LettersDraftType,
//            'LettersType' => $this->LettersType,
//            'LettersTypeOfAction' => $this->LettersTypeOfAction,
//            'LettersSecurity' => $this->LettersSecurity,
//            'LettersFollowType' => $this->LettersFollowType,
//            'LettersResponseType' => $this->LettersResponseType,
//            'LettersResponseID' => $this->LettersResponseID,
//            'LettersAttachmentType' => $this->LettersAttachmentType,
//            'LettersArchiveType' => $this->LettersArchiveType,
//            'UsersID_FK' => $this->UsersID_FK,
//        ]);
//
//        $query->andFilterWhere(['like', 'LettersSubject', $this->LettersSubject])
//            ->andFilterWhere(['like', 'LettersText', $this->LettersText])
//            ->andFilterWhere(['like', 'LettersAbstract', $this->LettersAbstract])
//            ->andFilterWhere(['like', 'LettersCreateDate', $this->LettersCreateDate])
//            ->andFilterWhere(['like', 'LettersNumber', $this->LettersNumber])
//            ->andFilterWhere(['like', 'LettersResponseDate', $this->LettersResponseDate])
//            ->andFilterWhere(['like', 'LettersAttachmentUrl', $this->LettersAttachmentUrl])
//            ->andFilterWhere(['like', 'LettersAttachmentFileName', $this->LettersAttachmentFileName])
//            ->andFilterWhere(['like', 'LettersAttachFileExtention', $this->LettersAttachFileExtention]);

        return $dataProvider;
    }
    protected function _filterCollection(ActiveQuery $allModels): array
    {
        $collection = $allModels->all();
        $collection = array_filter($collection, function ($object) {
            $conditions = [true];
            foreach ($this->_searchParams as $param => $searchValue) {
                if (!empty($searchValue)) {
                    $conditions[] = strpos(
                            strtolower($this->_getObjectFormattedParam($param, $object->$param, $object)),
                            strtolower($searchValue)
                        ) !== false;
                }
            }
            return array_product($conditions);
        });
        return $collection;
    }

    private function _getObjectFormattedParam($param, $paramValue, $model)
    {
        $formattedValue = $paramValue;
        switch ($param) {
            case 'LettersCreateDate':
                $dateParts = explode(' ', tools()->getFormattedDate($paramValue, 'Y-m-d H:i'));
                $formattedValue = str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                break;
        }
        return $formattedValue;
    }
}
