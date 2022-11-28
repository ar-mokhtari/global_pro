<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Codnitive\OfficeAutomation\models\VwLetterstrash;
use yii\web\NotFoundHttpException;

/**
 * VwLetterstrashSearch represents the model behind the search form of `app\modules\Codnitive\OfficeAutomation\models\VwLetterstrash`.
 */
class VwLetterstrashSearch extends VwLetterstrash
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK', 'LettersTrashID', 'LettersID_FK', 'UsersIDDeletor'], 'integer'],
            [['LettersSubject', 'LettersText', 'LettersAbstract', 'LettersCreateDate', 'LettersNumber', 'LettersResponseDate', 'LettersAttachmentUrl', 'LettersAttachmentFileName', 'LettersAttachFileExtention', 'LettersTrashDate', 'FullNameSender', 'FullNameDeletor', 'PersianLettersTypeOfAction', 'PersianLettersSecurity', 'PersianLettersArchiveType', 'PersianLettersFollowType', 'PersianLettersAttachmentType', 'PersianLettersType', 'PersianLettersResponseType', 'PersianLettersDraftType'], 'safe'],
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
        $userID = tools()->getUser()->identity->id;
        if ($userID) {
            $query = VwLetterstrash::find()->where(['UsersIDDeletor' => $userID]);
        } else {
            throw new NotFoundHttpException('خـطا: VwLetters/P16');
        }

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
            'LettersID' => $this->LettersID,
            'LettersDraftType' => $this->LettersDraftType,
            'LettersType' => $this->LettersType,
            'LettersTypeOfAction' => $this->LettersTypeOfAction,
            'LettersSecurity' => $this->LettersSecurity,
            'LettersFollowType' => $this->LettersFollowType,
            'LettersResponseType' => $this->LettersResponseType,
            'LettersResponseID' => $this->LettersResponseID,
            'LettersAttachmentType' => $this->LettersAttachmentType,
            'LettersArchiveType' => $this->LettersArchiveType,
            'UsersID_FK' => $this->UsersID_FK,
            'LettersTrashID' => $this->LettersTrashID,
            'LettersID_FK' => $this->LettersID_FK,
            'UsersIDDeletor' => $this->UsersIDDeletor,
        ]);

        $query->andFilterWhere(['like', 'LettersSubject', $this->LettersSubject])
            ->andFilterWhere(['like', 'LettersText', $this->LettersText])
            ->andFilterWhere(['like', 'LettersAbstract', $this->LettersAbstract])
            ->andFilterWhere(['like', 'LettersCreateDate', $this->LettersCreateDate])
            ->andFilterWhere(['like', 'LettersNumber', $this->LettersNumber])
            ->andFilterWhere(['like', 'LettersResponseDate', $this->LettersResponseDate])
            ->andFilterWhere(['like', 'LettersAttachmentUrl', $this->LettersAttachmentUrl])
            ->andFilterWhere(['like', 'LettersAttachmentFileName', $this->LettersAttachmentFileName])
            ->andFilterWhere(['like', 'LettersAttachFileExtention', $this->LettersAttachFileExtention])
            ->andFilterWhere(['like', 'LettersTrashDate', $this->LettersTrashDate])
            ->andFilterWhere(['like', 'FullNameSender', $this->FullNameSender])
            ->andFilterWhere(['like', 'FullNameDeletor', $this->FullNameDeletor])
            ->andFilterWhere(['like', 'PersianLettersTypeOfAction', $this->PersianLettersTypeOfAction])
            ->andFilterWhere(['like', 'PersianLettersSecurity', $this->PersianLettersSecurity])
            ->andFilterWhere(['like', 'PersianLettersArchiveType', $this->PersianLettersArchiveType])
            ->andFilterWhere(['like', 'PersianLettersFollowType', $this->PersianLettersFollowType])
            ->andFilterWhere(['like', 'PersianLettersAttachmentType', $this->PersianLettersAttachmentType])
            ->andFilterWhere(['like', 'PersianLettersType', $this->PersianLettersType])
            ->andFilterWhere(['like', 'PersianLettersResponseType', $this->PersianLettersResponseType])
            ->andFilterWhere(['like', 'PersianLettersDraftType', $this->PersianLettersDraftType]);

        return $dataProvider;
    }
}