<?php

/**
 * This is the model class for table "kecamatan".
 *
 * The followings are the available columns in table 'kecamatan':
 * @property string $kec_id
 * @property string $kec_nama
 * @property string $kec_alamat
 * @property string $kec_kordinat_x
 * @property string $kec_kordinat_y
 * @property string $kec_informasi
 * @property string $kec_keterangan
 * @property string $kec_icon_map
 *
 * The followings are the available model relations:
 * @property DtKecamatan[] $dtKecamatans
 * @property Kelurahan[] $kelurahans
 */
class Kecamatan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        
        public $kec_id;
        public $kec_nama;
        public $kec_alamat;
        public $kec_kordinat_x;
        public $kec_kordinat_y;
        public $kec_informasi;
        public $kec_keterangan;
        public $kec_icon_map;
          
	public function tableName()
	{
		return 'kecamatan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kec_id, kec_informasi, kec_keterangan, kec_icon_map', 'required'),
			array('kec_id, kec_nama', 'length', 'max'=>255),
			array('kec_alamat', 'length', 'max'=>500),
			array('kec_kordinat_x, kec_kordinat_y, kec_icon_map', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kec_id, kec_nama, kec_alamat, kec_kordinat_x, kec_kordinat_y, kec_informasi, kec_keterangan, kec_icon_map', 'safe', 'on'=>'search'),
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
			'dtKecamatans' => array(self::HAS_MANY, 'DtKecamatan', 'kec_id'),
			'kelurahans' => array(self::HAS_MANY, 'Kelurahan', 'kec_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kec_id' => 'Kec',
			'kec_nama' => 'Kec Nama',
			'kec_alamat' => 'Kec Alamat',
			'kec_kordinat_x' => 'Kec Kordinat X',
			'kec_kordinat_y' => 'Kec Kordinat Y',
			'kec_informasi' => 'Kec Informasi',
			'kec_keterangan' => 'Kec Keterangan',
			'kec_icon_map' => 'Kec Icon Map',
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

		$criteria->compare('kec_id',$this->kec_id,true);
		$criteria->compare('kec_nama',$this->kec_nama,true);
		$criteria->compare('kec_alamat',$this->kec_alamat,true);
		$criteria->compare('kec_kordinat_x',$this->kec_kordinat_x,true);
		$criteria->compare('kec_kordinat_y',$this->kec_kordinat_y,true);
		$criteria->compare('kec_informasi',$this->kec_informasi,true);
		$criteria->compare('kec_keterangan',$this->kec_keterangan,true);
		$criteria->compare('kec_icon_map',$this->kec_icon_map,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kecamatan the static model class
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
        
        
        public static function getTotalIndicatorPerMonth($kec_id, $idc_id , $tahun){
            $list = Yii::app()->db->createCommand()
                    ->select('b.idc_id,sum(a.dt_value) as dt_value, a.dt_periode, b.idc_satuan')
                    ->from('dt_indicator a')
                    ->join('indicator b', 'a.idc_id = b.idc_id')
                    ->join('kelurahan c', 'c.kel_id=a.kel_id')
                    ->join('kecamatan d', 'c.kec_id=d.kec_id')
                    ->where('b.idc_id=:idc_id and d.kec_id=:kec_id and left(a.dt_periode,4)=:tahun', array(':idc_id'=>$idc_id,':kec_id'=>$kec_id,':tahun'=>$tahun))
                    ->group('a.dt_periode')
                    ->order('a.dt_periode')
                    ->queryAll();
            
            return $list;
        }
        
        
        public static function getDetilIndicatorPerKecamatan($kec_id, $periode){
            $list = Yii::app()->db->createCommand()
                    ->select('b.idc_id,sum(a.dt_value) as dt_value, a.dt_periode, b.idc_satuan')
                    ->from('dt_indicator a')
                    ->join('indicator b', 'a.idc_id = b.idc_id')
                    ->join('kelurahan c', 'c.kel_id=a.kel_id')
                    ->join('kecamatan d', 'c.kec_id=d.kec_id')
                    ->where('a.dt_periode=:tahun and d.kec_id=:kec_id', array(':tahun'=>$periode,':kec_id'=>$kec_id))
                    ->group('b.idc_nama')
                    ->order('b.idc_nama')
                    ->queryAll();
            
            return $list;
        }
        
        public static function getAllDataIndicatorJakarta($dt_periode,$idc_category=null){
            $list = Yii::app()->db->createCommand()
                    ->select('b.idc_id, a.idc_nama,sum(b.dt_value) as dt_value,  b.dt_periode , a.idc_satuan')
                    ->from('indicator a')
                    ->join('dt_indicator b', 'a.idc_id = b.idc_id')
                    ->join('kelurahan c', 'b.kel_id=c.kel_id')
                    ->join('kecamatan d', 'c.kec_id=d.kec_id')
                    ->where('left(b.dt_periode,4)=:dt_periode and a.idc_category=:idc_category', array(':idc_category'=>$idc_category,':dt_periode'=>$dt_periode))
                    ->group('a.idc_id')
                    ->order('a.idc_nama')
                    ->queryAll();
            $list;
        }
        
        public static function getDataIndicatorJakarta($dt_periode,$idc_category=null){
            if($idc_category==null){
                $list = Yii::app()->db->createCommand()
                    ->select('b.idc_id, a.idc_nama,sum(b.dt_value) as dt_value,  b.dt_periode , a.idc_satuan')
                    ->from('indicator a')
                    ->join('dt_indicator b', 'a.idc_id = b.idc_id')
                    ->join('kelurahan c', 'b.kel_id=c.kel_id')
                    ->join('kecamatan d', 'c.kec_id=d.kec_id')
                    ->where('b.dt_periode=:dt_periode', array(':dt_periode'=>$dt_periode))
                    ->group('a.idc_id')
                    ->order('a.idc_nama')
                    ->queryAll();
            }else{
                $list = Yii::app()->db->createCommand()
                        ->select('b.idc_id, a.idc_nama,sum(b.dt_value) as dt_value,  b.dt_periode , a.idc_satuan')
                        ->from('indicator a')
                        ->join('dt_indicator b', 'a.idc_id = b.idc_id')
                        ->join('kelurahan c', 'b.kel_id=c.kel_id')
                        ->join('kecamatan d', 'c.kec_id=d.kec_id')
                        ->where('b.dt_periode=:dt_periode and a.idc_category=:idc_category', array(':idc_category'=>$idc_category,':dt_periode'=>$dt_periode))
                        ->group('a.idc_id')
                        ->order('a.idc_nama')
                        ->queryAll();
            }
            return $list;
        }
        
        
        
        public static function getIndicatorPerKecamatan($idc_id, $dt_periode){
            $list = Yii::app()->db->createCommand()
                    ->select('d.kec_nama, a.idc_nama,sum(b.dt_value) as dt_value,  b.dt_periode , a.idc_satuan')
                    ->from('indicator a')
                    ->join('dt_indicator b', 'a.idc_id = b.idc_id')
                    ->join('kelurahan c', 'b.kel_id=c.kel_id')
                    ->join('kecamatan d', 'c.kec_id=d.kec_id')
                    ->where('b.dt_periode=:dt_periode and a.idc_id=:idc_id', array(':idc_id'=>$idc_id, ':dt_periode'=>$dt_periode))
                    ->group('d.kec_nama')
                    ->order('d.kec_nama')
                    ->queryAll();
            
            return $list;
        }
        
        
        
        public static function getTahunIndicator(){
            $list = Yii::app()->db->createCommand()
                    ->selectDistinct('left(dt_periode,4) as tahun')
                    ->from('dt_indicator')
                    ->order('tahun')
                    ->queryAll();
            
            return $list;
        }
        
        
}
