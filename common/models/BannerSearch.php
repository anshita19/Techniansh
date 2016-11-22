<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use common\models\Banner;

class BannerSearch extends Banner {

    public function rules() {
        return [
            [['id', 'creator_id', 'modifier_id'], 'integer'],
            [['quote', 'author', 'image_size', 'sort_order', 'publish_at', 'expire_at', 'created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = Banner::find()->distinct();
        
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
            'image_size' => $this->image_size,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        if ($this->quote != '') {
            $query->andWhere('quote LIKE %"' . $this->quote . '%"');
        }

        if ($this->author != '') {
            $query->andWhere('author LIKE %"' . $this->author . '%"');
        }

        if ($this->publish_at != '' && $this->expire_at != '') {
            $query->andFilterWhere(['between', 'publish_at', $this->publish_at, $this->expire_at])
                    ->andFilterWhere(['between', 'expire_at', $this->publish_at, $this->expire_at]);
        } elseif ($this->publish_at != '') {
            $query->andWhere('publish_at >= "' . $this->expire_at . '"');
        } elseif ($this->expire_at != '') {
            $query->andWhere('expire_at <= "' . $this->expire_at . '"');
        }

        return $dataProvider;
    }

}
