<?php

use app\models\Etags;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'data')->widget(DatePicker::className(), [
        'value' => date('d-M-Y', strtotime('+2 days')),
        'options' => [
            'placeholder' => 'Enter date'
        ],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'en',
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'autoclose'=>true,
        ]
    ]) ?>

    <?php
        $arr = [];
        foreach ($categories as $category) {
            $arr[$category['id']] =  $category['name'];
        };
        echo $form->field($model, 'category')->dropDownList(  $arr , [ 'prompt' => 'Select category...' ] )
    ?>

    <?= $form->field($model, 'photo')->widget(FileInput::className(),[
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'allowedFileExtensions' =>  ['jpg', 'png','gif'],
            'showUpload' => false,
            'showRemove' => true,
            'dropZoneEnabled' => false
        ]
    ]) ?>
    
    <?php
    echo '<label class="control-label">Tag Content</label>';
    echo Select2::widget([
//        'model' => $model,
//        'attribute' => 'tags',
        'name' => 'tags',
        'value' => '' ,
        'data' => Etags::getListTags(),
        'maintainOrder' => true,
        'options' => [
            'placeholder' => 'Choose tags...',
//            'class' => 'form-control',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
//            'maximumInputLength' => 10
        ],
    ]);
    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
