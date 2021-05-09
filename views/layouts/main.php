<?php

/* @var $this View */

/* @var $content string */

use app\assets\AppAsset;
use app\models\User;
use app\widgets\Alert;
use app\widgets\NavBar;
use mdm\admin\components\MenuHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\Json;
use yii\web\View;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <script>
        window.Permission = <?= Json::encode(User::getRole(Yii::$app->user->id)) ?>;
    </script>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php NavBar::begin([
        'brandLabel' => 'Lord Of Heroes'/*Yii::$app->name*/,
        'brandUrl' => 'https://xn--80apneeq.xn--p1ai/',
        //'brandImage' => '/img/light-logo.svg',
        'options' => ['class' => 'bg-dark navbar navbar-dark navbar-expand-lg']
    ]);
    echo Nav::widget([
        'items' => [
            ['label' => 'Герои', 'url' => ['/characters']],
            ['label' => 'Классы', 'url' => ['/classes']],
            ['label' => 'Расы', 'url' => ['/races']],
            ['label' => 'Стихии', 'url' => ['/elements']]
        ],
        //'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id),
        'options' => ['class' => 'ml-auto navbar-nav']
    ]);
    echo Nav::widget([
        'items' => Yii::$app->user->isGuest ? [
            ['label' => 'Регистрация', 'url' => ['/site/registration']],
            ['label' => 'Вход', 'url' => ['/site/login']]
        ] : [
            '<li>'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn nav-link']
            )
            . Html::endForm()
            . '</li>'

        ],
        'options' => ['class' => 'navbar-nav']
    ]);
    NavBar::end(); ?>

    <div id="wrap">
        <div class="container">
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-center">neondoll</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
