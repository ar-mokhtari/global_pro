<?php

namespace app\modules\Codnitive\CentralOffice\models\coding;

use app\modules\Codnitive\Calendar\models\Persian;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * CodingSearch represents the model behind the search form of `app\modules\Codnitive\CentralOffice\models\coding\Coding`.
 */
class VwCodingSearch extends VwCoding
{
    protected $_searchParams = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'grp', 'level', 'user_create'], 'integer'],
            [['parent_name', 'name', 'make_date'], 'string'],
            [['active',], 'number'],
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
        $AllModals = VwCoding::find()->where(['grp' => 2,/* 'level' => 0*/]);
        $query = $AllModals;
        if (isset($params['VwCodingSearch'])) {
            $this->_searchParams = $params['VwCodingSearch'];
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
            'Pagination' => false,
//                [
//                    'pageSizeParam' => false,
//                    'pageSize' => 12,
//                ],
            'sort' =>
                [
                    'defaultOrder' =>
                        ['parent' => SORT_ASC, 'level' => SORT_ASC],
                ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
            case 'make_date':
                $dateParts = explode(' ', tools()->getFormattedDate($paramValue, 'Y-m-d H:i'));
                $formattedValue = str_replace('-', '/', (new Persian)->getDate($dateParts[0]));
                break;
        }
        return $formattedValue;
    }
}
