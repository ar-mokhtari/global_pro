<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\Codnitive\Setup\models\Database */

// use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;

// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\helpers\Country;
use app\modules\Codnitive\Core\helpers\Html;
/*use app\modules\Codnitive\Template\assets\Html\Country as CountryAssets;
CountryAssets::register($this);*/

$countries = new Country;
$options['class'] = isset($options['class']) ? $options['class'] . ' country-list' : ' country-list';
?>

<?= Html::getDropdownList($form, $model, $field, $countries->getCountriesList(), $options) ?>

<script>
jQuery(document).ready(function($) {
	/*$('.country-list').selectstyle({
		// width  : 800,
		// height : 300,
		// theme  : 'light',
		onchange : function(val){
            alert(val);
        }
	});*/
    $('.country-list').on('change', function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.post('<?= tools()->getUrl('core/ajax/getregions') ?>', {country_code: this.value, form_name: this.id, _csrf : csrfToken})
        .done(function(options) {
            $('.region-wrapper').html(options);
        })
        .fail(function(e) {
            console.log(e.responseText);
        });
    });
});
</script>


<?php /*
<select class="country-list" name="country_code" theme="google" placeholder="Select Country" data-search="true">
<select class="country-list" name="country_code" >
<option value="">Please Select Country</option>
<?php foreach ($countries->getCountriesList() as $code => $name): ?>
    <option value="<?= $code ?>"><?= $name ?></option>
<?php endforeach; ?>
</select>
*/ ?>
