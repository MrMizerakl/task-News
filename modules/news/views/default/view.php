<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>
<div id="default-view">
    <div class="text-center">
        <h1><?= $model->title ?></h1>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-1">
            <h6 class="text-left"><a href="<?= Url::to(['/news', 'idcategory' => $model->category])?>"> <?= $ecategory['name'] ?></a></h6>
        </div>

        <div class="text-right col-md-6">
            <h6>
                <?php foreach ($tags as $tag): ?>
                    <a href="<?= Url::to(['/news', 'idtag' => $tag->idtag0['id']])?>"><?= $tag->idtag0['name']?></a>&nbsp;
                <?php endforeach; ?>
                 </h6>
        </div>
    </div>

    <div class="row">
        <p>
            <?php
            $image = 'upload/'. $model->id. '/normal_'. $model->photo;
            if(file_exists($image)):
                ?>
                <img src="/<?= $image ?>" style="float: left; padding: 10px">
            <?php endif; ?>
            <?= $model->text ?>
        </p>
    </div>
</div>

<div id="default-comments">
<h3>Comments</h3>
    <hr>
    <div id="comments-form" class="row">

        <div class="col-md-8">
            <h4>Add comment</h4>

            <?php Pjax::begin(['id'=>'new_comment']);?>
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($comment, 'user')->textInput() ?>
                </div>
            </div>

            <?= $form->field($comment, 'date')->hiddenInput(['value' => date("Ymd")])->label(false) ?>
            <?= $form->field($comment, 'idnews')->hiddenInput(['value' => $model->id])->label(false) ?>

            <?= $form->field($comment, 'text')->textarea() ?>

            <div class="form-group">
                <?= Html::submitButton('Post', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php $form = ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>

    </div>
    <hr>
    <div id="comments-view">

        <div class="col-md-10">

            <?php Pjax::begin(['id'=>'comments']);?>
            <?php foreach ($listcomments as $value) :?>

                <blockquote>
                    <h6><?= $value['user']?>&nbsp;&nbsp;<?= $value['date']?></h6>
                    <p><em><?= $value['text'] ?></em></p>
                </blockquote>

            <?php endforeach; ?>
            <?php Pjax::end();?>

        </div>

    </div>

</div>
<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#new_comment").on("pjax:end", function() {
            $.pjax.reload({container:"#comments"});  
        });
    });'
);
?>
