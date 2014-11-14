<?php /* @var $this Controller */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.dataTables.css"/>
        <script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js' type='text/javascript'></script>
        <script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js' type='text/javascript'></script>
	<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js' type='text/javascript'></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=geometry,places&sensor=false"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/highcharts-3d.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <script src="http://code.highcharts.com/modules/drilldown.js"></script>


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

    <body>
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#">WEB GIS</a>
                    <?php 
                        
                        $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                    array('label'=>'Home', 'url'=>array('/home')),
                                    array('label'=>'Kecamatan', 'url'=>array('/kecamatan'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Kelurahan', 'url'=>array('/kelurahan'), 'visible'=>!Yii::app()->user->isGuest),
//                                    array('label'=>'Puskesmas', 'url'=>array('/puskesmas'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Jakarta Utara', 'url'=>array('/jakut'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Statistik', 'url'=>array('/statistik'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'User', 'url'=>array('/user'), 'visible'=>!Yii::app()->user->isGuest),
//                                    array('label'=>'Login', 'url'=>array('/user'),'visible'=>Yii::app()->user->isGuest),
                                    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest )

                            ),
                            'htmlOptions' =>  array( 'class' => 'nav' ),

                        ));
                        if (Yii::app()->user->isGuest) {?>
                        <a class="login" href="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=user/login">Login</a>
                        <?php } ?>
                
            </div>
        </div><!-- mainmenu -->
    </div>
    <div class="container">
        <?php echo $content; ?>
    </div> 
    <hr/>

    <footer>
        <p>Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </p>

    </footer><!-- footer -->

</body>
</html>
