<?php

namespace app\modules\Codnitive\CentralOffice\actions;


class SiteAction extends MainAction
{
    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     */
    public function run()
    {
        parent::run();
        $this->controller->setBodyClass('fixed sidebar-mini sidebar-mini-expand-feature skin-blue-light');
        return $this->controller->render(
            'index.phtml',
            [
                'userIdentity' => tools()->getUser()->identity,
            ]
        );
    }

}