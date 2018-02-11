<?php

function getColumnList($model) {
    
    return removePrefix(excludeColumn($model::getFillableField(), array_merge($model::getHiddenField(), $model::getGuardedField(), config('constants.timestamp'), config('constants.exclude_cd'))), $model::getPrefix());
}

/**
 * @param  string $value
 * @param  string $key
 * @return array
 */
function execSelect($query, $array) {
    $pdo = DB::connection()->getPdo();
    $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ COMMITTED');
    $res = DB::select($query, $array);
    return $res;
}