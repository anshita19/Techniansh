<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * This is the model class for table "session".
 *
 * @property integer $session_id
 * @property string $id
 * @property integer $user_id
 * @property integer $expire
 * @property resource $data
 * @property integer $last_write
 * @property string $session_type
 * @property string $mac_address
 * @property string $ip_address
 */
class Session extends \yii\db\ActiveRecord {

    public $user;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'session';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['id', 'session_type'], 'required'],
            [['expire', 'last_write'], 'integer'],
            [['data', 'session_type'], 'string'],
            [['id'], 'string', 'max' => 40],
            [['mac_address'], 'string', 'max' => 20],
            [['ip_address'], 'string', 'max' => 30],
            ['user', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'session_id' => 'Session ID',
            'id' => 'ID',
            'user_id' => 'User ID',
            'expire' => 'Expire',
            'data' => 'Data',
            'last_write' => 'Last Write',
            'session_type' => 'Session Type',
            'mac_address' => 'Mac Address',
            'ip_address' => 'Ip Address',
        ];
    }

    public function getUserRel() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function search($params) {
        $query = Session::find()
                ->joinWith(['userRel'])
                ->where('user_id IS NOT NULL');
        //echo $query->createCommand()->getRawSql();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user.first_name' => SORT_ASC],
            'desc' => ['user.last_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['=', 'session_type', $this->session_type])
                ->andFilterWhere(['=', 'mac_address', $this->mac_address])
                ->andFilterWhere(['like', 'user.first_name', $this->user])
                ->orFilterWhere(['like', 'user.last_name', $this->user]);

//        if(Yii::$app->request->isAjax){
//            echo $query->createCommand()->getRawSql();
//            exit;
//        }
        return $dataProvider;
    }

}
