# hasMany():
1:N
 Esta función de Eloquent establece una relación de uno a muchos entre el modelo Comanda y el modelo ComandaArticulo.
  Es decir, una comanda puede tener muchos artículos asociados.

# belongsTo(): 
N:1
Esta función de Eloquent establece una relación de uno a muchos inversa, lo que significa que un artículo de comanda pertenece a una comanda.

# Hash::check() 
para comparar la contraseña ingresada por el usuario con la contraseña encriptada almacenada en la base de datos.