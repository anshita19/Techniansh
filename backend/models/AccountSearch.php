<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Account;
use yii\data\Pagination;
use common\models\User;

/**
 * AccountSearch represents the model behind the search form about `backend\models\Account`.
 */
class AccountSearch extends Account {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            ['email','email'],
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            [['first_name', 'last_name','email','mobile','user_status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = User::find()->where(['user_type' => User::TYPE_Normal]);
        //echo $query->createCommand()->getRawSql();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['=', 'mobile', $this->mobile])
                ->andFilterWhere(['=', 'user_status', $this->user_status])
                ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
