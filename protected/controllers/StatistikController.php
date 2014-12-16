<?php

class StatistikController extends Controller
{
	public function actionIndex()
	{   
            $kecamatan = new Kecamatan();
            $kelurahan = new Kelurahan();
            $dtIndicator = new DtIndicator();
            $indicator = new Indicator();
            $category = new Category();
            $listCategory = $category->findAll();
            $listKelurahan = $kelurahan->findAll('kel_id=kel_id order by kec_id');
            $categoryBulan = $kelurahan->getListMonth();
            $categoryKecamatan=array();
            $seriesKecamatan=array();
            $categoryKelurahan=array();
            $seriesKelurahan=array();
            $dSelect=array();
            $seriesAllKelurahan = array();
            $tahun=date('Y');
            $selectTahun=$kecamatan->getTahunIndicator();
            $bulan=date('m');
            $dCategory=null;
            
            if(isset($_GET['req'])&& $_GET['req']=='one'){
                $kel_id=$_POST['kel_id'];
                $kel_nama=$kelurahan->findByPk($kel_id)->kel_nama;
                $tahun=$_POST['tahun'];
                $dCategory=$_POST['category'];
            }else if(isset($_GET['req']) && $_GET['req']=='all'){
                //HighChart For All Kelurahan  Detil per bulan
                $kel_id=$listKelurahan[0]['kel_id'];
                $kel_nama=$listKelurahan[0]['kel_nama'];
                $tahun = $_POST['tahun'];
                $bulan = $_POST['bulan'];
                $dCategory=$_POST['category'];
            }else{
                //Default chart Kelurahan 
                $kel_id=$listKelurahan[0]['kel_id'];
                $kel_nama=$listKelurahan[0]['kel_nama'];
                $tahun=date('Y');
                $bulan='01';
                $dCategory=$listCategory[0]['ctg_nama'];
            }
                  
            //get Highchart query
            $namaIndicator = $indicator->findAll('idc_category=:idc_category',array(':idc_category'=>$dCategory));
            $i=0;
            foreach($namaIndicator as $ctg){
                    $list = $kelurahan->getDataIndicatorKelurahan($ctg->idc_id, $tahun.$bulan);
                    $rList = array();
                    
                    foreach($list as $lists){
                        array_push($rList, (int)$lists['dt_value']);
                        //Category highChart For All Kelurahan
                        if($i==0){
                            array_push($categoryKelurahan, $lists['kel_nama']);
                        }
                    }
                    array_push($seriesKelurahan, array('name' => $ctg->idc_nama,'tooltip' => array( 'valueSuffix'=> ' '.$ctg->idc_satuan) ,'data'=>$rList));
            $i++;
            }    
            
                    
            $listIndicator = $indicator->findAllByAttributes(array('idc_category'=>$dCategory));
             
//            foreach($listKelurahan as $ctg){
//                array_push($categoryKelurahan, 'Kel. '.$ctg['kel_nama']);
//            }        
            //This code for high chart per Month in Kelurahan
            foreach($listIndicator as $dt){
                $rowData = array();
                $dataChart = $dtIndicator->getDataIndicator($kel_id, $tahun, $dt->idc_id);
                foreach($dataChart as $row){
                    array_push($rowData, (int)$row['dt_value']);
                }
                array_push($seriesAllKelurahan, array(
                    'name'=>$dt->idc_nama, 
                    'data'=>$rowData,
                    'tooltip'=>array('valueSuffix'=>" ".$dt['idc_satuan'])
                    ));
            }


            $getSelectKelNama=$kelurahan->findByAttributes(array('kel_id'=>$kel_id));    
            $dSelect=array($kel_id,$kel_nama,$dCategory,$tahun,array($bulan,$kelurahan->getNameMonth($bulan)));
                
            
            
            
            $this->render('index', array(
                    'select'=>$dSelect,
                    'selectTahun'=>$selectTahun,
                    'listKelurahan' => $listKelurahan,
                    'series' => json_encode($seriesAllKelurahan),
                    'category_kel' => json_encode($categoryKelurahan),  
                    'series_kel' => json_encode($seriesKelurahan),  
                    'category_bulan' => $categoryBulan,  
                    'listCategory' => $listCategory,  
                ));

            
            
            
            
            
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