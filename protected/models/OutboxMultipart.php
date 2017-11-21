<?php

/**
 * This is the model class for table "outbox_multipart".
 *
 * The followings are the available columns in table 'outbox_multipart':
 * @property string $Text
 * @property string $Coding
 * @property string $UDH
 * @property integer $Class
 * @property string $TextDecoded
 * @property string $ID
 * @property integer $SequencePosition
 */
class OutboxMultipart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'outbox_multipart';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SequencePosition', 'numerical', 'integerOnly'=>true),
			array('Coding', 'length', 'max'=>22),
			array('ID', 'length', 'max'=>10),
			array('Text, UDH, TextDecoded', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Text, Coding, UDH, Class, TextDecoded, ID, SequencePosition', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Text' => 'Text',
			'Coding' => 'Coding',
			'UDH' => 'Udh',
			'Class' => 'Class',
			'TextDecoded' => 'Text Decoded',
			'ID' => 'ID',
			'SequencePosition' => 'Sequence Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Text',$this->Text,true);
		$criteria->compare('Coding',$this->Coding,true);
		$criteria->compare('UDH',$this->UDH,true);
		$criteria->compare('Class',$this->Class);
		$criteria->compare('TextDecoded',$this->TextDecoded,true);
		$criteria->compare('ID',$this->ID,true);
		$criteria->compare('SequencePosition',$this->SequencePosition);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OutboxMultipart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
