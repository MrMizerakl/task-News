<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

NavBar::begin([
    'brandLabel' => 'World news',
    'brandUrl' => Yii::$app->homeUrl,
    'id' => 'main-menu',
    'options' => [
        'class' => 'navbar navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'News', 'url' => Url::to(['/news'])],  
        ['label' => 'Edit news', 'url' => Url::to(['/news/news/index'])],
        ['label' => 'Edit category', 'url' => Url::to(['/ecategory/ecategory/index'])],

//            Yii::$app->user->isGuest ? (
//                ['label' => 'Login', 'url' => ['/site/login']]
//            ) : (
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
//            )
    ],
]);

NavBar::end();