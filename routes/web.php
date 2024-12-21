<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('welcome');

   // RAW SQL QUERIES
  //$user= DB::select("select * from users where email=?",['kripalakshmyd@gmail.com']);
  // $user= DB::insert("insert into users (name,email,password) values (?,?,?)",['paru','paru@gmail.com','12345']);

//QUERY BUILDER

//$users = DB::table('users')->get(); //retrieveing all rows
// foreach($users as $user)
// {
//     echo $user->name;
// }
// --------------------------

// $user =  DB::table('users')->where('id',2)->first(); //retrivening a single row
// echo $user->name;
// --------------------------------

//retriving a single colum value
// $email = DB::table('users')->where('id',1)->value('email');
// echo $email;
//----------------------------------

//  $user =  DB::table('users')->find(2); //retrivening a single row with ID field
//  echo $user->name;
// ================================



//Retrieving a List of Column Values with PLUCK()
// $titles = DB::table('users')->pluck('name');
// foreach($titles as $title)
// {
//     echo $title."<br/>";
// }
//------------------------------
//Retrieving a List of Column Values with PLUCK() with the coloum to be used as the key passed as 2nd arg
// $emails = DB::table('users')->pluck('email','id');
// foreach($emails as $id => $email)
// {
//     echo $id.'-'.$email."<br>";
    
// }
// ================================

//CHUNK()
// DB::table('users')->orderBy('id')->chunk(2,function (COllection $users){
// foreach($users as $user)
// {
//     echo $user->name."<br>";
//     return false; //if u want to stop further processing
// }
// });
//------------------
//CHUNKBYID()
// DB::table('users')->orderBy('id')->chunkById(2,function (Collection $users){
// foreach($users as $user)
// {
//     DB::table('users')->where('id',$user->id)->update(['active'=>1]);
// }
// });
//=======================================

//lazy()
// DB::table('users')->orderBy('id')->lazy()->each(function (object $myuser){
//     echo $myuser->name."<br>";
// });
//---------------
//lazyById()
// DB::table('users')->orderBy('id')->lazyById()->each(function (object $myuser){
// DB::table('users')->where('id',$myuser->id)->update(['active'=>0]);
// });
//====================================

//AGGRATAE FUNC
//echo $count = DB::table('test')->count();
//echo $sum = DB::table('test')->sum('price');
// echo $sum = DB::table('test')->where('active',1)->sum('price');
// echo $avg = DB::table('test')->where('active',1)->avg('price');
// echo $max = DB::table('test')->max('price');
//==================================


//SELECT STATEMENTS
//select()
// $users = DB::table('test')->select('name','email as usermail')->get();
// dd($users);

//distinct()
// $users = DB::table('test')->distinct()->get();
// dd($users);

//=====================================

//RAW EXPRESSIONS
// $users = DB::table('test')->select(DB::raw('count(*) as count,active'))->where('active', '<>', 1)->groupBy('active')->get();
// dd($users);
//-----------------------
// $ords = DB::table('test')->select('department',DB::raw('SUM(price) as total'))->groupBy('department')->havingRaw('SUM(price) > ?',[2])->get();
// dd($ords);
//----------------------
$users = DB::table('test')->selectRaw('name as Username,email')->whereRaw('price > ?',5)->get();
dd($users);



});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
