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

define( 'DS', DIRECTORY_SEPARATOR);
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

    <?php
        $image_view = 'http:'. DS. DS. $_SERVER['HTTP_HOST']. DS. 'upload'. DS. $model->id. DS. $model->photo;
        $image_size = 'upload'. DS. $model->id. DS. $model->photo;
    ?>

    <?= $form->field($model, 'photo')->widget(FileInput::className(),[
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => [
                file_exists($image_size) ? $image_view : 0
            ],
            'initialPreviewAsData'=>true,
            'initialPreviewConfig' => [
                [
                    'caption' => $model->photo,
                    'size' => file_exists($image_size) ? filesize( $image_size ) : 0,
                ]
            ],
            'allowedFileExtensions' =>  ['jpg', 'png','gif'],
            'showUpload' => false,
            'showRemove' => true,
            'dropZoneEnabled' => false
        ]
    ]) ?>
    
    <?php
    echo '<label class="control-label">Tag Content</label>';
    echo Select2::widget([
        'name' => 'tags',
        'value' =>  $tags ,
        'data' => Etags::getListTags(),
        'maintainOrder' => true,
        'options' => [
            'placeholder' => 'Choose tags...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
        ],
    ]);
    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
