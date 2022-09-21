<?php

namespace App\Models;

use App\Services\ApiService;
use ErrorException;
use Exception;
use function PHPUnit\Framework\throwException;

class Equipment extends Model
{
    private static ApiService $apiService;

    public function __construct()
    {
        parent::__construct();
        static::$apiService = new ApiService();
    }

    public static function apiService()
    {
        return static::$apiService;
    }

    public function store($title, $amount)
    {
        $stmt = $this->db->prepare("INSERT INTO Equipment(title, amount) VALUES (:title,:amount)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
    }

    public function update($title, $amount, $id)
    {
        $stmt = $this->db->prepare("UPDATE Equipment SET title=:title, amount=:amount WHERE id=:id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM `Equipment` WHERE `id` =" . "$id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Equipment WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}