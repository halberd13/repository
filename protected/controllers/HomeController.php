<?php

class HomeController extends Controller
{
	public function actionIndex()
	{
            
            $dtpuskesmas = Puskesmas::model()->findAll();
            $dtkecamatan = Kecamatan::model()->findAll();
            $dtkelurahan = Kelurahan::model()->findAll();
            $allData = array();
            $data_pusk = array();
            $data_kec = array();
            $data_kel = array();
            foreach ($dtpuskesmas as $val) {
                $row = array();                    
                array_push($row, $val->pusk_kordinat_x);
                array_push($row, $val->pusk_kordinat_y);
                array_push($row, $val->pusk_nama);
                array_push($row, $val->pusk_icon_map);
                array_push($row, $val->pusk_id);
                array_push($row, $val->pusk_alamat);
                array_push($data_pusk, $row);
                array_push($allData, "Puskesmas ".$val->pusk_nama);
                
            }
            foreach ($dtkecamatan as $kec){
                $row = array();
                array_push($row, $kec->kec_kordinat_x);
                array_push($row, $kec->kec_kordinat_y);
                array_push($row, $kec->kec_nama);
                array_push($row, $kec->kec_icon_map);
                array_push($row, $kec->kec_id);
                array_push($row, $kec->kec_alamat);
                array_push($data_kec, $row);
                array_push($allData, "Kecamatan ".$kec->kec_nama);
                
                
            }
            foreach ($dtkelurahan as $kel){
                $row = array();
                array_push($row, $kel->kel_kordinat_x);
                array_push($row, $kel->kel_kordinat_y);
                array_push($row, $kel->kel_nama);
                array_push($row, $kel->kel_icon_map);
                array_push($row, $kel->kel_id);
                array_push($row, $kel->kel_alamat);
                array_push($data_kel, $row);
                array_push($allData, "Kelurahan ".$kel->kel_nama);
                
            }
            

            $this->render('index', array(
                'dtpuskesmas' => json_encode($data_pusk), 
                'dtkecamatan' => json_encode($data_kec),
                'dtkelurahan' => json_encode($data_kel),
                'model' => json_encode($allData),
                ));
	}
        
        public function actionReport()
        {
                $kecamatan = new Kecamatan;
                $dtKelurahan = new DtKelurahan();
                $dtInfoKelurahan = new DtInfoKelurahan;
                $categoryKecamatan=array();
                //query for highchart
                    $listName = $dtKelurahan->getColumnName();
                    $seriesKecamatan=array();
                    foreach($listName as $names){
                        $rData =array();
                        $list = $kecamatan->getListInformasi($names['dt_column']);
                        foreach($list as $lists){
                            array_push($rData, (int)$lists['data']);
                        }
                        array_push($seriesKecamatan, array('name'=>$list[0]['name'],'type'=> 'column', 'tooltip' => array( 'valueSuffix'=> ' '.$list[0]['unit']), 'data'=>$rData));
                    }
                    $rCtg =$kecamatan->getListInformasi($listName[0]['dt_column']);
                    foreach($rCtg as $rCtgs){
                        $rVal = 'Kecamatan '.$rCtgs['kecamatan']; 
                        array_push($categoryKecamatan, $rVal);
                    }
                    
                    //HighChart For Keluran Detil
                    $kelurahan = new Kelurahan;
                    $dtKelurahan = new DtKelurahan;
                    //get Highchart query
                    $categorys = $kelurahan->getListCategory();
                    $categoryKelurahan = array();
                    foreach($categorys as $ctg){
                        array_push($categoryKelurahan, 'Kel. '.$ctg['kelurahan']);
                    }
                    $columnName = $dtKelurahan->getColumnName();
                    $seriesKelurahan=array();
                    foreach($columnName as $ctg){
                            $list = $kelurahan->getListInformasi($ctg['dt_column']);
                            $rList = array();
                            $rVal = array();
                            foreach($list as $lists){
                                array_push($rList, (int)$lists['data']);
                            }
                            array_push($seriesKelurahan, array('name' => $list[0]['name'],'tooltip' => array( 'valueSuffix'=> ' '.$list[0]['unit']) ,'data'=>$rList));
                    } 

                    $categoryBulan = $dtKelurahan->getListMonth();
                    
                    
                    

                $this->render('report', array( 
                'category_kec' => json_encode($categoryKecamatan),  
                'category_kel' => json_encode($categoryKelurahan),  
                'series_kec' => json_encode($seriesKecamatan),  
                'series_kel' => json_encode($seriesKelurahan),  
                'category_bulan' => json_encode($categoryBulan),  
                    ));
                
            
        }
        
        
        
        public function actiongetRoute(){
            if(isset($_POST['origin']) && isset($_POST['desti'])){
                $origin = $_POST['origin'];
                $tOrigin = explode(" ", $_POST['origin']);
                $desti = $_POST['desti'];
                $tDesti = explode(" ", $_POST['desti']);
                $tPointOrigin = array();
                $tPointDesti = array();
                
                if($tOrigin[0]=='Kecamatan'){
                    $origin = substr($origin, 10, strlen($origin ));
                    $model = Kecamatan::model()->findByAttributes(
                            array(),
                            'UPPER(kec_nama) like UPPER(:origin)', array(':origin'=>$origin)
                            );
                    array_push($tPointOrigin, $model->kec_kordinat_x);
                    array_push($tPointOrigin, $model->kec_kordinat_y);
                }else if($tOrigin[0]=='Kelurahan'){
                    $origin = substr($origin, 10, strlen($origin ));
                    $model = Kelurahan::model()->findByAttributes(
                            array(),
                            'UPPER(kel_nama) like UPPER(:origin)', array(':origin'=>$origin)
                            );
                    array_push($tPointOrigin, $model->kel_kordinat_x);
                    array_push($tPointOrigin, $model->kel_kordinat_y);
                }
                else if($tOrigin[0]=='Puskesmas'){
                    $origin = substr($origin, 10, strlen($origin ));
                    $model = Puskesmas::model()->findByAttributes(
                            array(),
                            'UPPER(pusk_nama) like UPPER(:origin)', array(':origin'=>$origin)
                            );
                    array_push($tPointOrigin, $model->pusk_kordinat_x);
                    array_push($tPointOrigin, $model->pusk_kordinat_y);
                }
                
                if($tDesti[0]=='Kecamatan'){
                    $desti = substr($desti, 10, strlen($desti ));
                    $model = Kecamatan::model()->findByAttributes(
                            array(),
                            $condition  = 'kec_nama = :kec_nama',
                            $params     = array(
                                ':kec_nama' => $desti, 
                    ));
                    array_push($tPointDesti, $model->kec_kordinat_x);
                    array_push($tPointDesti, $model->kec_kordinat_y);
                }
                else if($tDesti[0]=='Kelurahan'){
                    $desti = substr($desti, 10, strlen($desti ));
                    $model = Kelurahan::model()->findByAttributes(
                            array(),
                            'UPPER(kel_nama) like UPPER(:desti)', array(':desti'=>$desti)
                            );
                    array_push($tPointDesti, $model->kel_kordinat_x);
                    array_push($tPointDesti, $model->kel_kordinat_y);
                }
                else if($tDesti[0]=='Puskesmas'){
                    $desti = substr($desti, 10, strlen($desti ));
                    $model = Puskesmas::model()->findByAttributes(
                            array(),
                            'UPPER(pusk_nama) like UPPER(:desti)', array(':desti'=>$desti)
                            );
                    array_push($tPointDesti, $model->pusk_kordinat_x);
                    array_push($tPointDesti, $model->pusk_kordinat_y);
                }
                echo json_encode(array( 'origin' => $tPointOrigin, 'desti'=> $tPointDesti));
                
            
                
            }else {
                echo "Route is not found";
            }
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
        */
        
        public function actionSearch(){
            if(isset($_POST['search'])){
                $search = $_POST['search'];
                $tSearch = explode(" ", $_POST['search']);
                $tPointSearch = array();
                if($tSearch[0]=='Kecamatan'){
                    $search = substr($search, 10, strlen($search ));
                    $model = Kecamatan::model()->findByAttributes(
                            array(),
                            'UPPER(kec_nama) like UPPER(:origin)', array(':origin'=>$search)
                            );
                    array_push($tPointSearch, $model->kec_kordinat_x);
                    array_push($tPointSearch, $model->kec_kordinat_y);
                    array_push($tPointSearch, $model->kec_nama);
                    array_push($tPointSearch, $model->kec_alamat);
                    array_push($tPointSearch, $model->kec_icon_map);
                    array_push($tPointSearch, $model->kec_id);
                    array_push($tPointSearch, 'kecamatan');
                }else if($tSearch[0]=='Kelurahan'){
                    $search = substr($search, 10, strlen($search ));
                    $model = Kelurahan::model()->findByAttributes(
                            array(),
                            'UPPER(kel_nama) like UPPER(:origin)', array(':origin'=>$search)
                            );
                    array_push($tPointSearch, $model->kel_kordinat_x);
                    array_push($tPointSearch, $model->kel_kordinat_y);
                    array_push($tPointSearch, $model->kel_nama);
                    array_push($tPointSearch, $model->kel_alamat);
                    array_push($tPointSearch, $model->kel_icon_map);
                    array_push($tPointSearch, $model->kel_id);
                    array_push($tPointSearch, 'kelurahan');
                }
                else if($tSearch[0]=='Puskesmas'){
                    $search = substr($search, 10, strlen($search ));
                    $model = Puskesmas::model()->findByAttributes(
                            array(),
                            'UPPER(pusk_nama) like UPPER(:origin)', array(':origin'=>$search)
                            );
                    array_push($tPointSearch, $model->pusk_kordinat_x);
                    array_push($tPointSearch, $model->pusk_kordinat_y);
                    array_push($tPointSearch, $model->pusk_nama);
                    array_push($tPointSearch, $model->pusk_alamat);
                    array_push($tPointSearch, $model->pusk_icon_map);
                    array_push($tPointSearch, $model->pusk_id);
                    array_push($tPointSearch, 'puskesmas');
                }
                echo json_encode(array('point' => $tPointSearch));
            }
        }


        public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'aclist'=>array(
				'class'=>'application.extensions.EAutoCompleteAction',
				'model'=>'My',
                                'attribute'=>'my_name', 
			),
		);
	}
	
        
        public function accessRules() {
            return array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('index', 'search','route'),
                    'users' => array('*'),
                ),
                array('allow', // allow only the owner to perform 'view' 'update' 'delete' actions
                    'actions' => array('report'),
                    'users' => array('@'),
                ),
                array('deny', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('report'),
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