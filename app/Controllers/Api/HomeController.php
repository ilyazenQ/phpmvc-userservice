<?php

namespace App\Controllers\Api;

use App\Actions\ParseUrlEncodeAction;
use App\Actions\StoreEquipmentAction;
use App\Actions\UpdateEquipmentAction;
use App\Models\Equipment;

class HomeController
{
    public function check()
    {
        $s = "123'";
        echo "200 OK";
    }

    public function checkAPI()
    {
        echo "API OK";
    }

    public function store()
    {
        $equipment = new Equipment();
        (new StoreEquipmentAction())->execute($equipment);
        return $equipment::apiService()->response('201','stored');
    }

    public function show()
    {
        $id = $_GET['id'];
        $equipment = new Equipment();
        return $equipment::apiService()->showOne($equipment->getById($id));
    }

    public function update()
    {
        $equipment = new Equipment();
        $updateResult = (new UpdateEquipmentAction())->execute($equipment);
        if(!$updateResult) {
            return $equipment::apiService()->response('422','Validate Error');
        }
        return $equipment::apiService()->response('200','updated');
    }

    public function delete()
    {
        $equipment = new Equipment();
        $id = $_POST['id'];
        $equipment->delete($id);
        return $equipment::apiService()->response('204','deleted');
    }

}
