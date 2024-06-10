<?php

namespace Dangson\XuongOop\Models;

use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Commons\Model;

class Product extends Model
{
    protected string $tableName = "products";

    public function all(){
        return  $this->queryBuilder
        ->select(
            'p.id', 'p.name', 'p.category_id',  'p.price_regular', 'p.price_sale', 'p.img_thumbnail', 'p.created_at', 'p.updated_at',
            'c.name as c_name',
        )
        ->from($this->tableName, 'p')
        ->innerJoin('p','categories','c','c.id = p.category_id')
        ->orderBy('p.id', 'desc')
        ->fetchAllAssociative();
    }
    public function paginateHome($page = 1, $perPage = 4)
    {
        $queryBuilder = clone($this->queryBuilder);

        $totalPage = ceil($this->count() / $perPage);  

        $offset = $perPage * ($page -1);

        $data = $queryBuilder
        ->select(
            'p.id', 'p.name', 'p.category_id', 'p.price_regular', 'p.price_sale',  'p.img_thumbnail', 'p.created_at', 'p.updated_at',
            'c.name as c_name',
        )
        ->from($this->tableName, 'p')
        ->innerJoin('p','categories','c','c.id = p.category_id')
        ->setFirstResult($offset)
        ->setMaxResults($perPage)

        ->orderBy('p.id', 'desc')
        ->fetchAllAssociative();

        return [$data , $totalPage];
    }

    public function findByID($id)
    {
        return $this->queryBuilder
        ->select(
            'p.id',  'p.category_id' , 'p.price_regular', 'p.price_sale',  'p.name', 'p.img_thumbnail', 'p.created_at', 'p.updated_at',
            'p.overview', 'p.content',
            'c.name as c_name',
        )
        ->from($this->tableName, 'p')
        ->innerJoin('p','categories','c','c.id = p.category_id')
        ->where('p.id = ?')
        ->setParameter(0, $id)
        ->fetchAssociative();
    }

    public function paginateProductByCategoryID($category_id, $page = 1 , $perPage = 9 )
    {
        $queryBuilder = clone($this->queryBuilder);

        $totalPage = ceil($this->countProductByCategoryID($category_id) / $perPage);  

        $offset = $perPage * ($page -1);

        $data = $queryBuilder
        ->select(
            'p.id', 'p.name', 'p.category_id', 'p.price_regular', 'p.price_sale',  'p.img_thumbnail', 'p.created_at', 'p.updated_at',
            'c.name as c_name',
        )
        ->from($this->tableName, 'p')
        ->innerJoin('p','categories','c','c.id = p.category_id')

        ->setFirstResult($offset)
        ->setMaxResults($perPage)

        ->where('p.category_id = ?')
        ->setParameter(0, $category_id)

        ->orderBy('p.id', 'desc')
        ->fetchAllAssociative();
    
        return [$data , $totalPage];
    }

    public function countProductByCategoryID($category_id)
    {
        return $this->queryBuilder
            ->select("COUNT(*) as $this->tableName")
            ->from($this->tableName, 'p')
            ->innerJoin('p','categories','c','c.id = p.category_id')
            ->where('p.category_id = ?')
            ->setParameter(0, $category_id)
            ->fetchOne();
    }
}
