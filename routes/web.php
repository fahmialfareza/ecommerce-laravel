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

Route::get('/', 'FrontController@index')->name('home');
Route::get('/shirts', 'FrontController@shirts')->name('shirts');
Route::get('/category/{category}', 'FrontController@category')->name('shirt.category');
Route::get('/shirt/{id}', 'FrontController@shirt')->name('shirt');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index');
Route::resource('/cart', 'CartController');
Route::get('/cart/add-item/{id}', 'CartController@addItem')->name('cart.addItem');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function() {
  Route::post('toggledeliver/{orderId}', 'OrderController@toggledeliver')->name('toggle.deliver');

  Route::get('/', function() {
    return view('admin.index');
})->name('admin.index');

  Route::resource('product', 'ProductsController');
  Route::resource('category', 'CategoriesController');

  Route::get('orders/{type?}', 'OrderController@orders');
});


// Route::get('checkout', 'CheckoutController@step1');
Route::group(['middleware' => 'auth'], function()
{
  Route::get('shipping-info', 'CheckoutController@shipping')->name('checkout.shipping');
  Route::get('payment', 'CheckoutController@payment')->name('checkout.payment');

});

Route::post('orderconfirmation', 'OrderController@orderconfirmation')->name('order.confirmation');
Route::resource('address', 'AddressController');
Route::post('store-payment', 'CheckoutController@storePayment')->name('payment.store');

Route::get('test', function()
{
  $orders = App\Order::find(2);
  $new = $orders->orderItems;

  return response()->json($new);
});
