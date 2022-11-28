<?php

namespace app\modules\Codnitive\Core\helpers;

use tigrov\country\Country as CountryBase;
use tigrov\country\Division;

class Country
{

    public function getCountriesList()
    {
        return CountryBase::names();
    }

    /*public function getCountriesSelectOptions($countiriesList)
    {
        $html = '';
        return
    }*/

    public function getRegionsList($countryCode)
    {
        $country = CountryBase::create($countryCode);
        $divisions = [];
        foreach ($country->divisions as $code => $data) {
            $divisions[$code] = $data->name_en;
        }
        return $divisions;
    }

    public function getRegionsDropdown($countyCode, $formName)
    {
        $formName = str_replace('-country', '', $formName);
        $options = '';
        $divisions = $this->getRegionsList($countyCode);
        foreach ($divisions as $code => $name) {
            $options .= '<option value="'.$code.'">'.$name.'</option>';
        }
        $html = '<div class="form-group field-'.$formName.'-division required">
                    <div class="row">
                        <label class="col-lg-2 control-label" for="'.$formName.'-division">State/Region</label>
                        <div class="col-md-4">
                            <select id="'.$formName.'-division" class="form-control division-list" name="'.ucfirst($formName).'[division]">
                                <option value="">--Please Selct State/Region--</option>
                                '.$options.'
                            </select>
                        </div>
                    </div>
                </div>';
        return $html;
    }

    // public function getCountryCodeByName($name)
    // {
    //     $search = CountryBase::find()
    //         ->select(['code'])
    //         ->where(['name_en' => $name])
    //         ->one();
    //     if (!empty($search)) {
    //         return $search->code;
    //     }
    //     return false;
    // }
    //
    // public function getDivisionCodeByName($name)
    // {
    //     $search = Division::find()
    //         ->select(['division_code'])
    //         ->where(['name_en' => $name])
    //         ->one();
    //     if (!empty($search)) {
    //         return $search->division_code;
    //     }
    //     return false;
    // }

    public function getCountryCodesByName($name)
    {
        $search = CountryBase::find()
            ->select(['code'])
            ->where(['like', 'name_en', $name])
            ->asArray()
            ->all();
        return array_map('current', $search);
    }

    public function getDivisionCodesByName($name)
    {
        $search = Division::find()
            ->select(['division_code'])
            ->where(['like', 'name_en', $name])
            ->asArray()
            ->all();
        return array_map('current', $search);
    }

}
