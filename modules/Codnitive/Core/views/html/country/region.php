<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\Codnitive\Setup\models\Database */

// use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;

use app\modules\Codnitive\Core\helpers\Country;
use app\modules\Codnitive\Core\helpers\Html;
// use yii\widgets\ActiveForm;
use app\modules\Codnitive\Core\widgets\ActiveForm;
// use app\modules\Codnitive\Account\models\SettingsForm;

$countries = new Country;
if (!empty($countryCode)) {
    $regions = $countries->getRegionsList($countryCode);
}
// if (isset($options)) {
    $options['class'] = isset($options['class']) ? $options['class'] . ' region-list' : ' region-list';
// }
// if (!isset($form)) {
//     $model = new SettingsForm;
//     // $model->region = '';
//     $form  = ActiveForm::begin();
//     $field = 'division';
// }
?>

<?php if (empty($countryCode) || empty($regions)): ?>
    <?= html::getField($form, $model, $field, $options['class']) ?>
<?php else: ?>
    <?php if (!isset($form)): ?>
    <?php $form  = ActiveForm::begin(); ?>
    <?= $countries->getRegionsDropdown($countryCode, $formName) ?>
    <?php ActiveForm::end(); ?>
    <?php else: ?>
    <?= Html::getDropdownList($form, $model, $field, $regions, $options) ?>
    <?php endif; ?>
<?php endif; ?>
