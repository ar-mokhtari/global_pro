<?php

namespace app\modules\Codnitive\Template\traits;

// use Yii;
// use yii\web\Controller;
// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Core\controllers\Controller;

trait PageControllerTrait
{
    protected $_request;

    protected $_bodyClass = '';
    protected $_bodyId = '';

    protected $_headerBottom = '';

    // public $activeMenu = '';

    public function setFlash(string $type, string $message): self
    {
        app()->getSession()->setFlash($type, $message);
        return $this;
    }

    public function setBodyClass(string $bodyClass): self
    {
        $this->_bodyClass = $bodyClass;
        return $this;
    }

    public function getBodyClass(): string
    {
        return $this->_bodyClass;
    }

    public function addBodyClass(string $class): self
    {
        $this->setBodyClass(trim($this->getBodyClass()) . " $class");
        return $this;
    }

    public function setBodyId(string $bodyId): self
    {
        $this->_bodyId = $bodyId;
        return $this;
    }

    public function getBodyId(): string
    {
        return $this->_bodyId;
    }

    public function renderHeaderBottom(): string
    {
        return $this->_headerBottom ? $this->renderPartial($this->_headerBottom) : '';
    }

    public function setHeaderBottom(string $templatePath): self
    {
        $this->_headerBottom = $templatePath;
        return $this;
    }

    public function getMetaDescription(): string
    {
        return __('template', 'Meta Description Sample');
    }
}
