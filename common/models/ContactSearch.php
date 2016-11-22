<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contact;

/**
 * ContactSearch represents the model behind the search form about `common\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_id', 'creator_id', 'modifier_id'], 'integer'],
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            [['first_name', 'last_name', 'organization', 'designation', 'gender', 'address', 'city', 'email', 'mobile', 'fax', 'created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Contact::find();

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
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->orFilterWhere(['like', 'last_name', $this->first_name])
                ->andFilterWhere(['=', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'organization', $this->organization])
                ->andFilterWhere(['like', 'designation', $this->designation]);

        return $dataProvider;
    }
}
