<?php

class KelurahanController extends Controller
{
	public function actionIndex()
	{
            $kelurahan = new Kelurahan();
            $indicator= new Indicator();
            $category = new Category();
            $listCategory = $category->findAll();
            $data = array();
            $i=1;
            foreach ($kelurahan->findAll() as $val) {
                $kecamatan = Kecamatan::model()->findByPk($val->kec_id);
                $row = array();
                array_push($row, $i);
                array_push($row, $kecamatan->kec_nama);
                array_push($row, $val->kel_nama);
                array_push($row, $val->kel_alamat);
                array_push($row, $val->kel_kordinat_x);
                array_push($row, $val->kel_kordinat_y);
                if(Yii::app()->user->level=='admin'){ 
                    array_push($row, "<a class='btn btn-mini btn-success how-update-kelurahan' title='edit' onclick='showUpdate(\"$val->kel_id\")'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini btn-danger delete' onclick='confirmDelete(\"$val->kel_id\")' title='delete'><i class='icon-trash'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini btn-primary' href='". Yii::app()->request->baseUrl . "/index.php/?r=kelurahan/detil&kel_id=" . $val->kel_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                }else if(Yii::app()->user->level=='kelurahan'){
                    if(Yii::app()->user->privilege==$val->kel_id){
                        array_push($row, "<a class='btn btn-mini btn-warning how-update-kelurahan' title='edit' onclick='showUpdate(\"$val->kel_id\")'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;"
                            . "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kelurahan/detil&kel_id=" . $val->kel_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");    
                    }else{
                        array_push($row, "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kelurahan/detil&kel_id=" . $val->kel_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");    
                    }
                }else{
                    array_push($row, "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kelurahan/detil&kel_id=" . $val->kel_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");    
                }    
                array_push($data, $row);
                $i++;
               
            }
            $listIndicator = $indicator->findAll();
            $uuid=$kelurahan->getUUID();
            
            $this->render('index', array( 
                'model' => json_encode($data),
                'listIndicator'=> $listIndicator,
                'listCategory'=> $listCategory,
                
                ));
                
	}

        public function actionAdd(){
            $model = new Kelurahan;
            $kecamatan = Kecamatan::model()->findAll();
            $tKecamatan = array();
            $tKecamatan = CHtml::listData($kecamatan, 'kec_id', 'kec_nama');
            $indicator= Indicator::model()->findAll();
            $dtIndicator = new DtIndicator();
            $uuid=$model->getUUID();
            
            if(isset($_POST['Kelurahan'])){
                $model->attributes=$_POST['Kelurahan'];
                $model->kel_informasi='';
                $model->kel_keterangan='';
                $model->kel_icon_map="kelurahan.png";
                if($model->save(false)){
                    if($indicator!=null){
                        foreach($indicator as $idc){
                            for($i=1;$i<=12;$i++){
                                $dtIndicator = new DtIndicator();
                                $dtIndicator->idc_id= $idc->idc_id;
                                $dtIndicator->kel_id= $model->kel_id;
                                $dtIndicator->dt_value=0;
                                if($i<10){
                                    $dtIndicator->dt_periode= "20140".$i;
                                }else{
                                    $dtIndicator->dt_periode= "2014".$i;
                                }
                                $dtIndicator->dt_last_update = new CDbExpression('NOW()');
                                $dtIndicator->save(false);
                                    
                            }
                        }
                    }
                    $this->redirect(array ('/kelurahan&rc=00'));
                }else{
                    $this->redirect(array ('/kelurahan&rc=05'));
                }
            }
            
            return $this->render('add', array(
                'model'=> $model, 'kecamatan' => $tKecamatan, 'uuid' => $uuid,
            ));
        }
        
        public function actionUpdate(){
            if (isset($_POST['id'])){
                $model = Kelurahan::model()->findByPk($_POST['id']);
                $kecamatan = Kecamatan::model()->findAll();
                $selKec = Kecamatan::model()->findByPk($model->kec_id);
                $list = array();
                $data = array();
                foreach($kecamatan as $val){
                    array_push($list, array('id' => $val->kec_id, 'nama' => $val->kec_nama));
                }
                
                array_push($data, $model->kel_id);
                array_push($data, $model->kel_nama);
                array_push($data, $model->kel_alamat);
                array_push($data, $model->kel_kordinat_x);
                array_push($data, $model->kel_kordinat_y);
                array_push($data, $selKec->kec_id);
                array_push($data, json_encode($list));
                echo json_encode($data);
                
            }else if(isset($_POST['Kelurahan'])){
                $data = $_POST['Kelurahan'];
                $model = new Kelurahan;
                $model->attributes=$_POST['Kelurahan'];
                $model->kel_icon_map='kelurahan.png';
                $model->kel_informasi="";
                $model->kel_keterangan="";
                if($model->updateByPk($model->kel_id, $model)){
                    Yii::app()->request->redirect("index.php?r=kelurahan&rc=00");
                }else{
                    Yii::app()->request->redirect("index.php?r=kelurahan&rc=05");
                }
            }
        }

        public function actionDelete(){
            $id = $_POST['id'];
            $model = Kelurahan::model()->findByPk($id);
            if($model->delete()){
                echo "1";
            } else {
                echo "0";
            }
        }
        
        public function actionDetil(){
            $kel_id = $_GET['kel_id'];
            $model = Kelurahan::model()->findByPk($kel_id);
            $kelurahan = new Kelurahan();
            $indicator = new Indicator();
            $kecamatan = new Kecamatan();
            $selectTahun = $kecamatan->getTahunIndicator();
            $dtIndicator = new DtIndicator();
            $kec_nama = Kecamatan::model()->findByPk($model->kec_id);
            $headerTableIndicator = $indicator->findAll('idc_id=idc_id order by idc_nama'); 
            $data = array();
            array_push($data, $model->kel_id);
            array_push($data, $model->kel_nama);
            array_push($data, $model->kel_alamat);
            array_push($data, $model->kel_kordinat_x);
            array_push($data, $model->kel_kordinat_y);
            array_push($data, $kec_nama->kec_nama);
            array_push($data, $kelurahan->getListMonth());

            if(isset($_POST['tahun'])){
                array_push($data, $_POST['tahun']);
                $rowTableIndicator = $kelurahan->getDetilIndicatorInYears($kel_id, $_POST['tahun']);
            }else {
                $rowTableIndicator = $kelurahan->getDetilIndicatorInYears($kel_id, date('Y'));
            }
            
            
            $this->render('detil', array(
                    'data' => $data,  
                    'selectTahun' => $selectTahun,  
                    'rowInfoKelurahan' => $rowTableIndicator,
                    'headerTableIndicator' =>$headerTableIndicator,
            ));
            
        
        }
        public function actionPrint(){
            $kel_id = $_GET['kel_id'];
            $model = Kelurahan::model()->findByPk($kel_id);
            $kelurahan = new Kelurahan();
            $indicator = new Indicator();
            $dtIndicator = new DtIndicator();
            $kecamatan = Kecamatan::model()->findByPk($model->kec_id);
            $headerTableIndicator = $indicator->findAll(); 
            $data = array();
            array_push($data, $model->kel_id);
            array_push($data, $model->kel_nama);
            array_push($data, $model->kel_alamat);
            array_push($data, $model->kel_kordinat_x);
            array_push($data, $model->kel_kordinat_y);
            array_push($data, $kecamatan->kec_nama);
            array_push($data, $kelurahan->getListMonth());

            if(isset($_POST['tahun'])){
                array_push($data, $_POST['tahun']);
                $rowTableIndicator = $kelurahan->getDetilIndicatorInYears($kel_id, $_POST['tahun']);
            }else {
                $rowTableIndicator = $kelurahan->getDetilIndicatorInYears($kel_id, date('Y'));
            }
            
            $this->renderPartial('print', array(
                    'data' => $data,  
                    'rowInfoKelurahan' => $rowTableIndicator,
                    'headerTableIndicator' =>$headerTableIndicator,
            ));
        
        }
        
        
        
        public function actionaddInformasi(){
            if(isset($_POST['addIndicator']) && $_POST['addIndicator']=true){
                $namaIndicator = $_POST['namaIndicator'];
                $satuan = $_POST['satuan'];
                $category = $_POST['category'];
                
                $kelurahan = new Kelurahan();
                $indicator = new Indicator();
                
                $uuid=$indicator->getUUID();
                $indicator->idc_id=$uuid['uuid'];
                $indicator->idc_nama=trim($namaIndicator);
                $indicator->idc_satuan=trim($satuan);
                $indicator->idc_category=$category;
                $getYearRows=$indicator->getYearRows();
                $totalYearRows=count($getYearRows);
                try{
                    if($indicator->save()){
                        $rowDtIndicatorInserted=0;
                        if(isset($getYearRows[0]['tahun'])){
                            foreach($getYearRows as $YearRows){
                                if($YearRows['tahun']==date('Y')){
                                    foreach($kelurahan->findAll() as $val){
                                        for($i=1;$i<=12;$i++){
                                            $dtIndicator = new DtIndicator();
                                            $dtIndicator->idc_id= $indicator->idc_id;
                                            $dtIndicator->kel_id= $val->kel_id;
                                            $dtIndicator->dt_value=0;
                                            if($i<10){
                                                $dtIndicator->dt_periode= $YearRows['tahun']."0".$i;
                                            }else{
                                                $dtIndicator->dt_periode= $YearRows['tahun'].$i;
                                            }
                                            $dtIndicator->dt_last_update = new CDbExpression('NOW()');
                                            if($dtIndicator->save(false)){
                                                $rowDtIndicatorInserted++;
                                            }
                                        }
                                    }
                                }else{
                                    foreach($kelurahan->findAll() as $val){
                                        for($i=1;$i<=12;$i++){
                                            $dtIndicator = new DtIndicator();
                                            $dtIndicator->idc_id= $indicator->idc_id;
                                            $dtIndicator->kel_id= $val->kel_id;
                                            $dtIndicator->dt_value=0;
                                            if($i<10){
                                                $dtIndicator->dt_periode= date('Y')."0".$i;
                                            }else{
                                                $dtIndicator->dt_periode= date('Y').$i;
                                            }
                                            $dtIndicator->dt_last_update = new CDbExpression('NOW()');
                                            if($dtIndicator->save(false)){
                                                $rowDtIndicatorInserted++;
                                            }
                                        }
                                    }
                                }
                            }
                        }else {
                            foreach($kelurahan->findAll() as $val){
                                for($i=1;$i<=12;$i++){
                                    $dtIndicator = new DtIndicator();
                                    $dtIndicator->idc_id= $indicator->idc_id;
                                    $dtIndicator->kel_id= $val->kel_id;
                                    $dtIndicator->dt_value=0;
                                    if($i<10){
                                        $dtIndicator->dt_periode= date('Y')."0".$i;
                                    }else{
                                        $dtIndicator->dt_periode= date('Y').$i;
                                    }
                                    $dtIndicator->dt_last_update = new CDbExpression('NOW()');
                                    if($dtIndicator->save(false)){
                                        $rowDtIndicatorInserted++;
                                    }
                                }
                            }
                        }
                        echo $rowDtIndicatorInserted." Data Indicator berhasil ditambahkan di ".count($kelurahan->findAll())." masing-masing Kelurahan" ;
                    
                    }else{
                        $indicator->deleteByPk($indicator->idc_id);
                        throw $e;
                    }
                }catch (Exception $e){
                    throw $e;
                }
                
            } 
        }
        
        
        public function actionupdateInformasi(){
            //do update form action jquery post on page detil
            if(isset($_POST['updateDataIndicator'])){
                $update = new DtIndicator;
                $arrData = json_decode($_POST['data']);
                $arrDtIdicator = $arrData->data;
                $valUpd = 0;
                for($i=0;$i<count($arrDtIdicator);$i++){
                    $dt_id=$arrDtIdicator[$i][0];
                    $dt_value=$arrDtIdicator[$i][1];
                    $dt_keterangan=$arrDtIdicator[$i][3];
                    $dt_last_update=new CDbExpression('NOW()');
                    if($update->updateByPk($dt_id, array('dt_value'=>$dt_value,'dt_last_update'=>$dt_last_update, 'dt_keterangan'=>$dt_keterangan ))){
                        $valUpd=$valUpd+1;
                    }
                }
                echo $valUpd;
                
            //data for append to modal update detil indicator
            }else if(isset($_POST['getShowUpdateDataIndicator'])&& $_POST['getShowUpdateDataIndicator']==true){ 
                $idc_id = $_POST['idc_id'];
                $kel_id = $_POST['kel_id'];
                $thn = $_POST['tahun'];
                $kelurahan = new Kelurahan();
                $rData = $kelurahan->getDetilIndicator($kel_id, $idc_id, $thn);
                echo json_encode($rData);
                
            //for update master data of Indicator name
            }else if(isset($_POST['updateIndicator']) && $_POST['updateIndicator']==true ){
                $idc_id = $_POST['idc_id'];
                $idc_nama = $_POST['nama'];
                $idc_satuan = $_POST['satuan'];
                $idc_category = $_POST['category'];
                $indicator = new Indicator();
                $indicator->idc_id=$idc_id;
                $indicator->idc_nama=$idc_nama;
                $indicator->idc_satuan=$idc_satuan;
                $indicator->idc_category=$idc_category;
                if($indicator->updateByPk($idc_id, $indicator)){
                    echo "1";
                }else{
                    echo "0";
                }
            }
            
        }
        
        public function actiondeleteInformasi() {
            $idc_id = $_POST['idc_id'];
            $model = new Indicator;
            if($model->deleteByPk($idc_id)){
                echo "1";
            } else {
                echo "0";
            }
        }
        
        
        public function actionaddCategory(){
            if(isset($_POST['ctg_nama'])){
                $kelurahan = new Kelurahan();
                $category = new Category();
                $category->ctg_nama = $_POST['ctg_nama'];
                $ctg_id = $kelurahan->getUUID();
                $category->ctg_id = $ctg_id['uuid'];
                $category->ctg_last_update = new CDbExpression('NOW()');
                if($category->save()){
                    Yii::app()->request->redirect("index.php?r=kelurahan&rc=00");
                }else{
                    throw new CHttpException(556,'Failed Insert Database, The specified post cannot be found.');
                }
            }else
                throw new CHttpException(505,'The specified post cannot be found.');
        }
        
        public function actionupdateCategory(){
            if(isset($_POST['upd-ctg_id'])){
                $kelurahan = new Kelurahan();
                $category = new Category();
                $category->ctg_nama = $_POST['upd-ctg_name'];
                $category->ctg_id = $_POST['upd-ctg_id'];
                $category->ctg_last_update = new CDbExpression('NOW()');
                if($category->updateByPk($_POST['upd-ctg_id'], $category)){
                    Yii::app()->request->redirect("index.php?r=kelurahan&rc=00");
                }else{
                    throw new CHttpException(556,'Failed Insert Database, The specified post cannot be found.');
                }
            }else
                throw new CHttpException(505,'The specified post cannot be found.');
        }
        
        public function actiondeleteCategory(){
            if(isset($_POST['deleteCategory'])){
                $category = new Category();
                if($category->deleteByPk($_POST['ctg_id'])){
                    echo "1";
                }else{
                    throw new CHttpException(556,'Failed Insert Database, The specified post cannot be found.');
                }
            }else
                throw new CHttpException(505,'The specified post cannot be found.');
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
        
        public function accessRules() {
            return array(
                array('deny',
                    'actions' => array('*'),
                    'users' => array('?'),
                ),
                array('deny', 
                    'deniedCallback' => function() {
                        Yii::app()->request->redirect('index.php?r=user/login');
                    },
                    'users' => array('?'),
                ),
            );
        }
        
        public function filters()
	{
                return array('accessControl');
                
	}
        
}