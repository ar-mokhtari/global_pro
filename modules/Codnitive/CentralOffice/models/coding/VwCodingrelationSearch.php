<?php

namespace app\modules\Codnitive\CentralOffice\models\coding;

use app\modules\Codnitive\Calendar\models\Persian;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * CodingSearch represents the model behind the search form of `app\modules\Codnitive\CentralOffice\models\coding\Coding`.
 */
class VwCodingrelationSearch extends VwCodingrelation
{
    protected $_searchParams = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_code', 'second_code'], 'required'],
            [['id', 'first_code', 'second_code',], 'integer'],
            [['create_at', 'name_first'], 'string']
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
        $AllModals = VwCodingrelation::find()->where(['first_code' => app()->session->get('JobsID')]);
        $query = $AllModals;
        if (isset($params['VwCodingrelationSearch'])) {
            $this->_searchParams = $params['VwCodingrelationSearch'];
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
                        ['id' => SORT_ASC, 'first_code' => SORT_ASC],
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

    public function attributeLabels()
    {
        return [
            'first_code' => __('account', 'first_code_relation'),
            'second_code' => __('account', 'second_code_relation'),
            'id' => __('account', 'id'),
            'companyID' => __('account', 'companyID'),
            'create_at' => __('account', 'create_at'),
        ];
    }

}
