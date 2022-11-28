<?php

namespace app\modules\Codnitive\Template\helpers;

use app\modules\Codnitive\Core\helpers\Html as CoreHtml;

class Html extends CoreHtml
{
    // public static function getField($form, $model, $field, $icon = '', $template = '', $data = [])
    // {
    //     if (empty($template)) {
    //         $template = '';
    //         if (!isset($data['remove_label']) || !$data['remove_label']) {
    //             $template .= '<p>'.$model->getAttributeLabel($field).'</p>';
    //         }
    //         $template .= '
    //             <div class="input-group">
    //                 <span class="input-group-addon"><i class="'.$icon.'" aria-hidden="true"></i></span>
    //                 {input}
    //                 <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
    //             </div>';
    //     }
    //     $data['form_group_class'] = isset($data['form_group_class'])
    //         ? $data['form_group_class']
    //         : 'col-lg-6 col-md-6 col-sm-12';
    //     return parent::getField($form, $model, $field, $icon, $template, $data);
    // }

    // public static function getPriceField($form, $model, $field, $icon = '', $template = '', $data = [])
    // {
    //     $fieldName = self::_formatField($field);
    //     $price = $model->getAttribute($fieldName);
    //     if (!is_null($price)) {
    //         $model->setAttribute($fieldName, Tools::formatNumber($price));
    //     }
    //     return self::getField($form, $model, $field, $icon, $template, $data);
    // }

    // public static function getRadioList($form, $model, $field, $list, $data = [])
    // {
    //     $template = '<div class="radio">
    //                 <span class="radio-label">{label}</span>
    //                 <div class="radio-inputs-list">
    //                     {input}
    //                     <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
    //                 </div>
    //             </div>';
    //     // $class = isset($data['class']) ? 'form-control '.trim($data['class']) : 'form-control';
    //     $fieldName = self::_formatField($field);
    //     $data['format_field'] = false;
    //     $field = self::generateField($form, $model, $field, '', $template, $data);
    //     return $field->radioList(
    //             $list,
    //             ['item' => function($index, $label, $name, $checked, $value) {
    //                     // $name = self::_formatCheckListName($name, false);
    //                     $id   = self::_formatCheckListId($name, $index);
    //                     $checkedItem = $checked ? ' checked="checked"' : '';
    //                     $radio = '<label class="radio-inline col-3" for="'.$id.'">
    //                               <input type="radio" name="'.$name.'" id="'.$id.'" value="'.$value.'"'.$checkedItem.'>
    //                                   '.ucwords($label).'
    //                                   <span class="cr"><i class="cr-icon fa fa-check"></i></span>
    //                             </label>';
    //                     return $radio;
    //                 },
    //                 'value' => $model->$fieldName
    //                 /*'class' => $class,*/
    //             ]
    //         );
    // }
    //
    // public static function getCheckboxList($form, $model, $field, $list, $data = [])
    // {
    //     $template = '<div class="checkbox">
    //                 <span class="checkbox-label">{label}</span>
    //                 <div class="checkbox-inputs-list">
    //                     {input}
    //                     <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
    //                 </div>
    //             </div>';
    //     // $class = isset($data['class']) ? 'form-control '.trim($data['class']) : 'form-control';
    //     $fieldName = self::_formatField($field);
    //     $data['format_field'] = false;
    //     $field = self::generateField($form, $model, $field, '', $template, $data);
    //     return $field->checkboxList(
    //             $list,
    //             ['item' => function($index, $label, $name, $checked, $value) {
    //                     // $name = self::_formatCheckListName($name, true);
    //                     $id   = self::_formatCheckListId($name, $index);
    //                     $checkedItem = $checked ? ' checked="checked"' : '';
    //                     $checkbox = '<label class="checkbox-inline col-3" for="'.$id.'">
    //                                     <input type="checkbox" name="'.$name.'" id="'.$id.'" value="'.$value.'"'.$checkedItem.'>
    //                                   '.ucwords($label).'
    //                                   <span class="cr"><i class="cr-icon fa fa-check"></i></span>
    //                             </label>';
    //                     return $checkbox;
    //                 },
    //                 'value' => $model->getAttribute($fieldName)
    //                 /*'class' => $class,*/
    //             ]
    //         );
    // }

    // public static function getDropdownList($form, $model, $field, $list, $data = [])
    // {
    //     if (empty($template)) {
    //         $data['template'] = '';
    //         if (!isset($data['remove_label']) || !$data['remove_label']) {
    //             $data['template'] .= '<p>'.$model->getAttributeLabel($field).'</p>';
    //         }
    //         $data['template'] .= '
    //                     <div class="input-group">
    //                         <span class="input-group-addon"><i class="'.$data['icon'].'" aria-hidden="true"></i></span>
    //                         {input}
    //                         <div class="field-hint">{hint}</div><div class="field-error red-text">{error}</div>
    //                     </div>';
    //     }
    //     $data['form_group_class'] = isset($data['form_group_class'])
    //         ? $data['form_group_class']
    //         : 'col-lg-6 col-md-6 col-sm-12';
    //     return parent::getDropdownList($form, $model, $field, $list, $data);
    // }

    // public static function getDateField($form, $model, $field, $data = [])
    // {
    //     $icon = isset($data['icon']) ? $data['icon'] : 'fa-calendar';
    //     unset($data['icon']);
    //     $data = ArrayHelper::merge([
    //         'form_group_class'  => 'col-6',
    //         'col_size'          => 'col-7',
    //         'class'             => 'input-md datepicker',
    //     ], $data);
    //     return self::getField($form, $model, $field, $icon, '', $data);
    // }

    // public static function getFromToDate($form, $model)
    // {
    //     $fromDate = self::getDateField($form, $model, 'start_date', [
    //         'class' => 'input-md datepicker from-date',
    //         'placeholder' => 'Start Date',
    //     ]);
    //     $toDate   = self::getDateField($form, $model, 'end_date', [
    //         'class' => 'input-md datepicker to-date',
    //         'form_group_class' => 'col-4',
    //         'col_size' => 'col-11',
    //         'remove_label' => true
    //     ]);
    //     $html     = '<div class="one-row two-in-row row">'.$fromDate.$toDate.'</div>';
    //     return $html;
    // }

    public static function getAjaxSessionExpiredMessage(string $moduleId): string
    {
        $message = __('template', 'Your session has expired, please click here to update search results.');
        $template = <<<TPLT
        <div class="p-3 d-flex justify-content-center search-again" 
            id="{$moduleId}_search_again" 
        >
            $message <i class="fa fa-search mr-2"></i>
        </div>
        <script type="text/javascript">
            $('#{$moduleId}_search_again').click(function () {
                $('#{$moduleId}_search_again_form button').click();
            });
        </script>
TPLT;
        return $template;
    }

//     public static function getAjaxSessionExpiredMessage(string $moduleId): string
//     {
//         $emptyResultMsg = __('template', 'Your time has expired, search again to view update results.');
//         $emptyResult = "<div class=\"p4 text-center fz-20\">$emptyResultMsg</div>";
//         $message = __('template', 'Your session has expired, please seach again.');
//         $template = <<<TPLT
//         <div class="p-3 d-flex justify-content-center search-again" 
//             id="{$moduleId}_search_again" 
//             data-toggle="collapse" 
//             href="#{$moduleId}_search_again_form" 
//             role="button" 
//             aria-expanded="false" 
//             aria-controls="{$moduleId}_search_again_form"
//         >
//             $message <i class="fa fa-search mr-2"></i>
//         </div>
//         <script type="text/javascript">
//             bilit.backTopToSearchAgain('#{$moduleId}_search_again', '.ajax-result-wrapper', '$emptyResult');
//         </script>
// TPLT;
//         return $template;
//     }

}
