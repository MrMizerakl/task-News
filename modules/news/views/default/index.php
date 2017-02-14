<?php
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="News-default-index">

    <div class="col-md-2">
            <?php
            $arr = [];
            foreach( $categories as $category ){
                $arr[] = [
                    'label' => $category['name'],
                    'url' => Url::to(['/news', 'idcategory' => $category['id']]),
                ];
            }

            echo Nav::widget([
                'activateItems' => false,
                'items' => $arr,
            ]);
            ?>
    </div>

    <div class="col-md-10">
        
        <?php foreach ($model as $row): ?>

            <div>
                <h2><a href="<?= Url::to(['default/view','id' => $row->id])?>"><?= $row->title?></a></h2>
                <img src="/upload/<?= $row->id. '/small_'. $row->photo ?>" style="float: left; margin-top: 5px; padding-right: 15px">
                <p style="overflow: hidden; max-height: 90px; ">
                    <?= $row->text ?>
                </p>
            </div>

        <?php endforeach; ?>

        <div class="clearfix"></div>
        <div>
            <?=
            LinkPager::widget([
                'pagination' => $pages,
                'firstPageLabel'=>'<<',
                'prevPageLabel'=>'<',
                'nextPageLabel'=>'>',
                'lastPageLabel'=>'>>',
                'maxButtonCount'=>'9',
            ])
            ?>
        </div>

    </div>

</div>
