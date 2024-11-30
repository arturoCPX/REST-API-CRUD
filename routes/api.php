<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\studentController;


#Obtener todos los estudiantes
Route::get('/students', [studentController::class, 'index']);

#Obtner solo un estudiante
Route::get('/students/{id}', [studentController::class, 'show']);

Route::post('/students', [studentController::class, 'store']);

#PUT permite actualzar todo un objeto  #Patch permite actulizar parcilamente 
Route::put('/students/{id}', [studentController::class, 'update']);

Route::patch('/students/{id}', [studentController::class, 'updatePartial']);

#Eliinar estudiantes
Route::delete('/students/{id}', [studentController::class, 'destroy']);


#Intalamos thuner clien pra probar el crud
#Creamos una migracion php artisan make:migration create_student_table
#Creamos la tabla en la migracion, agregando los campos
#creamos la base d datos con php artisanmigrate(nos creo la bd y la tabla en mysql)
#Creamos un modelo con php artisan make:model Student
#Agregamos los campos en el modelo
#Crear un controlador php artisan make:controller studenController(tndra las funcones de cuando se visite una URL)
#Creamos una funcion en el controlador llamada index, es de donde llamaremos de api.php, es decir llamaremos a la funcion
#En api.php importamos el studentsController y lo llamamos desde el get students
#Modificamos el studenController, para imprimir el arreglo de etudiantes. Agregamos validacion para cuando se encuentr vacio
#caambioamos a logica de listar
#Nosotros no solo cqueremos listar, sino tambien crear, por lo que vamos a crear otra funcion, llamada store
#Importamos un metodo para alidar de laravel
#Creamos la logica en studenController
#Probamos el post, agregamdo un estudiante en un json, y funciona correctamente,
#Agregamos mas validaciones al studentController, de 10n el telefono, email unico, etc.
#Funcionan correctaente las nuevasvalidacioes, al igual que el get de los estudiantes
#Creamos la logica de la funcion show, y la llamamos desde api.php
#Y probamos, corrctamente
#Ahora crearemos la funcion de eliminar
#Cremos su logica, llamamos esde api.php, y probamos
#Creae funcion para actualizar datos, llamamos y probamos
#Aregamos una ruta mas llamada patch
