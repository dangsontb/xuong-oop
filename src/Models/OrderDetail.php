<?php

namespace Dangson\XuongOop\Models;

use Dangson\XuongOop\Commons\Model;

class OrderDetail extends Model
{

    protected string $tableName = 'order_details';

    public function findByOrderID($orderID)
    {

        return $this->queryBuilder
            ->select('od.*,p.name as product_name')
            ->from($this->tableName, 'od')
            ->innerJoin('od', 'products', 'p', 'od.product_id=p.id')
            ->where('od.order_id = ?')
            ->setParameter(0, $orderID)
            ->fetchAllAssociative();
    }


    public function findByOrderIDClient($orderID)
    {
        $queryBuilder = clone ($this->queryBuilder);

        return $queryBuilder
            ->select('od.*,p.name as product_name, p.img_thumbnail')
            ->from($this->tableName, 'od')
            ->innerJoin('od', 'products', 'p', 'od.product_id=p.id')
            ->where('od.order_id = ?')
            ->setParameter(0, $orderID)
            ->fetchAllAssociative();
    }
}
