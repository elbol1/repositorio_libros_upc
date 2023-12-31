<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Bibliografia;
use App\Libro;
use App\Revista;
use App\Role;
use App\Tesis;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('test', function(){
    $admins = Role::where('id','1')->first()->usuarios;
    dd($admins);
    foreach ($admins->usuarios as $admin) {
        dd($admin);
    }
});

// DB::listen(function($query){
//     echo "<h1><pre>{$query->sql}<pre></h1>";
// });

Route::get('/demo',function ()
{
    return view('demo');
});

Route::get('/', function () {
    return redirect()->route('index_front');
});

Route::get('/inicio', function () {
    $libros = Libro::all()->load(['bibliografia', 'bibliografia.usuario']);
    $revistas = Revista::all()->load(['bibliografia', 'bibliografia.usuario']);
    $tesis = Tesis::all()->load(['bibliografia', 'bibliografia.usuario']);
    
    return view('frontoffice.templates.index', compact('libros','revistas','tesis'));
})->name('index_front');

Route::get('search',function ()
{
    if (request()->get('buscar')) {
        $titulo = request()->get('buscar');
        $bibliografias = Bibliografia::where('titulo','like','%'.$titulo.'%')->where('revisado',3)->get();
        return view('frontoffice.templates.content_search',compact('bibliografias'));
    }

    return response(view('errors.404'),404);
});

//BACK OFFICE
Route::name('backoffice.')->middleware(['auth','userVerified'])->group(function (){

    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');
    Route::get('/activate/{user}','UserController@activeUser')->name('activeUser');

    Route::post('/notificacion','NotificationController@read')->name('notification.read');

    Route::resource('/autor', 'AutorController');
    Route::resource('/genero', 'GeneroController');
    Route::get('/index','ReporteController@reportes')->name('index');

    Route::resource('/libro', 'LibroController');
    Route::get('/libro/download/{libro}','LibroController@download')->name('libro.download');
    Route::post('/libro/revision/{libro}', 'LibroController@revision')->name('libro.revision');
    
    Route::resource('/revista', 'RevistaController');
    Route::get('/revista/download/{revista}','RevistaController@download')->name('revista.download');
    Route::post('/revista/revision/{revista}', 'RevistaController@revision')->name('revista.revision');
    
    Route::resource('/tesis', 'TesisController');
    Route::get('/tesis/download/{tesis}','TesisController@download')->name('tesis.download');
    Route::post('/tesis/revision/{tesis}', 'TesisController@revision')->name('tesis.revision');
    
    Route::post('/puntos', 'LibroController@puntosActuales');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
