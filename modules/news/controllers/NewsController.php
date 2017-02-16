<?php

namespace app\modules\news\controllers;

use app\models\Etags;
use app\models\Tags;
use Yii;
use app\models\Ecategory;
use app\models\News;
use app\models\Search\NewsSearch;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Point;
use Imagine\Image\Box;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    private function clearImages( $path )
    {
        BaseFileHelper::removeDirectory( $path );
    }

    private function resizeImages($data, $prefix = '', $new_height)
    {
        $new_name = $data['path'] .DIRECTORY_SEPARATOR. $prefix .$data['name'];
        $image = $data['path']. DIRECTORY_SEPARATOR. $data['name'];

        $size = getimagesize( $image );
        $width = $size[0];
        $height = $size[1];

        Image::frame($image, 0, '666', 0)
            ->crop(new Point(0, 0), new Box($width, $height))
            ->resize(new Box( round($new_height/$height*$width, 0) , $new_height))
            ->save($new_name, ['quality' => 100]);
        return true;
    }

    private function saveImages( $model , $type=0 )
    {
        $id = $model->id;
        $path = 'upload'. DIRECTORY_SEPARATOR. $id;

        if ( UploadedFile::getInstance($model, 'photo') )
        {
            if ($type){
                $this->clearImages($path);
            }
            BaseFileHelper::createDirectory($path);
            $file = UploadedFile::getInstance($model, 'photo');

            $name = $file->name;

            $file->saveAs( $path . DIRECTORY_SEPARATOR . $name );

            $model->photo = $name;
            $model->save();

            $dataImages = ['id' => $id, 'path' => $path, 'name' => $name];
            $this->resizeImages($dataImages, 'small_', 80);
            $this->resizeImages($dataImages, 'normal_', 200);

            return $dataImages;
        } else {
            return ['id' => $id];
        }
    }

    private function clearTags( $data )
    {
        Tags::deleteAll('idnews = :idnews', ['idnews' => $data['id']]);
        return true;
    }

    private function saveTags( $data )
    {
        $tags = Yii::$app->request->post('tags');
        if ($tags) {
            foreach ($tags as $tag){

                $zn = Etags::find()->where(['id' => $tag])->one();
                if ( count($zn) ){
                    $idTag = $zn['id'];
                } else {
                    $modelTags = new Etags();
                    $modelTags->name = $tag;
                    $modelTags->save();

                    $idTag = $modelTags->id;
                }

                $modelTagsNews = new Tags();
                $modelTagsNews->idnews = $data['id'];
                $modelTagsNews->idtag = $idTag;
                $modelTagsNews->save();
            }
        }
        return true;
    }
  
    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $dataImages = $this->saveImages($model);
//            $this->resizeImages($dataImages, 'small_', 80);
//            $this->resizeImages($dataImages, 'normal', 200);
            $this->saveTags($dataImages);
            return $this->redirect(['index']);

        } else {

            $queryCategory = Ecategory::find();
            $categories = $queryCategory->select(['name', 'id'])->orderBy('name')->asArray()->all();

            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $dataImages = $this->saveImages($model, 1);

            $this->clearTags($dataImages);
            $this->saveTags($dataImages);

            return $this->redirect(['index']);
        } else {
            $queryCategory = Ecategory::find();
            $categories = $queryCategory->select(['name', 'id'])->orderBy('name')->asArray()->all();

            $tags = Tags::find()->select(['idtag'])->where(['idnews' => $id])->asArray()->all();
            $arr_tag = [];
            foreach ($tags as $tag){
                $arr_tag[] = $tag['idtag'];
            }

            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'tags' => $arr_tag,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
