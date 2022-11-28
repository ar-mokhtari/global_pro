<?php 

namespace app\modules\Codnitive\Admin\blocks;

use yii\base\Model;

interface EditInterface
{
    public function setModel(Model $model);
    public function getModel(): Model;
    public function getNamespace(): string;
    public function getActionUrl(): string;
    public function getBackUrl(): string;
    public function getDeleteUrl(): string;

    public function getFormFieldsTemplate(): string;
}
