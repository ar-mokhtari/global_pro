<?php


namespace app\modules\Codnitive\Accounting\core\helpers;

use app\modules\Codnitive\Core\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class AccountingHtml extends Html
{
    public static function getTextarea($form, $model, $field, $data = [])
    {
        $tagId = self::_formatTagId($field);
        $tagName = self::_formatTagName($field);
        $field = self::_formatField($field);
        // $data = ArrayHelper::merge([
        //     'class'             => 'text-editor',
        // ], $data);

        if (isset($data['template']) && !empty($data['template'])) {
            $template = $data['template'];
            unset($data['template']);
        } else {
            $colSize = isset($data['col_size']) ? $data['col_size'] : 'col-12 p-0';
            $template = '<div class="form-group">
                    {label}
                    <div class="' . $colSize . '">
                        {input}
                        <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
                    </div>
                </div>';
        }
        $field = self::getField($form, $model, $field, '', $template, $data);
        $textEditor = (!isset($data['no_editor']) || !$data['no_editor']) ? ' text-editor ' : ' textarea ';
        $class = isset($data['class']) ? 'form-control ' . $textEditor . trim($data['class']) : 'form-control ' . $textEditor;
        $textarea = $field->textarea([
            'class' => $class,
            'rows' => $data['rows'],
            'cols' => '100',
            'id' => $tagId,
            'name' => $tagName
        ]);
        return (isset($data['cloneSample']) && $data['cloneSample'])
            ? str_replace('textarea', 'text-area', $textarea)
            : $textarea;
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
            \app\modules\Codnitive\OfficeAutomation\assets\fastSelect::register($view);
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

    public static function getDateField($form, $model, $field, $view, $data = [])
    {
        // \app\modules\Codnitive\Template\assets\ZebraDatepicker::register($view);
        \app\modules\Codnitive\OfficeAutomation\assets\MDPersianDatepicker::register($view);
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

}
