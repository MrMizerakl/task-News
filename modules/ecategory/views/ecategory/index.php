<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search\EcategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Add category...';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecategory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;{delete}',
                'buttons' => [
                    'delete' => function( $url, $model ){
                        if($model->news){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'onclick' => 'alert("Category is use, delete impossible!"); return false;'
                                ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'aria-label' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this category?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]
                            );
                        }
                    }
                ]
            ],
        ],
        'pager' => [
            'firstPageLabel'=>'<<',
            'prevPageLabel'=>'<',
            'nextPageLabel'=>'>',
            'lastPageLabel'=>'>>',
            'maxButtonCount'=>'9',
        ],
    ]); ?>
</div>
