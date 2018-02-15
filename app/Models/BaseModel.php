<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public static function getHiddenField() {
        return with(new static)->getHidden();
    }

    public static function getGuardedField() {
        return with(new static)->getGuarded();
    }

    public static function getFillableField() {
        return with(new static)->getFillable();
    }

    public static function getKeyField() {
        return with(new static)->getKeyName();
    }

    public static function status() {
        return with(new static)
        ->leftjoin('system_codes','system_codes.code_val', '=', with(new static)->getTable().'.status')
        ->where(['code_id' => config('constants.CODE_ID_STATUS')]);
    }

    public static function getClient() {
        return with(new static)
        ->where('id', \Auth::user()->id)->get()[0];
    }

    public static function getPrefix() {
        return config('constants.'.((new \ReflectionClass(with(new static)))->getShortName()).'.prefix');
    }

    public function getEventList() {
        return EventManagement\EventRequest::orderBy(EventManagement\EventRequest::getKeyField(), 'desc')->whereNotIn('er_request_status', [config('constants.EVENT_ASSET_STATUS.REJECTED')])->pluck('er_name', EventManagement\EventRequest::getKeyField());
    }

    public static function getActive() {
        return with(new static)->where('status', config('constants.STATUS.active.DB_VALUE'));
    }

    public static function getUserData($column_name) {
        return with(new static)->where($column_name, \Auth::user()->emp_id);
    }

    
}
