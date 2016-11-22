<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\ModuleAccessControl;

class ModuleAccessControlSearch extends ModuleAccessControl
{
    public function rules()
    {
        return [
            [['id', 'module_id', 'role_id', 'module_action_item_id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ModuleAccessControl::find()->groupBy('role_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
            'module_id' => $this->module_id,
            'module_action_item_id' => $this->module_action_item_id,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'creator_ip', $this->creator_ip])
            ->andFilterWhere(['like', 'modifier_ip', $this->modifier_ip]);

        return $dataProvider;
    }
}
