<?php

namespace App\Actions;

use App\Models\Equipment;

class StoreEquipmentAction
{
    public function execute(Equipment $equipment)
    {
        $title = $_POST['title'];
        $amount = $_POST['amount'];
        $equipment->store($title,$amount);
    }
}