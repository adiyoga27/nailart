<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//front end 
$route['default_controller'] 			= 'auth';

//profile
$route['profile']						= 'dashboard/profile';
$route['registration']                  = 'auth/registration';

//user
$route['user']							= 'dashboard/user';
$route['user/add']						= 'dashboard/add_user';
$route['user/edit/(:any)']				= 'dashboard/edit_user/$1';
$route['user/delete/(:any)']			= 'dashboard/delete_user/$1';

//akun
$route['akun']							= 'dashboard/akun';
$route['akun/add']						= 'dashboard/add_akun';
$route['akun/edit/(:any)']				= 'dashboard/edit_akun/$1';
$route['akun/delete/(:any)']			= 'dashboard/delete_akun/$1';
$route['akun/(:any)']			= 'dashboard/getAkun/$1';

//produk
$route['produk']						= 'dashboard/produk';
$route['produk/add']					= 'dashboard/add_produk';
$route['produk/edit/(:any)']			= 'dashboard/edit_produk/$1';
$route['produk/delete/(:any)']			= 'dashboard/delete_produk/$1';
$route['api/product/(:any)']			= 'dashboard/getProduct/$1';

//pemasukan
$route['pemasukan']						= 'dashboard/pemasukan';
$route['pemasukan/add']					= 'dashboard/add_pemasukan';
$route['pemasukan/edit/(:any)']			= 'dashboard/edit_pemasukan/$1';
$route['pemasukan/delete/(:any)']		= 'dashboard/delete_pemasukan/$1';
$route['pemasukan/view/(:any)']			= 'dashboard/view_pemasukan/$1';

//pemasukan-lain
$route['pemasukan-lain']				= 'dashboard/pemasukan_lain';
$route['pemasukan-lain/add']			= 'dashboard/add_pemasukan_lain';
$route['pemasukan-lain/edit/(:any)']	= 'dashboard/edit_pemasukan_lain/$1';
$route['pemasukan-lain/delete/(:any)']	= 'dashboard/delete_pemasukan_lain/$1';

//pengeluaran
$route['pengeluaran']					= 'dashboard/pengeluaran';
$route['pengeluaran/add']				= 'dashboard/add_pengeluaran';
$route['pengeluaran/edit/(:any)']		= 'dashboard/edit_pengeluaran/$1';
$route['pengeluaran/delete/(:any)']		= 'dashboard/delete_pengeluaran/$1';



$route['404_override'] 					= 'dashboard/error';
$route['translate_uri_dashes'] 			= FALSE;
