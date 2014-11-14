<?php

/**
 * This is the model class for table "indicator".
 *
 * The followings are the available columns in table 'indicator':
 * @property string $idc_id
 * @property string $idc_nama
 * @property string $idc_satuan
 * @property string $idc_category
 *
 * The followings are the available model relations:
 * @property DtIndicator[] $dtIndicators
 */
class Indicator extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'indicator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idc_id, idc_nama, idc_category', 'required'),
			array('idc_id, idc_nama, idc_category', 'length', 'max'=>255),
			array('idc_satuan', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idc_id, idc_nama, idc_satuan, idc_category', 'safe', 'on'=>'search'),
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
			'dtIndicators' => array(self::HAS_MANY, 'DtIndicator', 'idc_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idc_id' => 'Idc',
			'idc_nama' => 'Idc Nama',
			'idc_satuan' => 'Idc Satuan',
			'idc_category' => 'Idc Category',
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

		$criteria->compare('idc_id',$this->idc_id,true);
		$criteria->compare('idc_nama',$this->idc_nama,true);
		$criteria->compare('idc_satuan',$this->idc_satuan,true);
		$criteria->compare('idc_category',$this->idc_category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Indicator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getUUID(){
            $user = Yii::app()->db->createCommand()
                    ->selectDistinct('uuid() as uuid')
                    ->from('user')
                    ->queryRow();
            return $user;
        }
        
        public static function getYearRows(){
            $row = Yii::app()->db->createCommand()
                    ->selectDistinct('left(dt_periode,4) as tahun')
                    ->from('dt_indicator')
                    ->order('dt_periode')
                    ->queryAll();
            return $row;
        }
}
