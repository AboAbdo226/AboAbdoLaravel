<?php
// use App\Models\products; to pring it right away as *1
use App\Http\Controllers\ProductCTR;
use App\Http\Controllers\CommentCTR;
use App\Http\Controllers\AuthCTR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get("/all-products",function(){
//     return products::all();
// });


// Route::post("/add-product",function(){           /*1
//     return products::create([
//             'name' => 'test',
//             'type' => 'elec',
//             'quantity' => '55',
//             'price' => '33.33',
//             'contact' => '09213',
            
//     ]);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




/**
 * Route::resourse('product',['produuct.class'])   /// it will route with automatically way .. so get => show() ... post => store() .. etc
 */


Route::get('test/{did?}',function($id = 6){
           return $id;});

// ================== search ====================


      
Route::post('search-product',
            [ProductCTR::class,
                                'searchProduct']);      
                           
///============== registration ==============

Route::post('register',
            [AuthCTR::class,
                            'register']);

Route::post('login',
            [AuthCTR::class,
                            'login']);
  

/// ============= authenticated calls =============

// Route::middleware(['first', 'second'])->group(function () {
// Route::get('/', function () {
// });
// Route::get('/user/profile', function () {
// });
// });

Route::group(['middleware' => ['auth:sanctum']] , function(){

    Route::get('all-products',
            [ProductCTR::class,
                                'index']);

    Route::post('add-product',
            [ProductCTR::class,
                                'store']); 

    Route::put('edit-product/{id}',
            [ProductCTR::class,
                                'update']);

    Route::delete('del-product/{id}',
            [ProductCTR::class,
                                'destroy']);

    Route::get('logout',
            [AuthCTR::class,
                                'logout']);

    Route::post('add-comment',
            [CommentCTR::class,
                                'addComment']);

    Route::get('product/{id}',
            [ProductCTR::class,
                                'show']);  /// i can use this for all difrrent routs , but i want to change their default names


    Route::get('search-product-name/{name}',
            [ProductCTR::class,
                                'searchByName']);


    Route::post('search-product-expired',
            [ProductCTR::class,
                                'searchByExpirationDate']); 

                                
    Route::post('search-product-catagory',
            [ProductCTR::class,
                                'searchByCatagory']);


    Route::get('can-i-edit-comment/{id}',
            [CommentCTR::class,
                                'canIEditComment']);

    Route::put('edit-comment/{id}',
            [CommentCTR::class,
                                'editComment']);
                                
   Route::get('delete-comment/{id}',
            [CommentCTR::class,
                                'deleteComment']);

    Route::get('like-product/{id}',
            [ProductCTR::class,
                                'like']); 

    Route::get('all-user-products',
            [ProductCTR::class,
                                'showAllUserProducts']);

    Route::get('show-comments/{id}',
            [CommentCTR::class,
                                'showComments']);                                                                                                                          
});