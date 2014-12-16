<?php

class JakutController extends Controller
{
	public function actionIndex()
	{
                $kelurahan = new Kelurahan;
                $kecamatan = new Kecamatan;
                $indicator = new Indicator();
                $dtIndicator = new DtIndicator();
                $category = $indicator->findAllBySql("select distinct idc_category from indicator");
                $series = array();
                $drillDown = array();
                $tmpDrill=array();
                $tmp = array();
                $dataIndicator = array();
                
                if(isset($_POST['tahun'])&& isset($_POST['bulan'])&& isset($_POST['category'])){
                    $tahun = $_POST['tahun'];
                    $bulan = $_POST['bulan'];
                    $dCategory = $_POST['category'];
                    $arrKec = $kecamatan->getDataIndicatorJakarta($tahun.$bulan,$dCategory);
                    
                }else{
                    $tahun=date('Y');
                    $bulan=date('m');
                    $dCategory=$category[0]['idc_category'];
                    $arrKec = $kecamatan->getDataIndicatorJakarta(date('Ym'),$dCategory);
                }
                
                foreach($arrKec as $arrs){
                    array_push($tmp, array(
                        'name'=>$arrs['idc_nama'],
                        'y'=>(int)$arrs['dt_value'],
                        'drilldown'=>$arrs['idc_nama']));
                    //push data drill down
                    $tmpDrill =$kecamatan->getIndicatorPerKecamatan($arrs['idc_id'], $tahun.$bulan);
                    
                    array_push($dataIndicator, $tmpDrill);
                    $tmpDtKec = array();
                    foreach($tmpDrill as $tmpDrills){
                        array_push($tmpDtKec, array($tmpDrills['kec_nama'], (int)$tmpDrills['dt_value']));
                    }
                    array_push($drillDown, array(
                        'id'=>$arrs['idc_nama'],
                        'name'=>$arrs['idc_nama'], 
                        'tooltip'=>array('valueSuffix'=>' '.$arrs['idc_satuan'], 'animation'=>true),
                        'data'=>$tmpDtKec));
                    
                }    
                array_push($series, array('name'=>'Jakarta Utara','colorByPoint'=>true,  'data'=>$tmp));
                $category_bulan = $kelurahan->getListMonth();
                $selectTahun = $kecamatan->getTahunIndicator();
                $select=array($tahun, array($bulan,$kelurahan->getNameMonth($bulan)),$dCategory);
                
                $this->render('index', array(
                    'select'=>$select,
                    'selectTahun'=>$selectTahun,
                    'listKecamatan' => $tmpDrill,
                    'series' => json_encode($series),
                    'drilldown'=>  json_encode($drillDown),
                    'dataIndicator' => $dataIndicator,
                    'namaIndicator' => $arrKec,
                    'category_bulan' => $category_bulan,
                    'category'=>$category,
                ));
	}
        
        public function actionPrint()
	{
                $kelurahan = new Kelurahan;
                $kecamatan = new Kecamatan;
                $indicator = new Indicator();
                $dtIndicator = new DtIndicator();
                $category = new Category();
                $listCategory = $category->findAll('ctg_id=ctg_id order by ctg_nama');
                $series = array();
                $drillDown = array();
                
                $tmp = array();
                $dataIndicator = array();
                
                if(isset($_POST['tahun'])&& isset($_POST['bulan'])){
                    $tahun = $_POST['tahun'];
                    $bulan = $_POST['bulan'];
                    $arrKec = $kecamatan->getDataIndicatorJakarta($tahun.$bulan);
                }else{
                    $tahun=date('Y');
                    $bulan=date('m');
                    $arrKec = $kecamatan->getDataIndicatorJakarta(date('Ym'));
                }
                
                if(isset($_GET['thn']) && isset($_GET['bln'])){
                    $tahun=$_GET['thn'];
                    $bulan=$_GET['bln'];
                }
                
                foreach($arrKec as $arrs){
                    array_push($tmp, array(
                        'name'=>$arrs['idc_nama'],
                        'y'=>(int)$arrs['dt_value'],
                        'drilldown'=>$arrs['idc_nama']));
                    //push data drill down
                    $tmpDrill =$kecamatan->getIndicatorPerKecamatan($arrs['idc_id'], $tahun.$bulan);
                    
                    array_push($dataIndicator, $tmpDrill);
                    $tmpDtKec = array();
                    foreach($tmpDrill as $tmpDrills){
                        
                        array_push($tmpDtKec, array($tmpDrills['kec_nama'], (int)$tmpDrills['dt_value']));
                    }
                    array_push($drillDown, array(
                        'id'=>$arrs['idc_nama'],
                        'name'=>$arrs['idc_nama'], 
                        'tooltip'=>array('valueSuffix'=>' '.$arrs['idc_satuan'], 'animation'=>true),
                        'data'=>$tmpDtKec));
                    
                }    
                array_push($series, array('name'=>'Jakarta Utara','colorByPoint'=>true,  'data'=>$tmp));
                $category_bulan = $kelurahan->getListMonth();
                $select=array($tahun, array($bulan,$kelurahan->getNameMonth($bulan)));
                $getNamaBulan=$kelurahan->getNameMonth($bulan);
                
                $this->renderPartial('print', array(
                    'select'=>$select,
                    'listKecamatan' => $tmpDrill,
                    'series' => json_encode($series),
                    'drilldown'=>  json_encode($drillDown),
                    'dataIndicator' => $dataIndicator,
                    'namaIndicator' => $arrKec,
                    'category_bulan' => $category_bulan,
                    'namaBulan'=>$getNamaBulan,
                    'listCategory'=> $listCategory,
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