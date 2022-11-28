<?php

namespace app\modules\Codnitive\Core\helpers;

// use Yii;
use yii\helpers\Html as BaseHtml;
use yii\helpers\Json;
// use yii\helpers\Url;
// use yii\helpers\VarDumper;
// use yii\web\ServerErrorHttpException;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
// use app\modules\Codnitive\Core\helpers\Tools;
//
class Html extends BaseHtml
{
    public static $nameSpace;
    public static $index;
    // public static $arrayForm = false;
    
    /**
     * {
     *    show_icon: false,
     *    direction: false,
     *    first_day_of_week: 6,
     *    weekend_days: [4,5],
     *    // rtl: true,
     *    view: 'years',
     *    offset: [-255, 285]
     * }
     */
    protected static $_datapickerConfig = [
        'show_icon' => false,
        'direction' => false,
        'offset' => [-255, 285]
    ];

    protected static $_datapickerConfigFa = [
        'first_day_of_week' => 6,
        'weekend_days' => [4,5],
    ];

    public static function setIndex(int $index) 
    {
        self::$index = $index;
    }

    public static function getIndex(): int
    {
        return self::$index;
    }

    public static function setNameSpace (string $nameSpace)
    {
        self::$nameSpace = $nameSpace;
        // return self;
    }

    public static function generateField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        // $field   = preg_replace('/\[\d*?\]/', '', $field);
        $formatFieldCondition = !isset($data['format_field'])
            || (isset($data['format_field']) && $data['format_field']);
        if ($formatFieldCondition) {
            $field   = self::_formatField($field);
        }
        if (empty($template)) {
            $colSize = isset($data['col_size']) ? 'form-group ' . trim($data['col_size']) : 'form-group';
            if (!empty($icon)) {
                $colSize .= ' icon_addon';
            }
            $template = '<div class="'.$colSize.'">';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $template .= '{label}';
            }
            if (!empty($icon)) {
                $template .= '<span class="mdi-set mdi-24px '.$icon.' color"></span>';
            }
            
            $template .= '{input}';
            if (!isset($data['remove_hint']) || !$data['remove_hint']) {
                $template .= '<div class="field-hint">{hint}</div>';
            }
            if (!isset($data['remove_error']) || !$data['remove_error']) {
                $template .= '<div class="field-error red-text">{error}</div>';
            }
            $template .= '</div>';
        }
        if (isset($data['fastselect'])) {
            $tagId       = self::_formatTagId($field);
            $idSelector = '#'.$tagId;
            $fieldVar = str_replace('-', '_', $tagId);
            $options = Json::encode($data['fastselect']);
            $template .= <<<JS
                <div id="{$tagId}_fastselect" class="fastselect-js-wrapper">
                <script type="text/javascript">
                $(document).ready(function () {
                    if ($('$idSelector').attr('data-index') != '99999-99999'.replace('-', '')) {
                        $fieldVar = $('$idSelector').fastselect($options).data('fastselect');
                    }
                });
                </script>
                </div>
JS;
        }
        $formGroupclass = isset($data['form_group_class']) 
            ? trim($data['form_group_class']) 
            : '';
        unset($data['form_group_class']);
        if (isset($data['force_form_group_class']) && isset($data['force_form_group_class'])) {
            $formGroupclass = isset($data['form_group_class']) 
                ? trim($data['form_group_class']) 
                : '';
                unset($data['force_form_group_class']);
        }
        $labelOptions = isset($data['labelOptions']) ? $data['labelOptions'] : ['class' => 'control-label'];
        $options = ArrayHelper::merge(['class' => $formGroupclass], $data['options'] ?? []);
        return $form->field($model, $field, [
                'options' => $options,
                'template' => $template,
                'labelOptions' => $labelOptions
            ])/*->textInput(['class' => $class, 'placeHolder' => $placeHolder])*/;
    }

    public static function getField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        $tagId       = self::_formatTagId($field);
        $tagName     = self::_formatTagName($field);
        $field       = self::_formatField($field);
        $placeHolder = isset($data['placeholder'])      ? $data['placeholder'] : $model->getAttributeLabel($field);
        $class       = isset($data['class'])            ? 'form-control '.trim($data['class']) : 'form-control';
        // $value = $data['value'] ?? '';
        unset(
            $data['placeholder'],
            $data['class']//,
            // $data['value']
        );
        if (isset($data['value'])) {
            $data['options']['value'] = $data['value'];
        }
        $options = ArrayHelper::merge(
            ['class' => $class, 'placeHolder' => $placeHolder, 'id' => $tagId, 'name' => $tagName/*, 'value' => $value*/],
            $data['options'] ?? []
        );
        return self::generateField($form, $model, $field, $icon, $template, $data)
            ->textInput($options);
    }

    public static function getHiddenField($form, $model, $field, $data = [])
    {
        $tagId       = self::_formatTagId($field);
        $tagName     = self::_formatTagName($field);
        $class       = 'form-control ';
        if (isset($data['class'])) {
            $class   .= $data['class'];
        }
        $hiddenInputOptions = ['id' => $tagId, 'name'=> $tagName, 'class' => $class];
        if (isset($data['hidden_input_options'])) {
            $hiddenInputOptions = ArrayHelper::merge($hiddenInputOptions, $data['hidden_input_options']);
        }
        // return $form->field($model, $field)->hiddenInput(['id' => $tagId, 'name'=> $tagName])->label(false);
        $data = ArrayHelper::merge([
            'remove_error' => true,
            'remove_hint' => true,
            'col_size' => 'm-0 p-0'
        ], $data);
        return self::generateField($form, $model, $field, '', '', $data)
            ->hiddenInput($hiddenInputOptions)
            ->label(false);
    }

    public static function getNumberField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        $tagId = self::_formatTagId($field);
        $value = $data['number'] ?? tools()->formatNumber($model->$field, 2, '.', '');
        // if (floatval($value)) {
            $model->$field = floatval($value);
        // }

        if (!isset($data['formatted_number'])) {
            $number = floatval($model->$field);
            $formattedNumber = tools()->formatNumber($number, 2, '.', '');
        }
        else {
            $formattedNumber = $data['formatted_number'];
        }

        $colSize = isset($data['col_size']) ? 'form-group ' . trim($data['col_size']) : 'form-group';

        $numberType = $data['number_type'] ?? 'number';
        $template = '<div id="'.$tagId.'_'.$numberType.'_field" class="'.$colSize.'">
            <div class="input">';
        if (!isset($data['remove_label']) || !$data['remove_label']) {
            $template .= '{label}';
        }
        if (!empty($icon)) {
            $template .= '<span class="mdi-set mdi-24px '.$icon.' color"></span>';
        }

        $jsCalcVal = $data['js_calc_val'] ?? 'parseFloat(_field.val().toEnglishDigits() || 0).format(2, 3, ",", ".")';
        $js = <<<JS
            <script type="text/javascript">
                $(document).ready(function () {
                    $('body').on('keyup', '#{$tagId}', function () {
                        var _field = $(this);
                        $('#{$tagId}_{$numberType}_field .{$numberType}').html(
                            $jsCalcVal
                        );
                    });
                });
            </script>
JS;
        
        $template .= <<<HTML
                    <div class="d-flex flex-row align-items-center">
                        <div class="col-9 p-0">{input}</div>
                        <div class="{$numberType} p-2">
                            {$formattedNumber}
                        </div>
                    </div>
                    <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                    </div>
                    $js
                </div>
HTML;
        return self::getField($form, $model, $field, $icon, $template, $data);
    }

    public static function getIntField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        $data = ArrayHelper::merge([
            'number' => tools()->formatNumber(floatval($model->$field), 0, '.', ''),
            'formatted_number' => tools()->formatNumber(floatval($model->$field), 0, '.', ''),
            'number_type' => 'int',
            'js_calc_val' => 'parseInt(_field.val().toEnglishDigits() || 0).format(0, 3, ",", ".")',
        ], $data);
        return self::getNumberField($form, $model, $field, $icon, $template, $data);
    }

    public static function getPriceField($form, $model, $field, $icon = '', $template = '', $data = [])
    {
        $data = ArrayHelper::merge([
            'number' => tools()->formatNumber(floatval($model->$field), 0, '.', ''),
            'formatted_number' => tools()->formatRial(floatval($model->$field)),
            'number_type' => 'price',
            'js_calc_val' => 'codnitive.formatRial(parseFloat(_field.val().toEnglishDigits() || 0))',
        ], $data);
        return self::getNumberField($form, $model, $field, $icon, $template, $data);
    }

    public static function getRadioList($form, $model, $field, $list, $data = [])
    {
        if (isset($data['template']) && !empty($data['template'])) {
            $template = $data['template'];
            unset($data['template']);
        }
        else {
            $template = '<div class="radio">';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $template .= '{label}';
            }
            $template .= '<div class="radio radio-primary">
                        <div class="radio-wrapper">
                            {input}
                        </div>
                        <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                    </div>
                </div>';
        }
        // $class = isset($data['class']) ? 'form-control '.trim($data['class']) : 'form-control';
        $fieldName = self::_formatField($field);
        $tagName     = self::_formatTagName($field);
        $data['format_field'] = false;
        $field = self::generateField($form, $model, $field, '', $template, $data);
        return $field->radioList(
                $list,
                ['item' => function($index, $label, $name, $checked, $value) {
                        // $name = self::_formatCheckListName($name, false);
                        $id   = self::_formatCheckListId($name, $index);
                        $checkedItem = $checked ? ' checked="checked"' : '';
                        $radio = '<div class="input-wrapper d-inline-block">
                                    <input type="radio" name="'.$name.'" id="'.$id.'" value="'.$value.'"'.$checkedItem.'>
                                    <label class="radio-inline" for="'.$id.'">'.$label.'</label>
                                  </div>';
                        return $radio;
                    },
                    'value' => $model->$fieldName,
                    /*'class' => $class,*/
                    'name' => $tagName
                ]
            );
    }

    public static function getCheckboxList($form, $model, $field, $list, $data = [])
    {
        if (isset($data['template']) && !empty($data['template'])) {
            $template = $data['template'];
            unset($data['template']);
        }
        else {
            $template = '<div class="checkbox">';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $template .= '{label}';
            }
            $template .= '<div class="checkbox-inputs-list">
                        <div class="checkbox-wrapper">
                            {input}
                        </div>
                        <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                    </div>
                </div>';
        }
        $fieldName = self::_formatField($field);
        $tagName     = self::_formatTagName($field);
        $data['format_field'] = false;
        $field = self::generateField($form, $model, $field, '', $template, $data);
        return $field->checkboxList(
                $list,
                ['item' => function($index, $label, $name, $checked, $value) {
                        $id   = self::_formatCheckListId($name, $index);
                        $checkedItem = $checked ? ' checked="checked"' : '';
                        $checkbox = '<label class="checkbox-inline" for="'.$id.'">
                                        <input type="checkbox" name="'.$name.'" id="'.$id.'" value="'.$value.'"'.$checkedItem.'>
                                      '.$label.'
                                      <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                </label>';
                        return $checkbox;
                    },
                    'value' => $model->$fieldName,
                    /*'class' => $class,*/
                    'name' => $tagName
                ]
            );
    }

    public static function getCheckboxListGroup($form, $model, $field, $list, $data = [])
    {
        $checkbox = self::getCheckboxList($form, $model, $field, $list, $data);
        $html     = '<div class="checkbox-group">'.$checkbox.'</div>';
        return $html;
    }

    public static function getDropdownList($form, $model, $field, $list, $data = [], $view = null)
    {
        $tagId       = self::_formatTagId($field);
        $tagName     = self::_formatTagName($field);
        $field       = self::_formatField($field);
        $icon        = $data['icon'] ?? '';
        if (isset($data['template']) && !empty($data['template'])) {
            $template = $data['template'];
            unset($data['template']);
        }
        else {
            $colSize = isset($data['col_size']) ? 'form-group ' . trim($data['col_size']) : 'form-group';
            if (!empty($icon)) {
                $colSize .= ' icon_addon';
            }
            $template = '<div class="'.$colSize.'">';
            if (!isset($data['remove_label']) || !$data['remove_label']) {
                $template .= '{label}';
            }
            
            $template .= '{input}
                        <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>';
            if (!empty($icon)) {
                $template .= '<span class="mdi-set mdi-24px '.$icon.' color"></span>';
            }
            $template .= '</div>';
        }

        // $extraDataAttributes = ['data-size' => '5'];
        if ($view) {
            // @link http://dbrekalo.github.io/fastselect/#section-Installation
            \app\modules\Codnitive\Template\assets\Fastselect::register($view);
            $data['class'] = isset($data['class']) ? $data['class'] . ' fastselect' : 'fastselect';
            // $extraDataAttributes += ['data-live-search' => $data['live_search'] ?? 'true'];
            $idSelector = '#'.$tagId;
            $fieldVar = str_replace('-', '_', $tagId);

            $fastselect = [
                'placeholder' => __('core', 'Choose option'),
                'searchPlaceholder' => __('core', 'Search options'),
                'noResultsText' => __('core', 'No results'),
            ];
            if (isset($data['fastselect'])) {
                $fastselect = ArrayHelper::merge($fastselect, $data['fastselect']);
            }
            $fastselect = Json::encode($fastselect);
        
            $template .= <<<JS
                <div id="{$tagId}_fastselect_pattern" class="fastselect-js-wrapper">
                <script type="text/javascript">
                $(document).ready(function () {
                    if ($('$idSelector').attr('data-index') != '99999-99999'.replace('-', '')) {
                        $fieldVar = $('$idSelector').fastselect($fastselect).data('fastselect');
                    }
                });
                </script>
                </div>
JS;
        }
        $extraDataAttributes['prompt'] = $data['prompt'] ?? __('core', '-- Select Option --');
        if (isset($data['prompt']) && false === $data['prompt']) {
            unset($extraDataAttributes['prompt'], $data['prompt']);
        }
        if (isset($data['dynamic_data_url'])) {
            $extraDataAttributes['data-url'] = $data['dynamic_data_url'];
            $extraDataAttributes['data-load-once'] = 'true';
        }
        if (isset($data['index'])) {
            $extraDataAttributes['data-index'] = $data['index'];
        }
        if (isset($data['multiple'])) {
            $extraDataAttributes['multiple'] = $data['multiple'];
        }
        $field = self::generateField($form, $model, $field, $icon, $template, $data);
        return $field->dropDownList(
                $list, ArrayHelper::merge([
                    // 'prompt' => isset($data['prompt']) ?  $data['prompt'] : __('core', '-- Select Option --'),
                    'class'  => isset($data['class']) ? 'form-control ' . trim($data['class']) : 'form-control',
                    'id'     => $tagId,
                    'name'   => $tagName,
                ], $extraDataAttributes)
            );
    }

    public static function getFieldFastselect($form, $model, $field, $icon = '', $template = '', $data = [], $view = null)
    {
        $tagId       = self::_formatTagId($field);
        $tagName     = self::_formatTagName($field);
        $field       = self::_formatField($field);
        $placeHolder = isset($data['placeholder'])      ? $data['placeholder'] : $model->getAttributeLabel($field);
        $class       = isset($data['class'])            ? 'form-control '.trim($data['class']) : 'form-control';
        $value = $data['value'] ?? '';
        $fastselect = [
            'placeholder' => __('core', 'Choose option'),
            'searchPlaceholder' => __('core', 'Search options'),
            'noResultsText' => __('core', 'No results'),
            'autoFocus' => true,
            'minQueryLength' => 3,
            'typeTimeout' => 550
        ];
        if (isset($data['fastselect'])) {
            $fastselect = ArrayHelper::merge($fastselect, $data['fastselect']);
        }
        $data['fastselect'] = $fastselect;
        if ($view) {
            // @link http://dbrekalo.github.io/fastselect/#section-Installation
            \app\modules\Codnitive\Template\assets\Fastselect::register($view);
        }
        return self::generateField($form, $model, $field, $icon, $template, $data)
            ->textInput(['class' => $class, 'placeHolder' => $placeHolder, 'id' => $tagId, 'name' => $tagName, 'value' => $value]);
    }

    public static function getDateField($form, $model, $field, $view, $data = [])
    {
        // \app\modules\Codnitive\Template\assets\ZebraDatepicker::register($view);
        \app\modules\Codnitive\Template\assets\MDPersianDatepicker::register($view);
        // $icon = isset($data['icon']) ? $data['icon'] : 'fa fa-calendar';
        $icon = isset($data['icon']) ? $data['icon'] : '';
        unset($data['icon']);
        $data = ArrayHelper::merge([
            'form_group_class'  => 'col-12',
            // 'col_size'          => 'col-12',
            // 'class'             => 'input-md datepicker',
        ], $data);
        $data['class'] .= ' datepicker';
        $template = (isset($data['template'])) ? $data['template'] : '';

        $idSelector = '#'.self::_formatTagId($field);
        $dateOptions = $data['date_options'] ?? [];
        $dateOptions['targetTextSelector'] = $dateOptions['targetTextSelector'] ?? $idSelector;
        $dateOptions = Json::encode($dateOptions);
        // @link datepicker page: https://github.com/Mds92/MD.BootstrapPersianDateTimePicker
        echo <<<JS
            <script type="text/javascript">
            $(document).ready(function () {
                $('$idSelector').MdPersianDateTimePicker($dateOptions);
                $('$idSelector').attr('readonly', 'readonly');
            });
            </script>
JS;
        return self::getField($form, $model, $field, $icon, $template, $data);
    }

    public static function getTimeField($form, $model, $field, $data = [])
    {
        $icon = 'fa-clock-o';
        if (isset($data['icon'])) {
            $icon = $data['icon'];
            unset($data['icon']);
        }
        $data = ArrayHelper::merge([
            // 'form_group_class'  => 'col-6',
            'col_size'          => 'col-12',
            'class'             => 'input-md clockpicker',
        ], $data);
        $template = (isset($data['template'])) ? $data['template'] : '';
        return self::getField($form, $model, $field, $icon, $template, $data);
    }

    public static function getFromToDate($form, $model, $view, $startField = 'start_date', $endField = 'end_date')
    {
        $fromDate = self::getDateField($form, $model, $startField, $view, [
            'class' => 'input-md datepicker from-date',
            'placeholder' => $model->getAttributeLabel($startField),
        ]);
        $toDate   = self::getDateField($form, $model, $endField, $view, [
            'class' => 'input-md datepicker to-date',
            'placeholder' => $model->getAttributeLabel($endField),
            'form_group_class' => 'col-12',
            'col_size' => 'col-11',
            'remove_label' => true
        ]);
        $html     = '<div class="one-row two-in-row row">'.$fromDate.$toDate.'</div>';
        return $html;
    }

    public static function getFromToTime($form, $model, $startField = 'start_time', $endField = 'end_time')
    {
        $fromTime = self::getTimeField($form, $model, $startField, [
            'class' => 'input-md clockpicker from-time',
            'placeholder' => $model->getAttributeLabel($startField),
            'form_group_class' => 'col-12',
            'col_size' => 'col-7',
        ]);
        $toTime   = self::getTimeField($form, $model, $endField, [
            'class' => 'input-md clockpicker to-time',
            'placeholder' => $model->getAttributeLabel($endField),
            'form_group_class' => 'col-12',
            'col_size' => 'col-11',
            'remove_label' => true
        ]);
        $html     = '<div class="one-row two-in-row row">'.$fromTime.$toTime.'</div>';
        return $html;
    }

    public static function datepickerConfig(array $config = []): string
    {
        $config = self::$_datapickerConfig + $config;
        if (tools()->getLanguage() == 'fa-IR') {
            $config = self::$_datapickerConfigFa + $config;
        }
        return json::encode($config);
    }

    public static function getTextarea($form, $model, $field, $data = [])
    {
        $tagId       = self::_formatTagId($field);
        $tagName     = self::_formatTagName($field);
        $field       = self::_formatField($field);
        // $data = ArrayHelper::merge([
        //     'class'             => 'text-editor',
        // ], $data);

        if (isset($data['template']) && !empty($data['template'])) {
            $template = $data['template'];
            unset($data['template']);
        }
        else {
            $colSize = isset($data['col_size']) ? $data['col_size'] : 'col-12 p-0';
            $template = '<div class="form-group">
                    {label}
                    <div class="'.$colSize.'">
                        {input}
                        <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                    </div>
                </div>';
        }
        $field = self::getField($form, $model, $field, '', $template, $data);
        $textEditor = (!isset($data['no_editor']) || !$data['no_editor']) ? ' text-editor ' : ' textarea ';
        $class = isset($data['class']) ? 'form-control '.$textEditor.trim($data['class']) : 'form-control '.$textEditor;
        $textarea = $field->textarea([
            'class' => $class,
            'rows'  => '20',
            'cols'  => '100',
            'id'    => $tagId,
            'name'  => $tagName
        ]);
        return (isset($data['cloneSample']) && $data['cloneSample'])
                    ? str_replace('textarea', 'text-area', $textarea)
                    : $textarea;
    }

    public static function getFileInput($form, $model, $field, $data = [])
    {
        $cloneSample  = false;
        if (isset($data['cloneSample'])) {
            $cloneSample = $data['cloneSample'];
            unset($data['cloneSample']);
        }
        $maxFileCount = (isset($data['options']['multiple']) && $data['options']['multiple']) ? 8 : 1;
        $previews     = [];
        $previewField = self::_formatField($field);
        if (isset($model[$previewField]) && !empty($model[$previewField])) {
            $previewFiles = $model[$previewField];
            // list($previewType)  = explode('/', $data['options']['accept']);
            $fileDirectory = $data['options']['directory'];
            $baseKey  = self::_getFileKey($model, $previewField);
            $previews = self::getFilePreviews($previewFiles, $fileDirectory, $baseKey);
            // $maxFileCount -= count($previews['initialPreview']);
        }
        $data = ArrayHelper::merge([
            'pluginOptions' => ArrayHelper::merge([
                'theme' => 'fa',
                // 'browseOnZoneClick' => true,
                'showUpload' => false,
                // 'showRemove' => false,
                'maxFileCount' => $maxFileCount,
                'validateInitialCount' => true,
                'uploadAsync' => true,
                'previewFileType' => 'any',
                'initialPreviewAsData' => true,
                // 'initialCaption' => "The Moon and the Earth",
                'overwriteInitial' => false,
                // 'showPreview' => false,
            ], $previews)
        ], $data);
        $fileInput = $form->field($model, $field)->widget(FileInput::classname(), $data);
        return !$cloneSample ? $fileInput : str_replace('type="file"', 'type="fi-le"', $fileInput);
        // return $form->field($model, $field)->fileInput($data);
    }/*
*/
    public static function getMediaField($form, $model, $field, $data = [])
    {
        $extensions = explode(',', \app\modules\Codnitive\Core\models\FileManager::VALID_MEDIA_EXSTENSIONS);
        $data = ArrayHelper::merge([
            'options' => [
                /*'accept' => 'image/*',*/
                'multiple' => true,
                'directory' => 'image'
            ],
            'pluginOptions' => [
                // 'maxFileCount' => 8, //minues with count uploaded
                'deleteUrl' => tools()->getUrl('account/file/deleteImage'),
                'allowedFileTypes' => ['image', 'video'],
                'allowedFileExtensions' => $extensions,
            ]
        ], $data);
        // $data = ArrayHelper::merge([
        //     'multiple' => true,
        //     'accept'   => 'image/*'
        // ], $data);
        return self::getFileInput($form, $model, $field, $data);
    }

    public static function getImageField($form, $model, $field, $data = [])
    {
        $extensions = explode(',', \app\modules\Codnitive\Core\models\FileManager::VALID_IMAGE_EXSTENSIONS);
        $data = ArrayHelper::merge([
            'options' => [
                /*'accept' => 'image/*',*/
                'multiple' => true,
                'directory' => 'image'
            ],
            'pluginOptions' => [
                // 'maxFileCount' => 8, //minues with count uploaded
                'deleteUrl' => tools()->getUrl('account/file/deleteImage'),
                'allowedFileTypes' => ['image'],
                'allowedFileExtensions' => $extensions,
                'previewFileType' => 'image'
            ]
        ], $data);
        // return self::getMediaField($form, $model, $field, $data);
        return self::getFileInput($form, $model, $field, $data);
    }

    public static function getFilePreviews($files, $directory, $baseKey)
    {
        //add uploaded files
        // 'initialPreview' => [
        //     "/image/3/bg-1.jpg",
        //     "/image/3/bg-2.jpg",
        // ],
        // 'initialPreviewConfig' => [
        //     ['key' => 'bg-1.jpg', 'caption' => 'Moon.jpg', 'size' => '873727', 'showDrag' => false,/* 'url' => '/file-upload-batch/2'*/],
        //     ['key' => 'bg-2.jpg', 'caption' => 'Earth.jpg', 'size' => '1287883', 'showDrag' => false, /*'url' => '/file-upload-batch/2'*/],
        // ],
        $pluginOptions = [
            //add uploaded files
            'initialPreview' => [],
            'initialPreviewConfig' => []
        ];
        $userId = tools()->getUser()->id;
        foreach ($files as $file) {
            $name = $file['name'];
            if (empty($name)) {
                continue;
            }
            list($type) = explode('/', $file['type']);
            $pluginOptions['initialPreview'][]       = "/$directory/$userId/$name";
            $pluginOptions['initialPreviewConfig'][] = [
                'key'      => $baseKey.'::'.$name,
                'caption'  => $name,
                'size'     => $file['size'],
                'showDrag' => false,
                /*'url' => '/file-upload-batch/2'*/
                'type'     => $type,
                'filetype' => $file['type']
            ];
        }
        return $pluginOptions;
    }

    public static function _getFileKey($model, $field)
    {
        return str_replace('\\', '_',
            str_replace('\models\\', ':',
            str_replace('app\modules\Codnitive\\', '', get_class($model))))
            . '::' . $model->id
            . '::' . $field;
    }

    public static function getLocationField($viewBlock, $form, $model, $field, $icon = '', $template = '', $data = [])
    {
        \app\modules\Codnitive\Template\assets\Location::register($viewBlock);
        $id    = static::getInputId($model, $field);
        $fieldHtml = static::getField($form, $model, $field, $icon, $template, $data);
        $fieldHtml .= '
        <script type="text/javascript">
            $(document).ready(function() {';
        if (isset($data['geolocate']) && $data['geolocate']) {
            $fieldHtml .= 'codnitive.location.geolocate();';
        }
        $fieldHtml .= 'codnitive.location.initAutocomplete("'.$id.'");
            });
        </script>';
        if (isset($data['location_hidden']) && $data['location_hidden']) {
            $hiddenFieldName = str_replace('_hidden', '', $field);
            $fieldHtml .= static::activeHiddenInput(
                $model,
                $hiddenFieldName,
                ['value'=> $model->$hiddenFieldName]
            );
        }
        return $fieldHtml;
    }

    public static function getCountryOptionsBlock($block, $model, $form)
    {
        return $block->render(
            '@app/modules/Codnitive/Core/views/html/country/country.php',
            ['form' => $form, 'model' => $model, 'field' => 'country', 'options' => ['prompt' => '--Please Select Country--']]
        );
    }

    public static function getRegionOptionsBlock($block, $model, $form)
    {
        return $block->render(
            '@app/modules/Codnitive/Core/views/html/country/region.php',
            ['form' => $form, 'model' => $model, 'countryCode' => $model->country, 'field' => 'division', 'options' => ['prompt' => '--Please Select State/Region--', 'class' => 'fa-flag']]
        );
    }

//     public static function getGridPerPage(
//         $showResetFilterButton,
//         $select   = 10,
//         $class    = 'per-page float-right text-right col-sm-12 col-md-6',
//         $name     = 'per-page', 
//         $options  = [10, 25, 50, 100]
//     ) {
//         $selectOptions = '';
//         foreach ($options as $size) {
//             $selected = '';
//             if ($size == $select) {
//                 $selected = ' selected="selected" ';
//             }
//             $selectOptions .= "<option value=\"$size\"$selected>$size</option>";
//         }
//         $resetFilterButton = '';
//         if ($showResetFilterButton) {
//             $buttonText = __('core', 'Reset Filter');
//             $url = '/' . app()->request->pathInfo;
//             $resetFilterButton = <<<BTN
//                 <div class="my-3">
//                     <a href="$url"><span class="btn btn-warning">$buttonText</span></a>
//                 </div>
// BTN;
//         }
//         $showTranslated = __('core', 'Show');
//         $itemsTranslated = __('core', 'items');
//         $html = <<<OPT
//             <div class="per-page-wrapper mb-3 $class">
//                 $showTranslated
//                 <select name="$name" class="page-size col-3 form-control form-control-sm">
//                     $selectOptions
//                 </select>
//                 $itemsTranslated
//                 $resetFilterButton
//             </div>
// OPT;
//         return $html;
//     }

    public static function getGridPerPage(
        $showResetFilterButton,
        $select   = 10,
        $class    = 'd-flex float-right text-right col-sm-12 col-md-6',
        $name     = 'per-page', 
        $options  = [10, 25, 50, 200]
    ) {
        $selectOptions = '';
        foreach ($options as $size) {
            $label = __('template', 'Show {size} items', ['size' => $size]);
            $active = '';
            if ($size == $select) {
                $active = ' active ';
                $activeLabel = $label;
            }
            $optionUrl = self::_getPerPageUrl($name, $size);
            $selectOptions .= "<a class=\"dropdown-item $active\" href=\"$optionUrl\">$label</a>";
        }
        $resetFilterButton = '';
        if ($showResetFilterButton) {
            $buttonText = __('core', 'Reset Filter');
            $url = '/' . app()->request->pathInfo;
            $resetFilterButton = <<<BTN
                <div class="ml-3 mr-0">
                    <a href="$url"><span class="btn btn-secondary">$buttonText</span></a>
                </div>
BTN;
        }
        
        $html = <<<OPT
            <div class="per-page-wrapper mb-3 $class">
                <div class="dropdown dropleft d-inline">
                    <button class="btn btn-light dropdown-toggle" 
                        type="button" 
                        id="perPageDropDown"
                        data-toggle="dropdown" 
                        aria-haspopup="true" aria-expanded="false"
                    >
                        $activeLabel
                    </button>
                    <div class="dropdown-menu col-2 m-0 p-0" aria-labelledby="perPageDropDown">
                        $selectOptions
                    </div>
                </div>
                $resetFilterButton
            </div>
OPT;
        return $html;
    }

    private static function _getPerPageUrl(string $name, int $size) 
    {
        $currentUrl = tools()->getCurrentUrl();
        if (false === strpos($currentUrl, $name)) {
            return false === strpos($currentUrl, '?') ? "$currentUrl?$name=$size" : "$currentUrl&$name=$size";
        }
        return preg_replace("/$name\=\d+/", "{$name}={$size}", $currentUrl);
    }

    public static function getFormNameSpace($model)
    {
        $classNameParts = explode('\\', get_class($model));
        return end($classNameParts);
    }

    protected static function _formatField($field)
    {
        return preg_replace('/\[\d*?\]/', '', $field);
    }

    protected static function _formatTagId($field)
    {
        return self::_trim(strtolower(static::$nameSpace) . '-' . str_replace('[', '-', str_replace(']', '', $field)));
    }

    public static function getTagId($field)
    {
        return self::_formatTagId($field);
    }

    protected static function _formatTagName($field)
    {
        if (empty(static::$nameSpace)) {
            // $name = str_replace('[', '][', $field);
            $name = $field;
        }
        else {
            $name = static::$nameSpace . '[' . str_replace('[', '][', $field) . ']';
        }
        return self::_trim(str_replace(']]', ']', $name));
    }

    // protected static function _formatCheckListName($name, $checkbox)
    // {
    //     if (!is_null(self::$index)) {
    //         $name = $checkbox
    //             ? str_replace('][', ']['.self::$index.'][', $name)
    //             : str_replace(']',  ']['.self::$index.']',  $name);
    //     }
    //     return self::_trim($name);
    // }

    protected static function _formatCheckListId($name, $index)
    {
        return self::_trim(str_replace('[', '-', str_replace(['][]', ']'], '-'.$index, strtolower($name))));
    }

    protected static function _trim($str)
    {
        return trim($str, '-_');
    }

    public static function getYears($numberOfYears = 10)
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone(app()->timeZone));
        $year = (int) $date->format('Y');
        $options = '<option value="">Year</option>';
        for ($i = 0; $i < $numberOfYears; $i++) {
            $options .= '<option value="'.$year.'">'.$year.'</option>';
            $year++;
        }
        return $options;
    }

    public static function getMonths($short = true, $withNumber = true)
    {
        $fullName = [
            1 => 'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December' 
        ];
        $shortName = [
            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 
            'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec' 
        ];
        $months  = $short ? $shortName : $fullName;
        $options = '<option value="">Month</option>';

        foreach ($months as $key => $month) {
            $number = $withNumber ? sprintf("%02d - ", $key) : '';
            $options .= "<option value=\"$key\">$number$month</option>";
        }
        return $options;
    }

}
