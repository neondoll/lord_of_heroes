<?php

use mdm\admin\components\Configs;
use mdm\admin\components\RouteRule;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>
<div class="role-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('rbac-admin', 'Rule Name'),
                'filter' => $rules
            ],
            [
                'attribute' => 'description',
                'label' => Yii::t('rbac-admin', 'Description'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
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
    ])
    ?>

</div>
