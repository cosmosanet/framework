<?php
namespace Framework\Traites;

trait ArrayTrait
{
    public function deleteEmty(array $arr) {
        foreach ($arr as $key => $value) 
        {
            if (strlen($value) <= 1) {
                unset($arr[$key]);
            }
        }
        return $arr;
    }
}