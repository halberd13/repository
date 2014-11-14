<?php

/**
 * This is the model class for table "puskesmas".
 *
 * The followings are the available columns in table 'puskesmas':
 * @property string $pusk_id
 * @property string $kel_id
 * @property string $pusk_nama
 * @property string $pusk_kode_puskesmas
 * @property string $pusk_alamat
 * @property string $pusk_jenis_puskesmas
 * @property string $pusk_kordinat_x
 * @property string $pusk_kordinat_y
 * @property string $pusk_informasi
 * @property string $pusk_keterangan
 * @property string $pusk_icon_map
 *
 * The followings are the available model relations:
 * @property Kelurahan $kel
 */
class Puskesmas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $pusk_id;
        public $kel_id;
        public $pusk_nama;
        public $pusk_kode_puskesmas;
        public $pusk_alamat;
        public $pusk_jenis_puskesmas;
        public $pusk_kordinat_x;
        public $pusk_kordinat_y;
        public $pusk_informasi;
        public $pusk_keterangan;
        public $pusk_icon_map;
        
	public function tableName()
	{
		return 'puskesmas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pusk_id, pusk_nama, pusk_kode_puskesmas, pusk_alamat, pusk_informasi, pusk_keterangan, pusk_icon_map', 'required'),
			array('pusk_id, kel_id, pusk_nama, pusk_kode_puskesmas, pusk_jenis_puskesmas, pusk_kordinat_x, pusk_kordinat_y', 'length', 'max'=>255),
			array('pusk_alamat, pusk_icon_map', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pusk_id, kel_id, pusk_nama, pusk_kode_puskesmas, pusk_alamat, pusk_jenis_puskesmas, pusk_kordinat_x, pusk_kordinat_y, pusk_informasi, pusk_keterangan, pusk_icon_map', 'safe', 'on'=>'search'),
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
			'kel' => array(self::BELONGS_TO, 'Kelurahan', 'kel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pusk_id' => 'Pusk',
			'kel_id' => 'Kel',
			'pusk_nama' => 'Pusk Nama',
			'pusk_kode_puskesmas' => 'Pusk Kode Puskesmas',
			'pusk_alamat' => 'Pusk Alamat',
			'pusk_jenis_puskesmas' => 'Pusk Jenis Puskesmas',
			'pusk_kordinat_x' => 'Pusk Kordinat X',
			'pusk_kordinat_y' => 'Pusk Kordinat Y',
			'pusk_informasi' => 'Pusk Informasi',
			'pusk_keterangan' => 'Pusk Keterangan',
			'pusk_icon_map' => 'Pusk Icon Map',
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

		$criteria->compare('pusk_id',$this->pusk_id,true);
		$criteria->compare('kel_id',$this->kel_id,true);
		$criteria->compare('pusk_nama',$this->pusk_nama,true);
		$criteria->compare('pusk_kode_puskesmas',$this->pusk_kode_puskesmas,true);
		$criteria->compare('pusk_alamat',$this->pusk_alamat,true);
		$criteria->compare('pusk_jenis_puskesmas',$this->pusk_jenis_puskesmas,true);
		$criteria->compare('pusk_kordinat_x',$this->pusk_kordinat_x,true);
		$criteria->compare('pusk_kordinat_y',$this->pusk_kordinat_y,true);
		$criteria->compare('pusk_informasi',$this->pusk_informasi,true);
		$criteria->compare('pusk_keterangan',$this->pusk_keterangan,true);
		$criteria->compare('pusk_icon_map',$this->pusk_icon_map,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Puskesmas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getUUID(){
            $user = Yii::app()->db->createCommand()
                    ->select('uuid()')
                    ->from('user')
                    ->queryRow();
            return $user;
        }
        
        function getDataMarker($id){
            $tCheck1 = Puskesmas::model()->findByPk($id);
            $tCheck2 = Kelurahan::model()->findByPk($id);
            $tCheck3 = Kecamatan::model()->findByPk($id);
            if($tCheck1!=null){
                $data = array();
                array_push($data, $tCheck1->pusk_id);
                array_push($data, $tCheck1->pusk_nama);
                array_push($data, $tCheck1->pusk_alamat);
                array_push($data, $tCheck1->pusk_kordinat_x);
                array_push($data, $tCheck1->pusk_kordinat_y);
                array_push($data, $tCheck1->pusk_icon_map);
                
            }
            if($tCheck2!=null){
                $data = array();
                array_push($data, $tCheck2->kel_id);
                array_push($data, $tCheck2->kel_nama);
                array_push($data, $tCheck2->kel_alamat);
                array_push($data, $tCheck2->kel_kordinat_x);
                array_push($data, $tCheck2->kel_kordinat_y);
                
            }
            if($tCheck3!=null){
                $data = array();
                array_push($data, $tCheck3->kec_id);
                array_push($data, $tCheck3->kec_nama);
                array_push($data, $tCheck3->kec_alamat);
                array_push($data, $tCheck3->kec_kordinat_x);
                array_push($data, $tCheck3->kec_kordinat_y);
                
            }
            return $data;
        }
        
}
