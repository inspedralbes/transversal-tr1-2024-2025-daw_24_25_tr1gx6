<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Stock extends Model
{
    
    public static function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = ?", [$column])[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
    
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }
    
        return $enum;   
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idProducto');
    }
    
}
