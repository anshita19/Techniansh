<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Module;

class ModuleSearch extends Module
{
    public function rules()
    {
        return [
            [['id', 'sort_order', 'creator_id', 'modifier_id'], 'integer'],
            [['name','controller_name', 'css_class', 'icon', 'created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Module::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort_order' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'controller_name', $this->controller_name])
            ->andFilterWhere(['like', 'css_class', $this->css_class])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'creator_ip', $this->creator_ip])
            ->andFilterWhere(['like', 'modifier_ip', $this->modifier_ip]);

        return $dataProvider;
    }
}
