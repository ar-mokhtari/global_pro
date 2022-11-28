<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VwLettersSearch represents the model behind the search form of `app\modules\Codnitive\OfficeAutomation\models\VwLetters`.
 */
class VwLettersSearch extends VwLetters
{
    protected $_searchParams = [];

    /**
     * {@inheritdoc}
     */
    public $LettersCreateDate_From;
    public $LettersCreateDate_From_P;
    public $LettersCreateDate_To;
    public $LettersCreateDate_To_P;

    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType',
                'LettersTypeOfAction', 'LettersSecurity',
                'LettersFollowType', 'LettersResponseType',
                'LettersResponseID', 'LettersAttachmentType',
                'LettersArchiveType', 'UsersID_FK'], 'integer'],
            [['LettersSubject', 'LettersText', 'LettersAbstract',
                'LettersCreateDate', 'LettersNumber', 'LettersResponseDate',
                'LettersAttachmentUrl', 'LettersAttachmentFileName',
                'FullName', 'LettersAttachFileExtention',
                'PersianLettersTypeOfAction', 'PersianLettersSecurity',
                'PersianLettersArchiveType', 'PersianLettersFollowType',
                'PersianLettersAttachmentType', 'PersianLettersType',
                'PersianLettersResponseType', 'PersianLettersDraftType', 'LettersCreateDate_From', 'LettersCreateDate_To'
                ,], 'safe'],
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
     * @throws NotFoundHttpException
     */
    public function search($params, $all = '')
    {
        $userID = tools()->getUser()->identity->id;
        if ($userID) {
            $AllModals = /*(tools()->isAdmin()) ? VwLetters::find() :*/
                (($all === 'ALL') ?
                    VwLetters::find()->andWhere(['LettersType' => 0])->andWhere(['LettersDraftType' => 1]) :
                    VwLetters::find()->where(['UsersID_FK' => $userID])->andWhere(['LettersDraftType' => 0]));
        } else {
            throw new NotFoundHttpException('خـطا: 54');
        }
        $query = $AllModals;
        $LettersCreateDate_From = \Yii::$app->request->get('LettersCreateDate_From') . ' ' . '00:00:00';
        $LettersCreateDate_To = \Yii::$app->request->get('LettersCreateDate_To') . ' ' . '23:59:59';;
        if (isset($params['VwLettersSearch'])) {
            $this->_searchParams = $params['VwLettersSearch'];
            $collection = $this->_filterCollection($AllModals);
            foreach ($collection as $object) {
                $data = $this->jsonDecodeFields($object);
                $object->setAttributes($data);
            }
            // grid filtering conditions
            $query->Where([
                'IN', 'LettersID', $collection
            ]);
            $query->andWhere(['BETWEEN', 'LettersCreateDate', @$LettersCreateDate_From, @$LettersCreateDate_To]);
            $query->andWhere(['LettersResponseType' => $params['LettersResponseType']]);
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
