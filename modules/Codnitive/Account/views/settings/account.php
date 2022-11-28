<?php

//use dektrium\user\widgets\Connect;
//use dektrium\user\models\LoginForm;
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */
//  use app\modules\Codnitive\Core\helpers\Tools;

$this->title = __('account', 'Profile');
/*$this->params['breadcrumbs'][0] = [
    'label' => 'Accoadfunt',
    'url' => [Tools::getUrl('accasdfount', [], false)],
];*/
$this->params['breadcrumbs'][10] = __('account', 'Information');
?>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


<div class="card-body-account">
    <h4><?= __('account', 'Profile') ?></h4>
    <div class="right-content">
        <div class="text-center mt-4">
            <div class="d-flex flex-row">
                <?= $this->render('account/general_info.phtml', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>
