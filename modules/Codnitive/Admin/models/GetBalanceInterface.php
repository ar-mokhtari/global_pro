<?php 

namespace app\modules\Codnitive\Admin\models;

interface GetBalanceInterface
{
    public function getBalance(): float;
    public function getName(): string;
}
