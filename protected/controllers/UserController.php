<?php

class UserController extends Controller
{
	public function actionIndex()
	{
            $kelurahan = new Kelurahan();
            $listKelurahan = $kelurahan->findAll('kel_id=kel_id order by kel_nama'); 
            $kecamatan = new Kecamatan();
            $listKecamatan = $kecamatan->findAll('kec_id=kec_id order by kec_nama');
            if(Yii::app()->user->level=='admin'){
                $model = User::model()->findAll();
            }else{
                $model = User::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->user_id));
            }
            $this->render('index', array(
                'model' => $model,
                'listKelurahan'=>$listKelurahan,
                'listKecamatan'=>$listKecamatan));
        
        }         
        
        public function actionLogin(){
              
            $model = new User;
            
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
            if(isset($_POST['User'])){
                $model->attributes=$_POST['User'];
                $username = $model->username;
                $password = $model->password;
                $rm = $model->rememberMe;
                $identity = new UserIdentity($username, $password);
                if ($identity->authenticate()) {
                    if (isset($_POST['rm']) and $_POST['rm'] == "on") {
                        Yii::app()->user->login($identity, 3600 * 24 * 7);
                    } else {
                        Yii::app()->user->login($identity,0);
                    }
                    Yii::app()->request->redirect("index.php?r=statistik/");
                } else {
                    $this->render("login", array( 
                        'model'=>$model, 'error' => 'Username dan Password salah',
                        ));
                }
            } else {
                Yii::app()->user->logout();
                Yii::app()->user->clearStates();
                $this->render('login',array('model'=>$model));
            } 
        }
        
        public function actionAdd(){
            $model = new User;
            $uuid = Kecamatan::model()->getUUID()['uuid()'];
            if(isset($_POST['AddUser'])){
                $user = $_POST['AddUser'];
                $model->attributes=$user;
                $model->user_id=$uuid;
                $model->username=$user['username'];
                $model->password=  md5($user['password']);
                $model->email= $user['email'];
                $model->no_hp= '+62'.$user['no_hp'];
                $model->level=$user['level'];
                $model->last_update= new CDbExpression('NOW()');
                if($user['level']=='kelurahan'){
                    $model->privilege=$user['privilege-kelurahan'];
                }else if($user['level']=='kecamatan'){
                    $model->privilege=$user['privilege-kecamatan'];
                }else {
                    $model->privilege="all";
                }
                if($model->save()){
                    Yii::app()->request->redirect("index.php?r=user&rc=00");
                }else{
                    Yii::app()->request->redirect("index.php?r=user&rc=63");
                }
                
                
            }
            
        }
        
        public function actionUpdate(){
            //get data for modal update
            if (isset($_POST['id'])){
                $model = User::model()->findByPk($_POST['id']);
                $data = array();
                array_push($data, $model->user_id);
                array_push($data, $model->username);
                array_push($data, $model->password);
                array_push($data, $model->email);
                array_push($data, $model->no_hp);
                array_push($data, $model->level);
                array_push($data, $model->last_update);
                echo json_encode($data);
            }else if(isset($_POST['User'])){
                $user=$_POST['User'];
                if($user['password']!=$user['password2']){
                    Yii::app()->request->redirect("index.php?r=user&rc=01");
                }
                $model = new User;
                $model->user_id=$user['user_id'];
                $model->username=$user['username'];
                $model->email=$user['email'];
                $model->no_hp=$user['no_hp'];
                $model->password=  md5($user['password']);
                $model->last_update= new CDbExpression('NOW()');
                if(Yii::app()->user->level=='admin'){
                    if($user['level']=='kelurahan'){
                        $model->privilege=$user['privilege-kelurahan'];
                    }else if($user['level']=='kecamatan'){
                        $model->privilege=$user['privilege-kecamatan'];
                    }else {
                        $model->privilege="all";
                    }
                    $model->level=$user['level'];
                    if($model->updateByPk($user['user_id'], $model )){
                        Yii::app()->request->redirect("index.php?r=user&rc=00");
                    }else{
                        Yii::app()->request->redirect("index.php?r=user&rc=63");
                    }
                }else{
                    if($model->updateByPk($user['user_id'], array(
                        'username'=>$model->username,
                        'password'=>$model->password,
                        'email'=>$model->email,
                        'no_hp'=>$model->no_hp,
                        'last_update'=>$model->last_update))){
                        Yii::app()->request->redirect("index.php?r=user&rc=00");
                    }else{
                        Yii::app()->request->redirect("index.php?r=user&rc=00");
                    }
                }
                 
            }
        
        }

        public function actionLogout()
	{
		Yii::app()->user->logout();
                Yii::app()->user->clearStates();    
		$this->redirect(Yii::app()->homeUrl);
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
        
        public function accessRules() 
        {
            return array(
                array('allow', 
                    'actions' => array('index'),
                    'expression' => 'Yii::app()->user->username != " "'
                ),
                array('deny', // deny all users
                    'actions' => array('update','add'),
                    'deniedCallback' => function() {
                        Yii::app()->controller->redirect(array('login'));
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