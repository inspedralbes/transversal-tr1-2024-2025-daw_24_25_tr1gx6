# hasMany():
1:N
 Esta función de Eloquent establece una relación de uno a muchos entre el modelo Comanda y el modelo ComandaArticulo.
  Es decir, una comanda puede tener muchos artículos asociados.

# belongsTo(): 
N:1
Esta función de Eloquent establece una relación de uno a muchos inversa, lo que significa que un artículo de comanda pertenece a una comanda.

# Hash::check() 
para comparar la contraseña ingresada por el usuario con la contraseña encriptada almacenada en la base de datos.

# ucfirst('nombres')
La función ucfirst en PHP convierte la primera letra de una cadena a mayúscula.

# Funcion para recoger los datos que hay en un enum de una tabla en especifico y columna escecifica
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

# Para llamarla luego seria asi 
        $NameVariable = NameModel::getEnumValues('table', 'column');
