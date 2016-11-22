<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserGroup;

/**
 * UserGroupSearch represents the model behind the search form of `common\models\UserGroup`.
 */
class UserGroupSearch extends UserGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_group_id', 'creator_id', 'modifier_id'], 'integer'],
            [['group_name', 'created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
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
        $query = UserGroup::find();

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
            'user_group_id' => $this->user_group_id,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'creator_ip', $this->creator_ip])
            ->andFilterWhere(['like', 'modifier_ip', $this->modifier_ip]);

        return $dataProvider;
    }
}
