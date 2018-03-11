<?php

namespace App\Models;

use App\Models\BaseModel;

class MaintainanceType extends BaseModel
{
    
    public function __construct($attributes = array()) {

        $this->setTable(config('constants.'.((new \ReflectionClass($this))->getShortName()).'.table')); // table name
        
        $this->setKeyName(config('constants.'.((new \ReflectionClass($this))->getShortName()).'.table') .'_'. $this->getKeyName()); // primary key name
       
        $this->guard([$this->getKeyName()]); // Add more field to guard
 
        $nonFillable = array_merge(config('constants.timestamp'), $this->getGuarded()); 

        // Fillables;
        $this->fillable(
            excludeColumn(
                array_merge(
                    \Schema::getColumnListing($this->getTable()),
                    $nonFillable
                ),
                $nonFillable
            )
        );

        parent::__construct($attributes);
    }
}
