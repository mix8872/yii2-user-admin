<?php

namespace mix8872\useradmin\components\rbac\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItem extends ActiveRecord
{
    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('user-admin', 'Имя'),
            'description' => Yii::t('user-admin', 'Описание'),
        ];
    }

    /**
     * Return roles.
     * NOTE: used for updating user role (user/update).
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRoles()
    {
        // we make sure that only You can see admin role in drop down list
        if (Yii::$app->user->can('admin')) {
            return static::find()->select('name')->where(['type' => 1])->all();
        } else { // others can not see admin role in drop down list
            return static::find()->select('name')
                ->where(['type' => 1])
                ->andWhere(['!=', 'name', 'admin'])
                ->all();
        }
    }

    public static function getUsers($role)
    {
        return Yii::$app->authManager->getUserIdsByRole($role);
    }
}
