<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* ------------------------- Rutas de servicios rest  -------------------------- */
$route['default_controller'] = "Welcome/index";
// $route['default_controller'] = "Login_controller/index";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// rutas de utileria
$route['api/info']['GET'] = "API/Utils_controller/version";
$route['api/echo']['POST'] = "API/Utils_controller/echo";

// rutas asociadas a usuarios.
$route['api/usuario/login']['POST'] = "API/Account_controller/login";
$route['api/usuario/cambiar_clave']['POST'] = "API/Account_controller/change_password";
$route['api/usuario/eliminar_cuenta']['POST'] = "API/Account_controller/delete_account";
$route['api/usuario/login_facebook']['POST'] = 'API/User_controller/login_facebook';


$route['api/usuario/registrar']['POST'] = "API/User_controller/create";
$route['api/usuario/(:num)']['GET'] = 'API/User_controller/findById/$1';
$route['api/usuarios']['GET'] = 'API/User_controller/findAll';


// rutas asociadas a comercios.
$route['api/comercio/registrar']['POST'] = "API/Commerce_controller/register";
$route['api/comercios']['GET'] = "API/Commerce_controller/businesses";
$route['api/comercios/favoritos']['GET'] = "API/Commerce_controller/favorites";
$route['api/comercios/cercanos']['GET'] = "API/Commerce_controller/nearby_businesses";
$route['api/comercios/(:num)']['DELETE'] = "API/Commerce_controller/delete/$1";

// rutas asociadas a comercios favoritos.
$route['api/favorito/registrar']['POST'] = "API/Favorite_controller/register";

// rutas asociadas a categorias de productos y rubros.
$route['api/categorias']['GET'] = "API/Special_product_controller/categories";
$route['api/categoria/registrar']['POST'] = "API/Special_product_controller/register";
$route['api/categorias/(:num)']['DELETE'] = "API/Special_product_controller/delete_category/$1";

$route['api/rubro/categorias']['GET'] = "API/Special_product_controller/get_categories_of_items";
$route['api/rubros']['GET'] = "API/Special_product_controller/get_items";

$route['api/rubro/registrar']['POST'] = "API/Item_controller/register";
$route['api/rubro/(:num)']['DELETE'] = "API/Item_controller/delete/$1";
$route['api/rubro/(:num)']['POST'] = "API/Item_controller/update/$1";

// rutas asociadas a precios de productos.
$route['api/precio/registrar']['POST'] = "API/Price_controller/register";
$route['api/precio/sugerido']['GET'] = "API/Price_controller/get_possible_prices";
$route['api/precios']['GET'] = "API/Price_controller/findAll";
$route['api/precios/calculados']['GET'] = "API/Price_controller/calculated_prices";

/* ------------------------- Rutas de servicios web --------------------------- */
$route['api/admin/login']['POST'] = "ADMIN/Login_controller/login";
$route['api/admin/password/reset']['POST'] = "ADMIN/Forgot_password_controller/reset";
$route['api/admin/password/change']['POST'] = "ADMIN/Account_controller/change_password";
$route['api/admin/logout']['POST'] = "ADMIN/Account_controller/logout";
$route['api/admin/session']['GET'] = "ADMIN/Account_controller/session";

$route['api/admin/prices/load']['POST'] = "ADMIN/Price_controller/upload";
$route['api/admin/items']['GET'] = "API/Special_product_controller/get_all_items";

/* -------------------------- Rutas de Testing ----------------------------- */
$route['test/user'] = "test/Test_user_model/test";
$route['test/category'] = "test/Test_category_model/test";
$route['test/commerce'] = "test/Test_commerce_model/test";
$route['test/favorite'] = "test/Test_favorite_model/test";
$route['test/item'] = "test/Test_item_model/test";
$route['test/price'] = "test/Test_price_model/test";
$route['test/product'] = "test/Test_product_model/test";
$route['test/special'] = "test/Test_special_product_model/test";

/* ------------------------ Ruta de Migraciones ---------------------------- */
$route['migrate'] = "migrations/Migrate/run";

/* --------------------------- Ruta de Seeds ------------------------------- */
$route['seeds'] = "seeds/Seeder/run";
