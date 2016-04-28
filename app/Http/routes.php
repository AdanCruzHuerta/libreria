<?php

get('/', function () {
    return view('website.index');
});
get('/tienda', function(){
	return view('website.tienda');
});
get('/carrito', function(){
	return view('website.carrito');
});
get('/acerca', function(){
	return view('website.acerca');
});
get('/contacto', function(){
	return view('website.contacto');
});
get('/acceder', 'LoginController@index');
post('/mensajes', 'MensajesController@store');
post('/login', 'LoginController@store');
get('/administrador/panel', 'AdministradorController@index');


// rutas del administrador
Route::group(['middleware' => 'admin'], function () {
	get('/administrador', 'AdministradorController@index');
	get('/logout', 'LoginController@destroy');
	Route::resource('/administrador/libros', 'LibrosController');
});

// Consultas multiples
//Libro
// Autor
// Libro_Autor
get('/consulta', function(){

	try{
		\DB::beginTransaction();
	// Eloquent
		$libro = new App\Libro;
			$libro->titulo = 'El alquimista';
			$libro->edicion = 'Segunda';
			$libro->paginas = 350;
			$libro->precio = 180.5;
			$libro->isbn = 'ABCDS';
			$libro->editorial_id_editorial = 1;
			$libro->Idioma_id_Idioma = 1;
			$libro->descuento = "";
			$libro->Imagen = 'imagen.jpg';
			$libro->save();

		$autor = new App\Autor;
			$autor->Nombre = "Paulo Cohello";
			$autor->save();

		if(is_object($libro) && is_object($autor)) {
			$detalle = \DB::table('Autor_has_Libro')->insert([
				"Autor_idAutor" => $autor->id,
				"Libro_id_libro" => 15
			]);
		}
		\DB::commit();
		return "Exito";
	}  catch(Exception $ex) {
			\DB::rollback();
			return "Fail";
	}
});