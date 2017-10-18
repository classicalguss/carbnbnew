<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Car;
use frontend\models\CarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\sphinx\Query;
use yii\helpers\ArrayHelper;

/**
 * SearchController implements the CRUD actions for Car model.
 */
class SearchController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new CarSearch();
    	$searchModel->load(Yii::$app->request->queryParams);
    	if ($searchModel->book_instantly == null)
    	{
    		$searchModel->book_instantly = 1;
    	}
    	if ($searchModel->delivery == null)
    	{
    		$searchModel->delivery = 0;
    	}
    	$dataProvider = $searchModel->search();

    	$stats = CarSearch::find()->select(['min(price) as min_price,max(price) as max_price,min(milage_limitation) as min_milage_limitation, max(milage_limitation) max_milage_limitation'])->asArray()->one();
		
    	$stats['min_price'] = floor($stats['min_price']/ 100) * 100;
    	$stats['max_price'] = ceil($stats['max_price']/ 100) * 100;
    	$stats['min_milage_limitation'] = floor($stats['min_milage_limitation']/ 100) * 100;
    	$stats['max_milage_limitation'] = ceil($stats['max_milage_limitation']/ 100) * 100;
    	
    	foreach (['min_price','max_price','min_milage_limitation','max_milage_limitation'] as $default)
    	{
    		if ($searchModel->$default == null)
    			$searchModel->$default = $stats[$default];
    	}
    	
    	$allMakes= ArrayHelper::map(
    			Car::find()->select(['make_id','carmake.value'])->joinWith('make')->distinct(['make_id,value'])->asArray()->all(),
    			'make_id',
    			'value'
    	);
    	
        return $this->render('index', [
        	'allMakes'=>$allMakes,
        	'stats'=>$stats,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Car model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Car();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
