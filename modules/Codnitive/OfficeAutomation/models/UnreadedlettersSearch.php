<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter;

/**
 * UnreadedlettersSearch represents the model behind the search form of `app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter`.
 */
class UnreadedlettersSearch extends VwRecieveletter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK', 'SendLettersID', 'UsersID_Reciever', 'SendLettersReadType'], 'integer'],
            [['LettersSubject', 'LettersText', 'LettersAbstract', 'LettersCreateDate', 'LettersNumber', 'LettersResponseDate', 'LettersAttachmentUrl', 'LettersAttachmentFileName', 'LettersAttachFileExtention', 'FullNameSender', 'FullNameReciever', 'SendLettersDate', 'PersianLettersTypeOfAction', 'PersianLettersSecurity', 'PersianLettersArchiveType', 'PersianLettersFollowType', 'PersianLettersAttachmentType', 'PersianLettersType', 'PersianLettersResponseType', 'PersianLettersDraftType', 'PersianSendLettersReadType'], 'safe'],
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
            $query = VwRecieveletter::find()->where(['UsersID_Reciever' => $userID])->
            andWhere(['LettersDraftType' => 1])->andWhere(['SendLettersReadType' => 0]);
        } else {
            throw new NotFoundHttpException('خـطا: UnreadLetter/P17');
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
            'SendLettersID' => $this->SendLettersID,
            'UsersID_Reciever' => $this->UsersID_Reciever,
            'SendLettersReadType' => $this->SendLettersReadType,
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
            ->andFilterWhere(['like', 'FullNameSender', $this->FullNameSender])
            ->andFilterWhere(['like', 'FullNameReciever', $this->FullNameReciever])
            ->andFilterWhere(['like', 'SendLettersDate', $this->SendLettersDate])
            ->andFilterWhere(['like', 'PersianLettersTypeOfAction', $this->PersianLettersTypeOfAction])
            ->andFilterWhere(['like', 'PersianLettersSecurity', $this->PersianLettersSecurity])
            ->andFilterWhere(['like', 'PersianLettersArchiveType', $this->PersianLettersArchiveType])
            ->andFilterWhere(['like', 'PersianLettersFollowType', $this->PersianLettersFollowType])
            ->andFilterWhere(['like', 'PersianLettersAttachmentType', $this->PersianLettersAttachmentType])
            ->andFilterWhere(['like', 'PersianLettersType', $this->PersianLettersType])
            ->andFilterWhere(['like', 'PersianLettersResponseType', $this->PersianLettersResponseType])
            ->andFilterWhere(['like', 'PersianLettersDraftType', $this->PersianLettersDraftType])
            ->andFilterWhere(['like', 'PersianSendLettersReadType', $this->PersianSendLettersReadType]);

        return $dataProvider;
    }
}
