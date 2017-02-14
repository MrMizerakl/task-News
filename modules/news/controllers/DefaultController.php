<?php

namespace app\modules\news\controllers;

use app\models\Ecategory;
use app\models\Tags;
use Yii;
use app\models\News;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Default controller for the `News` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex( $idcategory=-1, $idtag=-1 )
    {
        $queryCategory = Ecategory::find();
        $categories = $queryCategory->all();

        $query = News::find();
        $query->where('1=1');
        if($idcategory > 0) {
            $query->andFilterWhere(['=', 'category' , $idcategory]);
        }
        if($idtag >0 ){
            $arrTags = Tags::find()->select('idnews')->where(['=', 'idtag', $idtag])->asArray()->all();
            $arr = [];
            foreach ($arrTags as $value){
                $arr[] = $value['idnews'];
            }
            $query->andFilterWhere(['in', 'id', $arr]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);

        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        $request = Yii::$app->request;

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages,
            'categories' => $categories,
        ]);
    }

    public function actionView ( $id ){
        $model = News::findOne($id);
        return $this->render('view', [
            'model' => $model,
            'ecategory' => $model->category0,
            'tags' => $model->tags
        ]);
    }
}
