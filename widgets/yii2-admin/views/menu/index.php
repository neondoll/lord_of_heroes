<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
            ['class' => 'yii\grid\ActionColumn',

                'buttons' => [
                    'view' => function ($url) {
                        return "<a href='{$url}'><i class='fa fa-eye'></i></a>";
                    },
                    'update' => function ($url) {
                        return "<a href='{$url}'><i class='fa fa-pen'></i></a>";
                    },
                    'delete' => function ($url) {
                        return "<form method='post' action='$url'>
<input type='hidden' name='".Yii::$app->request->csrfParam."' value='".Yii::$app->request->getCsrfToken()."'>
<button class='btn btn-link' type='submit'><i class='fa fa-trash'></i></button></form>";
                    }
                ]
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
