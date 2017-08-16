<?php

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $email
 * @property string $senha
 * @property string $nome
 * @property string $imagem
 * @property string $token
 *
 * @property Musica[] $musica
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $senhaRepeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'senha', 'nome', 'senhaRepeat'], 'required'],
            [['email', 'nome'], 'string', 'max' => 128],
            [['senha'], 'string', 'max' => 32],
            [['senhaRepeat'],'compare', 'compareAttribute'=>'senha'],
            [['email'], 'unique'],
            [['imagem'],'image']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'senha' => 'Senha',
            'nome' => 'Nome',
            'imagem' => 'Imagem',
            'senhaRepeat' => 'Confirmar senha'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMusica()
    {
        return $this->hasMany(Musicas::className(), ['usuario_id' => 'id']);
    }

    public static function findByUsername($username)
    {
        return self::findOne(['email'=>$username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->token == $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->senha === md5($password);
    }

    public static function findIdentity($id)
    {
        return Usuario::findOne(['id'=>$id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['token'=>$token]);
    }

    public function beforeSave($insert)
    {

        return parent::beforeSave($insert);
    }

}
