<?php 

namespace app\modules\Codnitive\Admin\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use yii\base\Model;

abstract class EditAbstract extends Template implements EditInterface
{
    protected $_model;
    protected $_module = '';
    protected $_formFieldTemplate = '';

    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function setModel(Model $model): self
    {
        $this->_model = $model;
        return $this;
    }

    public function getModel(): Model
    {
        return $this->_model;
    }

    public function getNamespace(): string
    {
        return $this->_module;
    }

    public function getFormFieldsTemplate(): string
    {
        return $this->_formFieldTemplate;
    }

    public function getActionUrl(): string
    {
        return tools()->getUrl("admin/{$this->_module}/save");
    }

    public function getBackUrl(): string
    {
        return tools()->getUrl("admin/{$this->_module}/index");
    }

    public function getDeleteUrl(): string
    {
        return tools()->getUrl("admin/{$this->_module}/delete", ['id' => $this->getModel()->id]);
    }
}
