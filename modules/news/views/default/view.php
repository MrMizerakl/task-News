<?php
//use app\models\Ecategory;
use yii\helpers\Url;
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
