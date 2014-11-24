<?php

/**
 * This is the model class for table "kelurahan".
 *
 * The followings are the available columns in table 'kelurahan':
 * @property string $kel_id
 * @property string $kec_id
 * @property string $kel_nama
 * @property string $kel_alamat
 * @property string $kel_kordinat_x
 * @property string $kel_kordinat_y
 * @property string $kel_informasi
 * @property string $kel_keterangan
 * @property string $kel_icon_map
 *
 * The followings are the available model relations:
 * @property DtKelurahan[] $dtKelurahans
 * @property Kecamatan $kec
 * @property Puskesmas[] $puskesmases
 */
class Kelurahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $kel_id;
        public $kec_id;
        public $kel_nama;
        public $kel_alamat;
        public $kel_kordinat_x;
        public $kel_kordinat_y;
        public $kel_informasi;
        public $kel_keterangan;
        public $kel_icon_map;
         
	public function tableName()
	{
		return 'kelurahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kel_id, kec_id, kel_informasi, kel_keterangan, kel_icon_map', 'required'),
			array('kel_id, kec_id, kel_nama', 'length', 'max'=>255),
			array('kel_alamat', 'length', 'max'=>500),
			array('kel_kordinat_x, kel_kordinat_y, kel_icon_map', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kel_id, kec_id, kel_nama, kel_alamat, kel_kordinat_x, kel_kordinat_y, kel_informasi, kel_keterangan, kel_icon_map', 'safe', 'on'=>'search'),
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
			'dtKelurahans' => array(self::HAS_MANY, 'DtKelurahan', 'kel_id'),
			'kec' => array(self::BELONGS_TO, 'Kecamatan', 'kec_id'),
			'puskesmases' => array(self::HAS_MANY, 'Puskesmas', 'kel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kel_id' => 'Kel',
			'kec_id' => 'Kec',
			'kel_nama' => 'Kel Nama',
			'kel_alamat' => 'Kel Alamat',
			'kel_kordinat_x' => 'Kel Kordinat X',
			'kel_kordinat_y' => 'Kel Kordinat Y',
			'kel_informasi' => 'Kel Informasi',
			'kel_keterangan' => 'Kel Keterangan',
			'kel_icon_map' => 'Kel Icon Map',
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

		$criteria->compare('kel_id',$this->kel_id,true);
		$criteria->compare('kec_id',$this->kec_id,true);
		$criteria->compare('kel_nama',$this->kel_nama,true);
		$criteria->compare('kel_alamat',$this->kel_alamat,true);
		$criteria->compare('kel_kordinat_x',$this->kel_kordinat_x,true);
		$criteria->compare('kel_kordinat_y',$this->kel_kordinat_y,true);
		$criteria->compare('kel_informasi',$this->kel_informasi,true);
		$criteria->compare('kel_keterangan',$this->kel_keterangan,true);
		$criteria->compare('kel_icon_map',$this->kel_icon_map,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kelurahan the static model class
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
        
        public static function getListInformasi($dataColumm){
            $list = Yii::app()->db->createCommand()
                ->selectDistinct('b.kel_nama as kelurahan ,a.dt_column as name,a.dt_satuan as unit,  a.dt_information as data')
                ->from('dt_kelurahan a')
                ->join('kelurahan b', 'a.kel_id=b.kel_id')
                ->where('a.dt_column=:dt_column', array(':dt_column'=>$dataColumm))
                ->group('b.kel_nama')    
                ->order(array('b.kel_nama', 'name'))    
                ->queryAll();
            return $list;
        }
        
        public static function getListCategory(){
            $list = Yii::app()->db->createCommand()
                ->selectDistinct('b.kel_id as kel_id, b.kel_nama as kel_nama ,a.dt_column as name,  a.dt_information as data')
                ->from('dt_kelurahan a')
                ->join('kelurahan b', 'a.kel_id=b.kel_id')
                ->group('b.kel_nama')    
                ->order(array('b.kel_nama', 'name'))  
                ->queryAll();
            return $list;
        }
        
        public static function getAllInformasi(){
            $data = Yii::app()->db->createCommand()
                ->selectDistinct('dt_column as name, sum(dt_information) as data, dt_satuan as unit')
                ->from('dt_kelurahan')
                ->group('name')    
                ->order('name')  
                ->queryAll();
            return $data;
        }
        
        public static function getDetilIndicatorInYears($kel_id,$thn){
            $list = Yii::app()->db->createCommand()
                ->selectDistinct('a.kel_id,a.kel_nama,c.idc_id,c.idc_nama,b.dt_value,b.dt_periode,c.idc_satuan,b.dt_keterangan')
                ->from('kelurahan a')
                ->join('dt_indicator b', 'a.kel_id=b.kel_id')
                ->join('indicator c', 'b.idc_id=c.idc_id')
                ->where('a.kel_id=:kel_id and left(b.dt_periode,4)=:thn', array(':kel_id'=>$kel_id  ,':thn'=>$thn))
                ->order('b.dt_periode')  
                ->queryAll();
             
            return $list;
        }
        
        public static function getDetilIndicator($kel_id,$idc_id, $thn=null){
            $list = Yii::app()->db->createCommand()
                ->selectDistinct('b.dt_keterangan, b.dt_id,a.kel_id,a.kel_nama,c.idc_id,c.idc_nama,b.dt_value,b.dt_periode,c.idc_satuan')
                ->from('kelurahan a')
                ->join('dt_indicator b', 'a.kel_id=b.kel_id')
                ->join('indicator c', 'b.idc_id=c.idc_id')
                ->where('a.kel_id=:kel_id and b.idc_id=:idc_id and left(b.dt_periode,4)=:thn', array(':kel_id'=>$kel_id ,':idc_id'=>$idc_id ,':thn'=>$thn))
                ->order('b.dt_periode')  
                ->queryAll();
            return $list;
        }
        
        
        public static function getListMonth(){
            $month = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'];
            return $month;
        }
        
        public static function getNameMonth($key){
            $month = Kelurahan::model()->getListMonth();
            $nm = $month[$key];
            return $nm;
        }
        
        
        public static function getDataIndicatorKelurahan($idc_id, $dt_periode){
            $list = Yii::app()->db->createCommand()
                ->select('c.kel_nama, b.idc_nama, a.dt_value, a.dt_periode, b.idc_satuan')
                ->from('dt_indicator a')
                ->join('indicator b', 'a.idc_id=b.idc_id')
                ->join('kelurahan c', 'a.kel_id=c.kel_id')
                ->where('a.dt_periode=:dt_periode and b.idc_id=:idc_id', array(':idc_id'=>$idc_id,'dt_periode'=>$dt_periode))
                ->group('c.kel_id')  
                ->order('c.kel_nama')  
                ->queryAll();
            return $list;
        }
        
}
