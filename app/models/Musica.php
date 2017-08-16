<?php

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "musica".
 *
 * @property integer $id
 * @property string $nome
 * @property integer $usuario_id
 * @property file $file
 * @property string $extensao
 *
 * @property Usuario $usuario
 */
class Musica extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'musica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'usuario_id', 'extensao'], 'required'],
            [['usuario_id'], 'integer'],
            [['nome'], 'string', 'max' => 128],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['file'], 'file', 'skipOnEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'usuario_id' => 'Usuario ID',
            'file' => 'file'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, "file");
        $this->usuario_id = Yii::$app->user->identity->id;
        $this->nome = $this->file->baseName;
        $this->extensao = '.'.$this->file->extension;
        $this->file->name = md5($this->file->name.$this->usuario_id.microtime());
        return parent::beforeValidate();

    }

    public function afterValidate()
    {
        $helper = new BaseFileHelper();
        $helper->createDirectory('usuarios/'.$this->usuario_id);
        $this->file->saveAs('usuarios/'.$this->usuario_id.'/'.$this->file->name.$this->extensao);
        $this->file = $this->file->name;
        parent::afterValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

}
