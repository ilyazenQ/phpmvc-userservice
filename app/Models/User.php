<?php

namespace App\Models;

class User extends Model
{
    public function store($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users(name, phone, email, password)
        VALUES (:name, :phone, :email, :password)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', md5($data['password']));
        $stmt->execute();
    }

    public function update($data, $id)
    {
        $stmt = $this->db->prepare("UPDATE users SET name=:name, phone=:phone, email=:email, password=:password 
                 WHERE id=:id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', md5($data['password']));
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getAuthUser()
    {
        $id = $_COOKIE['user'];
        $query = "SELECT * FROM `users` WHERE `id` =" . "$id";
        $stmt = $this->db->query($query);
        return $stmt->fetch();
    }

}