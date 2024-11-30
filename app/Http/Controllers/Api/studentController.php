<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    #Funcion ara listar estudiantes
    public function index(){
        $students = Student::all();

        #Validacio para no mostrar el arreglo vacio
        // if($students->isEmpty()){
        //     $data = [
        //         'message' => 'No students found',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 404);
        // }

        $data =[
            'students' => $students,
            'status' => 200
        ];

        #Retornamos el arreglo
        return response()->json($data, 200);
    }

    #Funcion para crear estudiantes
    public function store(Request $request){
        
        #Cramos objeto validator(Validamos que todos los campos sean reuqeridos )
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        #Validar si falla la validacion, si hay un error
        if($validator->fails()){
            $data = [
                'message' => 'Data validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        #Si los datos son correctos, creamos algo 
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);

        #Si no podemos crear estudiante, mandamos el mensaje
        if(!$student){
            $data = [
                'message' => 'Error creating student',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        #Si pudo crear al estudante
        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);

    }

    #Funcion para obtener un solo estudiante
    public function show($id){
        #Obtenemos el valor del estudiante
        $student = Student::find($id);

        #Validamos si hay un estudiante
        if(!$student){
            $data = [
                'message' => 'Student Not Found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    #Funcion para eliminar
    public function destroy($id){

        #Obtenemos el valor del estudiante
        $student = Student::find($id);

        #Validamos si hay un estudiante
        if(!$student){
            $data = [
                'message' => 'Student Not Found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        #Lo eliminamos
        $student->delete();

        #Creamos logica a mostrar
        $data = [
            'message' => 'Student eliminated',
            'status' => 200
        ];

        #Mandamos a imprimir
        return response()->json($data, 200);
    }

    #Funcion para actualizar
    public function update(Request $request, $id){

        #Obtenemos el valor del estudiante
        $student = Student::find($id);

        #Validamos si hay un estudiante
        if(!$student){
            $data = [
                'message' => 'Student Not Found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        #Si encontramos al estudiante validamos el request
        #Cramos objeto validator(Validamos que todos los campos sean reuqeridos )
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        #Validar si falla la validacion, si hay un error
        if($validator->fails()){
            $data = [
                'message' => 'Data validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        #Si los datos estan correctos actualizamos
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        #Creamos la variable para mostrar al usuario
        $data = [
            'message' => 'Updated student',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);



    }

    #Funcion patch
    public function updatePartial(Request $request, $id){
        #Obtenemos el valor del estudiante
        $student = Student::find($id);

        #Validamos si hay un estudiante
        if(!$student){
            $data = [
                'message' => 'Student Not Found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }


        #Validamos
        #Es similar el validar, solo que en est no requerimos a fuerzas el dato
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French'
        ]);

        #Validar si falla la validacion, si hay un error
        if($validator->fails()){
            $data = [
                'message' => 'Data validation failed',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        #Vamos a validar por si solo queremos actulizar un campo individualmente
        #SI el objeto request que me envia e cliente, tiene la propiedad name, actuaizamos esa proiedad del estudiante
        #Lo mismo para los demas

        if($request->has('name')){
            $student->name = $request->name;
        }

        if($request->has('email')){
            $student->email = $request->email;
        }

        if($request->has('phone')){
            $student->phone = $request->phone;
        }

        if($request->has('language')){
            $student->language = $request->language;
        }

        #Guardamos
        $student->save();

        #Creamos la variable para mostrar al usuario
        $data = [
            'message' => 'Updated student',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);


    }
    
}
