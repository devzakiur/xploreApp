<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'auth/login';
$route['404_override'] = 'custom404';
$route['translate_uri_dashes'] = FALSE;

/**
 * administrator route
 */
$route['module'] = 'administrator/module';
$route['module/mlist'] = 'administrator/module/mlist';
$route['role-permission'] = 'administrator/role';
$route['manage-user'] = 'administrator/users';
//$route['users'] = 'users/UsersController/index';
//$route['users/view'] = 'users/UsersController/view';
$route['user/control/(:num)'] = 'users/Users/control/$1';
$route['user/delete/(:num)'] = 'users/Users/delete/$1';

/**
 * Api Route
 */
$route['user/login'] = 'api/UserController/login';
$route['user/logout'] = 'api/UserController/logout';
$route['user/register'] = 'api/UserController/register';
$route['user/email-verification'] = 'api/UserController/email_verification';
$route['user/email-resend'] = 'api/UserController/email_resend';
$route['user/profile-setup'] = 'api/UserController/profile_setup';
$route['user/phone-verification'] = 'api/UserController/phone_verification';
$route['user/phone-resend'] = 'api/UserController/phone_resend';
$route['user/toc'] = 'api/UserController/terms_condition';
$route['user/category-setup'] = 'api/UserController/category_setup';
$route['user/device-info'] = 'api/UserController/device_info';

$route['category-list'] = 'api/AuthController/categry_list';
$route['subject-by-category'] = 'api/AuthController/subject_by_category';

//question

$route['question-list'] = 'api/ContentController/get_question_list';
$route['get-section-by-subject'] = 'api/ContentController/get_section_by_subject';
$route['get-topic-by-section'] = 'api/ContentController/get_topic_by_section';
$route['question/reports'] = 'api/ContentController/question_reports';
$route['question/bookmark'] = 'api/ContentController/question_bookmark';
$route['question/unbookmark'] = 'api/ContentController/question_unbookmark';
$route['question-add'] = 'api/ContentController/user_question_add';
$route['get-all-favourite-question'] = 'api/ContentController/get_all_favourite_question';

//library
$route['library-data'] = 'api/ContentController/get_library';
$route['recently-learn'] = 'api/ContentController/get_recently_learn';
$route['most-popular'] = 'api/ContentController/get_most_popular';

//game/challenge
$route['game-challenge'] = 'api/GameController/game_challenge';
$route['game-question'] = 'api/GameController/get_game_question';
$route['game-finish'] = 'api/GameController/game_finish';
$route['subject-performance'] = 'api/GameController/get_subject_performance';
$route['game-result-summary'] = 'api/GameController/game_result_summary';
$route['game-performance-summary'] = 'api/GameController/performance_summary';
$route['performance-history'] = 'api/GameController/performance_history';
$route['get-game-solution'] = 'api/GameController/get_game_solution';



//password change
$route['forgot-password'] = 'api/PasswordController/forgot_password';
$route['code-verification'] = 'api/PasswordController/reset_code_verification';
$route['change-password'] = 'api/PasswordController/change_password';


$route['get-content'] = 'api/AuthController/content';
$route['get-batch'] = 'api/AuthController/batch_list';

$route['game-subject-section-topic'] = 'api/AuthController/game_subject_section_topic';

/**
 * news route
 */
$route['get-news-category'] = 'api/NewsController/get_news_category';
$route['get-news-list'] = 'api/NewsController/get_news_list';

/**
 * find_us
 */
$route['find-us'] = 'api/ContactController/find_us';
/**
 * contact us
 */

$route['contact-us'] = 'api/ContactController/contact_us';
/**
 * invive friends
 */
$route['invite-friends'] = 'api/ContactController/invite_friends';

//social login

$route['facebook-login'] = 'api/UserController/fb_social_login';
$route['google-login'] = 'api/UserController/google_social_login';

//get server time
$route['server-time'] = 'api/UserController/get_time';

//get model test

$route['check-model-test'] = 'api/ModelTestController/check_model_test';
$route['model-test-register'] = 'api/ModelTestController/model_test_register';

//getnotification
$route['get-all-notification'] = 'api/NotificationController/get_notification';

//loaderboard

$route['get-played-model-test'] = 'api/ModelTestController/get_model_test';
$route['get-leaderboard'] = 'api/ModelTestController/get_leaderboard';