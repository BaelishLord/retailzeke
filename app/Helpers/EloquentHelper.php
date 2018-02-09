<?php

function getColumnList($model) {
    
    return removePrefix(excludeColumn($model::getFillableField(), array_merge($model::getHiddenField(), $model::getGuardedField(), config('constants.timestamp'), config('constants.exclude_cd'))), $model::getPrefix());
}