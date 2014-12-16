<?php

/**
 * This is the model class for table "dt_indicator".
 *
 * The followings are the available columns in table 'dt_indicator':
 * @property integer $dt_id
 * @property string $idc_id
 * @property string $kel_id
 * @property string $dt_value
 * @property string $dt_periode
 * @property string $dt_last_update
 * @property string $dt_keterangan
 *
 * The followings are the available model relations:
 * @property Indicator $idc
 * @property Kelurahan $kel
 */
class DtIndicator extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dt_indicator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idc_id, kel_id, dt_value, dt_periode, dt_last_update, dt_keterangan', 'required'),
			array('idc_id, kel_id, dt_value', 'length', 'max'=>255),
			array('dt_periode', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dt_id, idc_id, kel_id, dt_value, dt_periode, dt_last_update, dt_keterangan', 'safe', 'on'=>'search'),
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
			'idc' => array(self::BELONGS_TO, 'Indicator', 'idc_id'),
			'kel' => array(self::BELONGS_TO, 'Kelurahan', 'kel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dt_id' => 'Dt',
			'idc_id' => 'Idc',
			'kel_id' => 'Kel',
			'dt_value' => 'Dt Value',
			'dt_periode' => 'Dt Periode',
			'dt_last_update' => 'Dt Last Update',
			'dt_keterangan' => 'Dt Keterangan',
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

		$criteria->compare('dt_id',$this->dt_id);
		$criteria->compare('idc_id',$this->idc_id,true);
		$criteria->compare('kel_id',$this->kel_id,true);
		$criteria->compare('dt_value',$this->dt_value,true);
		$criteria->compare('dt_periode',$this->dt_periode,true);
		$criteria->compare('dt_last_update',$this->dt_last_update,true);
		$criteria->compare('dt_keterangan',$this->dt_keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DtIndicator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getDataIndicator($kel_id, $thn, $idc_id=null){
            $row = Yii::app()->db->createCommand()
                    ->select('dt_id, idc_id, kel_id, dt_value,left(dt_periode,4) as dt_periode')
                    ->from('dt_indicator')
                    ->where('kel_id=:kel_id and left(dt_periode,4)=:thn and idc_id=:idc_id', array(
                        ':kel_id'=>$kel_id,':thn'=>$thn, ':idc_id'=>$idc_id ))
                    ->order('dt_periode')
                    ->queryAll();
            return $row;
        }
        
        public static function doInsertDtIndicator(){
            $status = false;
            $connection=Yii::app()->db;
            $transaction=$connection->beginTransaction();
            try {
                $sql='insert into dt_indicator (idc_id,kel_id,dt_value,dt_periode,dt_last_update, dt_keterangan)
                    select idc_id,kel_id,"0", concat(left(now(),4),right(dt_periode,2)), now(), "empty"
                    from dt_indicator
                    where left(dt_periode,4)=left(now(),4)-1
                    order by dt_id';
                if ($run =  Yii::app()->db->createCommand($sql)->execute()){
                    $transaction->commit();
                    $status = true;
                }
            }
            catch(Exception $e) // an exception is raised if a query fails
            {
                $transaction->rollback();
            }
            
            return $status; 
        }
}
