<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ecategory */

$this->title = 'Create Ecategory';
$this->params['breadcrumbs'][] = ['label' => 'Ecategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecategory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
