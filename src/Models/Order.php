<?php

namespace Dangson\XuongOop\Models;

use Dangson\XuongOop\Commons\Model;

class Order extends Model{

    protected string $tableName = 'orders';

    public function findByUserID($userID)
    {
        return $this->queryBuilder
            ->select('*')
            ->from($this->tableName)
            ->where('user_id = ?')
            ->setParameter(0, $userID)
            ->fetchAllAssociative();
    }


    public function getAllOrders()
    {
        return $this->queryBuilder
            ->select('*')
            ->from($this->tableName)
            ->fetchAllAssociative();
    }

    public function find($id)
    {
        return $this->queryBuilder
            ->select('*')
            ->from($this->tableName)
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();
    }

    public function updateStatus($id, $status)
    {
        return $this->queryBuilder
            ->update($this->tableName)
            ->set('status', '?')
            ->where('id = ?')
            ->setParameters([$status, $id])
            ->executeQuery();
    }
}