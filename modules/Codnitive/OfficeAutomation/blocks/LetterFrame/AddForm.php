<?php

namespace app\modules\Codnitive\OfficeAutomation\blocks\LetterFrame;

use app\modules\Codnitive\OfficeAutomation\core\blocks\Template;
use app\modules\Codnitive\OfficeAutomation\models\Letters;


class AddForm extends Template
{
    protected $OfficeModel;

    public function __construct()
    {
        $this->setOfficeModel();
    }

    public function setOfficeModel(): self
    {
        $this->OfficeModel = new Letters;
        return $this;
    }

    public function getArticleModel(): Letters
    {
        return $this->OfficeModel;
    }

}
