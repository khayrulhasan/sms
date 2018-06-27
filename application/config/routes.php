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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route[LOGIN_PAGE] = 'login/index';

$route['dashboard/admin'] = 'admin';
$route['dashboard/teacher'] = 'teacher';

$route['dashboard/booklist'] = 'booklist/index';
$route['dashboard/booklist/manage'] = 'booklist/manage';
$route['dashboard/booklist/update/(:any)'] = 'booklist/update/$1';
$route['dashboard/booklist/delete/(:any)'] = 'booklist/delete/$1';

$route['dashboard/teachers'] = 'teachers/index';
$route['dashboard/teachers/manage'] = 'teachers/manage';
$route['dashboard/teachers/update/(:any)'] = 'teachers/update/$1';
$route['dashboard/teachers/delete/(:any)'] = 'teachers/delete/$1';

$route['dashboard/student'] = 'student/index';
$route['dashboard/student/manage'] = 'student/manage';
$route['dashboard/student/update/(:any)'] = 'student/update/$1';
$route['dashboard/student/delete/(:any)'] = 'student/delete/$1';
// Student frontend
$route['frontend/panel/student'] = 'frontend/student/index';
$route['frontend/panel/student/notice'] = 'frontend/student/notice';
$route['frontend/panel/student/marksheet'] = 'frontend/student/marksheet';
$route['frontend/panel/student/booklist'] = 'frontend/student/booklist';

$route['dashboard/notice'] = 'notice/index';
$route['dashboard/notice/manage'] = 'notice/manage';
$route['dashboard/notice/update/(:any)'] = 'notice/update/$1';
$route['dashboard/notice/delete/(:any)'] = 'notice/delete/$1';

$route['dashboard/users/insert-user'] = 'users';
$route['dashboard/users/manage-user'] = 'users/manage_user';
$route['dashboard/users/delete/:num'] = 'users/delete';
$route['dashboard/users/update/:num'] = 'users/update';
$route['dashboard/users/add-user'] = 'users/add_user';
$route['dashboard/users/change-password'] = 'users/change_password';
$route['dashboard/users/update-password'] = 'users/update_password';

$route['dashboard/class'] = 'classes/index';
$route['dashboard/class/add'] = 'classes/add';
$route['dashboard/class/manage'] = 'classes/manage';
$route['dashboard/class/update/(:any)'] = 'classes/update/$1';
$route['dashboard/class/delete/(:any)'] = 'classes/delete/$1';

// options
$route['dashboard/options'] = 'options/index';
$route['dashboard/options/update_options'] = 'options/update_options';

// attendance
$route['dashboard/attendance'] = 'attendance/index';
$route['dashboard/attendance/attendance_sheet/(:any)/(:any)'] = 'attendance/attendance_sheet/$1/$2';
$route['dashboard/attendance/make'] = 'attendance/make/';

// Marksheet
$route['dashboard/marksheet'] = 'marksheet/index';
$route['dashboard/marksheet/add-marksheet'] = 'marksheet/make_marksheet';
$route['dashboard/marksheet/make'] = 'marksheet/make/';
$route['dashboard/marksheet/update'] = 'marksheet/add_update_marksheet';
$route['dashboard/marksheet/marks-distribution'] = 'marksheet/marks_distribution';

// grade
$route['dashboard/grade-mark'] = 'grade/index';
$route['dashboard/grade/grade_sheet/(:any)/(:any)'] = 'grade/grade_sheet/$1/$2';
$route['dashboard/grade/make'] = 'grade/make/';

// profile
$route['dashboard/profile'] = 'profile/index';
$route['dashboard/profile/upload'] = 'profile/upload';
$route['dashboard/profile/add_profile'] = 'profile/add_profile';

//For Menus
$route['dashboard/menus/manage-menus'] = 'menus/manage_menus';
$route['dashboard/menus/get_parent_page'] = 'menus/get_parent_page';
$route['dashboard/menus/delete/:num'] = 'menus/delete';
$route['dashboard/menus/update/:num'] = 'menus/update';

//For pages
$route['dashboard/pages/insert-page'] = 'pages';
$route['dashboard/pages/manage-page'] = 'pages/manage_pages';
$route['dashboard/pages/delete/:num'] = 'pages/delete';
$route['dashboard/pages/update/:num'] = 'pages/update';
$route['dashboard/pages/add-page'] = 'pages/add_page';

// frontend
$route['frontend/pages/(:any)'] = 'frontend/pages/index/$1';
$route['frontend/notices/:num'] = 'frontend/notices/index/$1';
$route['frontend/news-event/:num'] = 'frontend/news_events/index/$1';

//for Sliders
$route['dashboard/sliders'] = 'sliders/index';
$route['dashboard/sliders/insert-slider'] = 'sliders/index';
$route['dashboard/sliders/manage-sliders'] = 'sliders/manage_sliders';
$route['dashboard/sliders/update/(:any)'] = 'sliders/update/$1';
$route['dashboard/sliders/delete/(:any)'] = 'sliders/delete/$1';

//for News and event
$route['dashboard/news-event'] = 'news_event/index';
$route['dashboard/news-event/insert-news-event'] = 'news_event/index';
$route['dashboard/news-event/manage-news-events'] = 'news_event/manage_news_events';
$route['dashboard/news-event/update/(:any)'] = 'news_event/update/$1';
$route['dashboard/news-event/delete/(:any)'] = 'news_event/delete/$1';

//for Message
$route['dashboard/message'] = 'news_event/index';
$route['dashboard/message/insert-message'] = 'message/index';
$route['dashboard/message/manage-message'] = 'message/manage_message';
$route['dashboard/message/update/(:any)'] = 'message/update/$1';
$route['dashboard/message/delete/(:any)'] = 'message/delete/$1';

// media
$route['dashboard/media/index'] = 'media/index';
$route['dashboard/media/index/:num'] = 'media/index/$1';
$route['dashboard/media/library'] = 'media/index';
$route['dashboard/media/library/:num'] = 'media/index/$1';
$route['dashboard/media/library/:num/:num'] = 'media/index/$1/$2';
$route['dashboard/media/library/delete/:any'] = 'media/delete';

$route['dashboard/schedule/show-schedule'] = 'schedule/index';