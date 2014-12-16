<?php


class KecamatanController extends Controller
{
	public function actionIndex()
	{
            $kecamatan = new Kecamatan;
            $data = array();
            $category=array();
            $i=1;
            
            foreach ($kecamatan->findAll() as $val) {
                $row = array();
                array_push($row, $i);
                array_push($row, $val->kec_nama);
                array_push($row, $val->kec_alamat);
                array_push($row, $val->kec_kordinat_x);
                array_push($row, $val->kec_kordinat_y);
                if(Yii::app()->user->level=='admin'){ 
                    array_push($row, "<a class='btn btn-mini btn-success btn-xs show-update-kecamatan' onclick='showUpdate(\"$val->kec_id\")' title='edit'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini btn-danger delete' onclick='confirmDelete(\"$val->kec_id\")' title='delete'><i class='icon-trash'></i></a>&nbsp;&nbsp;&nbsp;"
                        . "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kecamatan/detil&kec_id=" . $val->kec_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                    
                }else if(Yii::app()->user->level=='kecamatan'){ 
                    if(Yii::app()->user->privilege==$val->kec_id){
                        array_push($row, "<a class='btn btn-mini btn-warning btn-xs show-update-kecamatan' onclick='showUpdate(\"$val->kec_id\")' title='edit'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;"
                                    . "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kecamatan/detil&kec_id=" . $val->kec_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                    }else{
                        array_push($row, "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kecamatan/detil&kec_id=" . $val->kec_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                    }
                }else if(Yii::app()->user->level=='kelurahan'){
                    array_push($row, "<a class='btn btn-mini' href='". Yii::app()->request->baseUrl . "/index.php/?r=kecamatan/detil&kec_id=" . $val->kec_id . "' title='Detil Map'><i class='icon-map-marker'></i></a>");
                    
                }
                array_push($data, $row);
                $i++;
            }
            
            $this->render('index', array( 
            'model' => json_encode($data),   
                ));
                
                
	}
        
        public function actionAdd(){
            $model = new Kecamatan;
            $uuid=$model->getUUID();
            if(isset($_POST['Kecamatan'])){
                $model->attributes=$_POST['Kecamatan'];
                $model->kec_informasi="null";
                $model->kec_keterangan="null";
                $model->kec_icon_map="kecamatan.png";
                if($model->save(false))
                    $this->redirect(array ('/kecamatan'));
            }
            
            return $this->render('add', array(
                'model'=> $model, 'uuid' => $uuid,
            ));
        }
        
        public function actionUpdate(){
            if (isset($_POST['id'])){
                $model = Kecamatan::model()->findByPk($_POST['id']);
                $data = array();
                array_push($data, $model->kec_id);
                array_push($data, $model->kec_nama);
                array_push($data, $model->kec_alamat);
                array_push($data, $model->kec_kordinat_x);
                array_push($data, $model->kec_kordinat_y);
                echo json_encode($data);
            }else if(isset($_POST['Kecamatan'])){
                $data = $_POST['Kecamatan'];
                $model = new Kecamatan;
                $model->attributes=$data;
                $model->kec_informasi='';
                $model->kec_keterangan='';
                $model->kec_icon_map='kecamatan.png';
                if($model->updateByPk($model->kec_id, $model)){
                    Yii::app()->request->redirect("index.php?r=kecamatan");
                    
                }else{
                    echo "Data gagal di Simpan";
                  
                }
            }
            
        }

        public function actionDelete(){
            $id = $_POST['id'];
            $model = Kecamatan::model()->findByPk($id);
            if($model->delete()){
                echo "1";
            } else {
                echo "0";
            }
        }
        
        
        public function actionDetil(){
            $kec_id = $_GET['kec_id'];
            $model = Kecamatan::model()->findByPk($kec_id);
            $kelurahan = new Kelurahan();
            $indicator = new Indicator();
            $kecamatan = new Kecamatan();
            $category = new Category();
            $listCategory = $category->findAll('ctg_id=ctg_id order by ctg_nama');
            $defaultCategory = $category->findBySql('select * from category limit 0,1');
            $selectTahun=$kecamatan->getTahunIndicator();
            $listMonth = $kelurahan->getListMonth();
            
            $arrDtIndicatorKecamatan=array();
            $data = array();
            array_push($data, $model->kec_id);
            array_push($data, $model->kec_nama);
            array_push($data, $model->kec_alamat);
            array_push($data, $model->kec_kordinat_x);
            array_push($data, $model->kec_kordinat_y);
            array_push($data, $model->kec_icon_map);
            
            if(isset($_POST['tahun']) && isset($_POST['ctg_nama'])){
                array_push($data, array($_POST['tahun'], $_POST['ctg_nama']) );
                $listIndicator=$indicator->findAll('idc_category=:ctg_nama order by idc_nama', array(':ctg_nama'=>$_POST['ctg_nama']));
                //get data for table indicator every kecamatan for tahun and category selected
                foreach($listIndicator as $listIndicators){
                    array_push($arrDtIndicatorKecamatan, $kecamatan->getTotalIndicatorPerMonth($kec_id, $listIndicators['idc_id'], $_POST['tahun'],  $_POST['ctg_nama']));
                }    
                
            }else{
                array_push($data, array(date('Y'),$defaultCategory->ctg_nama ));
                $listIndicator=$indicator->findAll('idc_category=:ctg_nama order by idc_nama', array(':ctg_nama'=>$defaultCategory->ctg_nama));
                //get data for table indicator every kecamatan for tahun and cateogry selected
                foreach($listIndicator as $listIndicators){
                    array_push($arrDtIndicatorKecamatan, $kecamatan->getTotalIndicatorPerMonth($kec_id, $listIndicators['idc_id'], date('Y'), $defaultCategory->ctg_nama));
                }    
            }
                
            
            $this->render('detil', array(
                'data' => $data, 
                'selectTahun' => $selectTahun, 
                'dataIndicator'=> $arrDtIndicatorKecamatan,
                'listMonth' => $listMonth,
                'listIndicator' => $listIndicator,
                'listCategory' => $listCategory,
                    
            ));
        
        }
        
        public function actionPrint(){
            $kec_id = $_GET['kec_id'];
            $model = Kecamatan::model()->findByPk($kec_id);
            $kelurahan = new Kelurahan();
            $indicator = new Indicator();
            $kecamatan = new Kecamatan();
            $category = new Category();
            $data = array();
            array_push($data, $model->kec_id);
            array_push($data, $model->kec_nama);
            array_push($data, $model->kec_alamat);
            array_push($data, $model->kec_kordinat_x);
            array_push($data, $model->kec_kordinat_y);
            array_push($data, $model->kec_icon_map);
            
            $selectTahun=$kecamatan->getTahunIndicator();
            $listMonth = $kelurahan->getListMonth();
            $listIndicator=$indicator->findAll('idc_id=idc_id order by idc_nama');
            $listCategory = $category->findAll('ctg_id=ctg_id order by ctg_nama');
            $arrDtIndicatorKecamatan=array();
            if(isset($_POST['tahun'])){
                array_push($data, $_POST['tahun'] );
                //get data for table indicator every kecamatan for tahun selected
                $arrTotalIndicator = array();
                foreach($listIndicator as $listIndicators){
                    array_push($arrTotalIndicator, $kecamatan->getTotalAllIndicatorPerMonth($kec_id, $listIndicators['idc_id'], $_POST['tahun']));
                }    
                
            }else{
                array_push($data, date('Y'));
                //get data for table indicator every kecamatan for tahun selected
                $arrTotalIndicator = array();
                foreach($listIndicator as $listIndicators){
                    array_push($arrTotalIndicator, $kecamatan->getTotalAllIndicatorPerMonth($kec_id, $listIndicators['idc_id'], date('Y')));
                }    
            }
                
            
            $this->renderPartial('print', array(
                'data' => $data, 
                'selectTahun' => $selectTahun, 
                'dataIndicator'=> $arrTotalIndicator,
                'listMonth' => $listMonth,
                'listIndicator' => $listIndicator,
                'listCategory' => $listCategory,
                    
            ));
        
        }
        
        
        
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
        
        
        
        
        
        // Uncomment the following methods and override them if needed
	
	public function filters()
	{
                return array('accessControl');
                
	}
        /*
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
        
        
}