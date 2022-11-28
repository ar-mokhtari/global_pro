<?php 

namespace app\modules\Codnitive\Core\blocks;

// use yii\widgets\ActiveForm;
use app\modules\Codnitive\Core\widgets\ActiveForm;
use app\modules\Codnitive\Core\helpers\Html;

class Template
{
    // protected $_activeForm;

    protected $_html;

    public function registerAssets(
        \yii\web\View $view, 
        string $module,
        string $assets
    ): self
    {
        $assetsClass = "app\modules\Codnitive\\$module\assets\\$assets";
        // $assets = new $assetsClass;
        // $assets->register($view);
        $assetsClass::register($view);
        return $this;
    }

    /**
     * Method to load classes with DI container
     */
    // public function getObject(string $class)
    // {
    //     $container = new \yii\di\Container;
    //     return $container->get($class);
    // }

    // public function activeForm(): ActiveForm
    // {
    //     if (empty($this->_activeForm)) {
    //         $this->_activeForm = new ActiveForm;
    //     }
    //     return $this->_activeForm;
    // }

    public function beginForm(array $options = []): ActiveForm
    {
        return ActiveForm::begin($options);
        // return $this->activeForm()->begin($options);
    }

    public function endForm()
    {
        return ActiveForm::end();
    }

    public function html(): Html
    {
        if (empty($this->_html)) {
            $this->_html = new Html;
        }
        return $this->_html;
    }
}
