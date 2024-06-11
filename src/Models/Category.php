<?php

namespace Dangson\XuongOop\Models;

use Dangson\XuongOop\Commons\Model;

class Category extends Model
{
    protected string $tableName = "categories";

    public function getAllWithProductCount()
    {
        $products = new Product();
        $productCounts = $products->countByCategory();

        $categories = $this->queryBuilder
            ->select('*')
            ->from($this->tableName)
            ->fetchAllAssociative();

        $categoryMap = array_column($categories, 'name', 'id');

        foreach ($productCounts as &$count) {
            $count['category_name'] = $categoryMap[$count['category_id']];
        }

        return $productCounts;
    }
}
