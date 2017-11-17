<?php

/**
 * This is the model class for table "sentitems".
 *
 * The followings are the available columns in table 'sentitems':
 * @property string $UpdatedInDB
 * @property string $InsertIntoDB
 * @property string $SendingDateTime
 * @property string $DeliveryDateTime
 * @property string $Text
 * @property string $DestinationNumber
 * @property string $Coding
 * @property string $UDH
 * @property string $SMSCNumber
 * @property integer $Class
 * @property string $TextDecoded
 * @property string $ID
 * @property string $SenderID
 * @property integer $SequencePosition
 * @property string $Status
 * @property integer $StatusError
 * @property integer $TPMR
 * @property integer $RelativeValidity
 * @property string $CreatorID
 */
class Sentitems extends CActiveRecord
{

	public $SEARCH;
	public $PAGE_SIZE = 10;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sentitems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UpdatedInDB, Text, UDH, TextDecoded, SenderID, CreatorID', 'required'),
			array('Class, SequencePosition, StatusError, TPMR, RelativeValidity', 'numerical', 'integerOnly'=>true),
			array('DestinationNumber, SMSCNumber', 'length', 'max'=>20),
			array('Coding', 'length', 'max'=>22),
			array('ID', 'length', 'max'=>10),
			array('SenderID', 'length', 'max'=>255),
			array('Status', 'length', 'max'=>17),
			array('InsertIntoDB, SendingDateTime, DeliveryDateTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('UpdatedInDB, InsertIntoDB, SendingDateTime, DeliveryDateTime, Text, DestinationNumber, Coding, UDH, SMSCNumber, Class, TextDecoded, ID, SenderID, SequencePosition, Status, StatusError, TPMR, RelativeValidity, CreatorID', 'safe', 'on'=>'search'),
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
			'UpdatedInDB' => 'Updated In Db',
			'InsertIntoDB' => 'Insert Into Db',
			'SendingDateTime' => 'Sending Date Time',
			'DeliveryDateTime' => 'Delivery Date Time',
			'Text' => 'Text',
			'DestinationNumber' => 'Destination Number',
			'Coding' => 'Coding',
			'UDH' => 'Udh',
			'SMSCNumber' => 'Smscnumber',
			'Class' => 'Class',
			'TextDecoded' => 'Text Decoded',
			'ID' => 'ID',
			'SenderID' => 'Sender',
			'SequencePosition' => 'Sequence Position',
			'Status' => 'Status',
			'StatusError' => 'Status Error',
			'TPMR' => 'Tpmr',
			'RelativeValidity' => 'Relative Validity',
			'CreatorID' => 'Creator',
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
		$sort = new CSort();


		$criteria->addSearchCondition('DestinationNumber',$this->SEARCH,true,'OR');
		$criteria->addSearchCondition('SendingDateTime',$this->SEARCH,true,'OR');
		$criteria->addSearchCondition('TextDecoded',$this->SEARCH,true,'OR');
		$criteria->order = 'SendingDateTime DESC';
		// 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array(
				'pageSize'=>$this->PAGE_SIZE,
				
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sentitems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
