<?php

class PuskesmasController extends Controller
{
	public function actionIndex()
	{
            $model = Puskesmas::model()->findAll();
            $data = array();
            $i=1;
            foreach ($model as $val) {
                $kelurahan = Kelurahan::model()->findByPk($val->kel_id);
                $row = array();
                array_push($row, $i);
                if($kelurahan!=null){array_push($row, $kelurahan->kel_nama);}
                array_push($row, $val->pusk_kode_puskesmas);
                array_push($row, $val->pusk_nama);
                array_push($row, $val->pusk_alamat);
                array_push($row, $val->pusk_jenis_puskesmas);
//                array_push($row, $val->pusk_kordinat_x);
//                array_push($row, $val->pusk_kordinat_y);
                if(!Yii::app()->user->isGuest){ 
                    array_push($row, "<a class='btn btn-mini btn-success btn-xs btn-update-puskesmas' onclick='showUpdate(\"$val->pusk_id\")' title='edit'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini btn-danger delete' href='#' title='delete' onclick='confirmDelete(\"$val->pusk_id\")'><i class='icon-trash'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini btn-primary' href='" . Yii::app()->request->baseUrl . "/index.php/?r=puskesmas/detil&pusk_id=" . $val->pusk_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                }    
                array_push($data, $row);
                $i++;
            }
            
            
            
            $this->render('index', array( 
            'model' => json_encode($data), 
                ));
                
                
        }
        public function actionUpdate(){
            if (isset($_POST['id'])){
                $pusk_id = $_POST['id'];
                $model = Puskesmas::model()->findByPk($pusk_id);
                $lurah = Kelurahan::model()->findAll();
                $selLurah = Kelurahan::model()->findByPk($model->kel_id);
                $list = array();
                foreach($lurah as $id){
                    array_push($list, array('id' => $id->kel_id, 'nama' => $id->kel_nama));
                }
                $data = array();
                array_push($data, $model->pusk_id);
                array_push($data, $model->pusk_kode_puskesmas);
                array_push($data, $model->pusk_nama);
                array_push($data, $model->pusk_alamat);
                array_push($data, $model->pusk_jenis_puskesmas);
                array_push($data, $model->pusk_kordinat_x);
                array_push($data, $model->pusk_kordinat_y);
                array_push($data, $model->pusk_informasi);
                array_push($data, $model->pusk_keterangan);
                array_push($data, $model->pusk_icon_map);
                array_push($data, $selLurah->kel_id);
                array_push($data, json_encode($list));
                
                echo json_encode($data);
            }
            else if(isset($_POST['Puskesmas'])){
                $model = new Puskesmas;
                $model->attributes=$_POST['Puskesmas'];
                $model->pusk_icon_map="puskesmas4.png";
                $model->pusk_informasi="";
                $model->pusk_keterangan="";
                if($model->updateByPk($model->pusk_id, $model)){
                    Yii::app()->request->redirect("index.php?r=puskesmas");
                    
                }else{
                    print_r($model);
                    echo "Gagal Update";
                  
                }
                    
            }
//            return $this->render('index');
        }
        
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        public function actionDetil(){
            $pusk_id = $_GET['pusk_id'];
            $model = Puskesmas::model()->findByPk($pusk_id);
            $kelurahan = Kelurahan::model()->findByPk($model->kel_id);
            $dtInfo = DtPuskesmas::model()->findAllByAttributes(
                    array(),
                    $condition  = 'pusk_id = :pusk_id',
                    $params     = array(
                            ':pusk_id' => $pusk_id, 
                    )
            );
            $data = array();
            $tInfo = array();
                foreach($dtInfo as $info){
                    array_push($tInfo, array(
                        'dt_id' => $info->dt_id,
                        'column' => $info->dt_column, 
                        'information' => $info->dt_information,
                        
                    ));
                    
                }
                
                array_push($data, $kelurahan->kel_nama);
                array_push($data, $model->pusk_kode_puskesmas);
                array_push($data, $model->pusk_nama);
                array_push($data, $model->pusk_alamat);
                array_push($data, $model->pusk_jenis_puskesmas);
                array_push($data, $model->pusk_kordinat_x);
                array_push($data, $model->pusk_kordinat_y);
                array_push($data, $model->pusk_informasi);
                array_push($data, $model->pusk_keterangan);
                array_push($data, $model->pusk_id);
            $this->render('detil', array(
                'data' => $data,  'informasi' => json_encode($tInfo),
            ));
        }
        
        public function actionPrint(){
            $pusk_id = $_GET['pusk_id'];
            $model = Puskesmas::model()->findByPk($pusk_id);
            $kelurahan = Kelurahan::model()->findByPk($model->kel_id);
            $dtInfo = DtPuskesmas::model()->findAllByAttributes(
                    array(),
                    $condition  = 'pusk_id = :pusk_id',
                    $params     = array(
                            ':pusk_id' => $pusk_id, 
                    )
            );
            $data = array();
            $tInfo = array();
                foreach($dtInfo as $info){
                    array_push($tInfo, array(
                        'dt_id' => $info->dt_id,
                        'column' => $info->dt_column, 
                        'information' => $info->dt_information,
                        
                    ));
                    
                }
                
                array_push($data, $kelurahan->kel_nama);
                array_push($data, $model->pusk_kode_puskesmas);
                array_push($data, $model->pusk_nama);
                array_push($data, $model->pusk_alamat);
                array_push($data, $model->pusk_jenis_puskesmas);
                array_push($data, $model->pusk_kordinat_x);
                array_push($data, $model->pusk_kordinat_y);
                array_push($data, $model->pusk_informasi);
                array_push($data, $model->pusk_keterangan);
            
            $this->renderPartial('print', array(
                'data' => $data,  'informasi' => json_encode($tInfo),
            ));
        }
        public function actionDelete(){
            $id = $_POST['id'];
            $model = Puskesmas::model()->findByPk($id);
            if($model->delete()){
                echo "1";
            } else {
                echo "0";
            }
        }
        public function actionAdd(){
            $model = new Puskesmas;
            if(isset($_POST['ajax']) && $_POST['ajax']==='puskesmas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
            
            $uuid=$model->getUUID();
            if(isset($_POST['Puskesmas'])){
                $model->attributes=$_POST['Puskesmas'];
                $model->pusk_icon_map='puskesmas4.png';
                if($model->save(false)){
                    $this->redirect(array ('/puskesmas/index'));
                }
            }
            $kelurahan = Kelurahan::model()->findAll();
            $data=array();
            $data = CHtml::listData($kelurahan, 'kel_id', 'kel_nama');

            return $this->render('add', array(
                'model'=> $model, 'data' => $data, 'uuid' =>$uuid,
            ));
        }
        
        public function actionaddInformasi(){
            if(isset($_POST['column']) && isset($_POST['info'])){
                $model = new DtPuskesmas;
                $column = $_POST['column'];
                $info = $_POST['info'];
                $pusk_id = $_POST['id'];
                
                $model->dt_column=$column; 
                $model->pusk_id = $pusk_id;
                $model->dt_information = $info;
                if($model->save(false)){
                    echo "1";
            }else{
                    echo "0";
                }
                
            } 
        }
        
        public function actionupdateInformasi(){
            if(isset($_POST['update'])){
                $update = DtPuskesmas::model()->findByPk($_POST['dt_id']);
                $update->dt_column=$_POST['dt_column'];
                $update->dt_information=$_POST['dt_information'];
                if($update->save()){
                    echo "1";
                }else
                    echo "0";
            }else{
                $dt_id = $_POST['id'];
                $model = DtPuskesmas::model()->findByPk($dt_id);
                $data = array();
                array_push($data, array( 
                        'dt_id' => $model->dt_id,
                        'column' => $model->dt_column , 
                        'information' => $model->dt_information,
                        ));

                echo json_encode($data);
            }
            
        }

        public function actiondeleteInformasi() {
            $id = $_POST['id'];
            $model = DtPuskesmas::model()->findByPk($id);
            if($model->delete()){
                echo "1";
            } else {
                echo "0";
            }
        }
        
        public function loadModel($id)
	{
		$model=  Puskesmas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function accessRules() {
            return array(
                array('deny', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('index'),
                    'users' => array('guest'),
                ),
                array('allow', // allow only the owner to perform 'view' 'update' 'delete' actions
                    'actions' => array('index', 'update', 'delete'),
                    'expression' => 'Yii::app()->user->level == "admin"'
                ),
            );
        }
        
        
        
        
        
        // Uncomment the following methods and override them if needed
	
	public function filters()
	{
                return array('accessControl');
                
	}

}