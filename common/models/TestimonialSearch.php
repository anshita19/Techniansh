<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Testimonial;

/**
 * TestimonialSearch represents the model behind the search form about `common\models\Testimonial`.
 */
class TestimonialSearch extends Testimonial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'image_size', 'image_width', 'image_height', 'status', 'is_home', 'sort_order', 'creator_id', 'modifier_id'], 'integer'],
            [['testimonial', 'name', 'organisation', 'designation', 'image_name', 'image_ext', 'image_base_name', 'image_mime_type', 'created_at', 'creator_ip', 'modified_at', 'modifier_ip'], 'safe'],
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
        $query = Testimonial::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'image_name' => $this->image_name,
            'image_ext' => $this->image_ext,
            'image_base_name' => $this->image_base_name,
            'image_mime_type' => $this->image_mime_type,
            'image_size' => $this->image_size,
            'image_width' => $this->image_width,
            'image_height' => $this->image_height,
            'status' => $this->status,
            'is_home' => $this->is_home,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'creator_id' => $this->creator_id,
            'modified_at' => $this->modified_at,
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'testimonial', $this->testimonial])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'organisation', $this->organisation])
            ->andFilterWhere(['like', 'designation', $this->designation])            
            ->andFilterWhere(['like', 'creator_ip', $this->creator_ip])
            ->andFilterWhere(['like', 'modifier_ip', $this->modifier_ip]);

        return $dataProvider;
    }
}
