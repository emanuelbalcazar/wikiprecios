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
$route['default_controller'] = "Login_controller/index";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// rutas de utileria
$route['api/info']['GET'] = "API/Utils_controller/version";

// rutas asociadas a usuarios.
$route['api/usuario/login']['GET'] = "API/Account_controller/login";
$route['api/usuario/cambiar_clave']['GET'] = "API/Account_controller/change_password";
$route['api/usuario/eliminar_cuenta']['GET'] = "API/Account_controller/delete_account";

$route['api/usuario/registrar']['GET'] = "API/User_controller/create";

// rutas asociadas a comercios.
$route['api/comercio/registrar'] = "API/Commerce_controller/register";
$route['api/comercios'] = "API/Commerce_controller/businesses";
$route['api/comercios/favoritos'] = "API/Commerce_controller/favorites";
$route['api/comercios/cercanos'] = "API/Commerce_controller/nearby_businesses";

// rutas asociadas a comercios favoritos.
$route['api/favorito/registrar'] = "API/Favorite_controller/register";

// rutas asociadas a categorias de productos y rubros.
$route['api/categoria/registrar'] = "API/Special_product_controller/register";
$route['api/rubro/categorias'] = "API/Special_product_controller/get_categories_of_items";
$route['api/rubros'] = "API/Special_product_controller/get_items";
$route['api/rubro/registrar'] = "API/Item_controller/register";

// rutas asociadas a precios de productos.
$route['api/precio/registrar'] = "API/Price_controller/register";
$route['api/precio/sugerido'] = "API/Price_controller/get_possible_prices";

/* ------------------------- Rutas de servicios web --------------------------- */
$route['login'] = "Login_controller/index";
$route['recuperar_clave'] = "Forgot_password_controller/index";
$route['home'] = "Home_controller/index";

$route['cerrar_sesion'] = "Account_controller/logout";
$route['desactivar_cuenta'] = "Account_controller/delete";
$route['cambiar_clave'] = "Account_controller/change";

$route['comercios/nuevo'] = "Commerce_controller/new";
$route['comercios/cargar'] = "Commerce_controller/load";

$route['precios/cargar'] = "Price_controller/load";

$route['productos/nuevo'] = "Special_product_controller/new";
$route['productos/cargar'] = "Special_product_controller/load";

$route['comercios/nuevo'] = "Commerce_controller/new";

$route['rubros/nuevo'] = "Item_controller/new";
// $route['nuevo_rubro'] = "Item_web_controller/load_item";
// $route['menu_listar_rubros'] = "Item_web_controller/load_list_items_view";
// $route['buscar_rubro'] = "Item_web_controller/search_item";

/* -------------------------- Rutas de Testing ----------------------------- */
$route['test/user'] = "test/Test_user_model/test";
//$route['test_commerce'] = "test/Test_commerce_model/test";
//$route['test_favorite'] = "test/Test_favorite_model/test";
//$route['test_item'] = "test/Test_item_model/test";
//$route['test_category'] = "test/Test_category_model/test";
//$route['test_special_product'] = "test/Test_special_product_model/test";
//$route['test_product'] = "test/Test_product_model/test";
//$route['testPrice'] = "test/Test_price_model/test";

/* ------------------------ Ruta de Migraciones ---------------------------- */
$route['migrate'] = "migrations/Migrate/run";

/* --------------------------- Ruta de Seeds ------------------------------- */
$route['seeds'] = "seeds/Seeder/run";
