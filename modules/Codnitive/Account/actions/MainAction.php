<?php

namespace app\modules\Codnitive\Account\actions;

// use yii\base\Action;
// use dektrium\user\Finder;

class MainAction extends \app\modules\Codnitive\Core\actions\Action
{

    /** @var Finder */
    // protected $finder;

    /**
     * @param string  $id
     * @param Finder  $finder
     */
    // public function __construct()
    // {
    //     $this->finder = new Finder;
    // }

    public function run(/*$id = null*/)
    {
        // $this->finder = new Finder;
        $this->controller->setBodyClass('account orange');
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/main';
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     $this->finder->setUserQuery('id = 3');
    //     $user = $this->finder->findUserById($id);
    //     if ($user === null) {
    //         throw new NotFoundHttpException('The requested page does not exist');
    //     }
    //
    //     return $user;
    // }
}
