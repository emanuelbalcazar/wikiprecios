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

$route['altaComercioAdm'] = "Commerce_controller/register_trade_as_administrator";
$route["productoEspecial"] = "Special_product_controller/items_view";
$route["ImportarCsv"] = "Price_controller/register_massive_price";
$route["CargarCsv"] = "CsvController/importcsv";

/* ------------------------- Rutas de servicios  -------------------------- */
$route['default_controller'] = "Login_web_controller/load_login_view";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// rutas asociadas a usuarios.
$route['api/usuario/registrar'] = "API/User_controller/register";
$route['api/usuario/login'] = "API/User_controller/login";
$route['api/usuario/cambiar_clave'] = "API/User_controller/change_password";
$route['api/usuario/eliminar_cuenta'] = "API/User_controller/delete_account";

// rutas asociadas a comercios.
$route['api/comercio/registrar'] = "API/Commerce_controller/register";
$route['api/comercios'] = "API/Commerce_controller/businesses";
$route['api/comercios/favoritos'] = "API/Commerce_controller/favorites";
$route['api/comercios/cercanos'] = "API/Commerce_controller/nearby_businesses";

$route['registrar_favoritos'] = "mobile/Favorite_controller/register_favorite_trade";

$route['registrar_producto_especial'] = "mobile/Special_product_controller/register_category";
$route['categorias_rubro'] = "mobile/Special_product_controller/get_categories_of_items";
$route['registrar_rubro'] = "mobile/Item_controller/register_item";
$route['rubros'] = "mobile/Special_product_controller/get_items";

$route['registrar_precio'] = "mobile/Price_controller/register_price";
$route['precio_sugerido'] = "mobile/Price_controller/get_possible_prices";

/* ------------------------- Rutas de servicios web -------------------------- */

$route['menu_login_administrador'] = "Login_web_controller/load_login_view";
$route['login_administrador'] = "Login_web_controller/login";
$route['menu_administrador'] = "Login_web_controller/menu";
$route['menu_recuperar_clave'] = "Login_web_controller/load_reset_password_view";
$route['recuperar_clave'] = "Login_web_controller/reset_password";
$route['cerrar_sesion'] = "Login_web_controller/logout";

$route['menu_desactivar_cuenta'] = "Administrator_account_controller/load_delete_account_view";
$route['desactivar_cuenta'] = "Administrator_account_controller/delete_account";
$route['menu_cambiar_clave'] = "Administrator_account_controller/load_change_password_view";
$route['cambiar_clave_admin'] = "Administrator_account_controller/change_password";

$route['menu_precios_masivos'] = "Price_web_controller/load_masive_price_view";
$route['precios_masivos'] = "Price_web_controller/load_masive_price";

$route['menu_nuevo_comercio'] = "Commerce_web_controller/load_commerce_view";
$route['nuevo_comercio'] = "Commerce_web_controller/load_commerce";

$route['menu_comercios_masivos'] = "Commerce_web_controller/load_masive_businesses_view";
$route['comercios_masivos'] = "Commerce_web_controller/load_masive_businesses";

$route['menu_nuevo_producto_especial'] = "Special_product_web_controller/load_special_product_view";
$route['nuevo_producto_especial'] = "Special_product_web_controller/load_special_product";
$route['menu_productos_especiales_masivos'] = "Special_product_web_controller/load_masive_special_products_view";
$route['productos_especiales_masivos'] = "Special_product_web_controller/load_masive_special_products";

$route['menu_nuevo_rubro'] = "Item_web_controller/load_item_view";
$route['nuevo_rubro'] = "Item_web_controller/load_item";
$route['menu_listar_rubros'] = "Item_web_controller/load_list_items_view";
$route['buscar_rubro'] = "Item_web_controller/search_item";



/* -------------------------- Rutas de Testing ----------------------------- */
$route['test_user'] = "test/Test_user_model/test";
$route['test_commerce'] = "test/Test_commerce_model/test";
$route['test_favorite'] = "test/Test_favorite_model/test";
$route['test_item'] = "test/Test_item_model/test";
$route['test_category'] = "test/Test_category_model/test";
$route['test_special_product'] = "test/Test_special_product_model/test";
$route['test_product'] = "test/Test_product_model/test";

$route['testPrice'] = "test/Test_price_model/test";

/* ------------------------ Ruta de Migraciones ---------------------------- */
$route['migrate'] = "migrations/Migrate/run";

/* --------------------------- Ruta de Seeds ------------------------------- */
$route['seeds'] = "seeds/Seeder/run";
