<?php

namespace App\Http;

class Helper
{
    public static function getMappedValues($model, $id = 'id', $name = 'name')
    {
        return $model::query()
            ->select($id, $name)
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
    }
}
