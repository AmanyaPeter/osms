<?php
/** @var App\Core\Router $router */

$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/login', 'AuthController@loginForm');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/logout', 'AuthController@logout');

// Student Routes
$router->add('GET', '/students', 'StudentController@index');
$router->add('GET', '/students/create', 'StudentController@create');
$router->add('POST', '/students/store', 'StudentController@store');
$router->add('GET', '/students/show/{id}', 'StudentController@show');
$router->add('GET', '/students/edit/{id}', 'StudentController@edit');
$router->add('POST', '/students/update/{id}', 'StudentController@update');
$router->add('GET', '/students/delete/{id}', 'StudentController@delete');

// Staff Routes
$router->add('GET', '/staff', 'StaffController@index');
$router->add('GET', '/staff/create', 'StaffController@create');
$router->add('POST', '/staff/store', 'StaffController@store');

// Course Routes
$router->add('GET', '/courses', 'CourseController@index');
$router->add('GET', '/courses/create', 'CourseController@create');
$router->add('POST', '/courses/store', 'CourseController@store');

// Assessment & Attendance Routes
$router->add('GET', '/assessments', 'AssessmentController@index');
$router->add('GET', '/attendance/mark/{course_id}', 'AssessmentController@markAttendance');
$router->add('POST', '/attendance/store/{course_id}', 'AssessmentController@storeAttendance');
$router->add('GET', '/assessments/course/{course_id}', 'AssessmentController@enterGrades');

// Finance Routes
$router->add('GET', '/finance', 'FinanceController@index');
$router->add('GET', '/finance/payment', 'FinanceController@recordPaymentForm');
$router->add('POST', '/finance/payment', 'FinanceController@storePayment');
$router->add('GET', '/finance/defaulters', 'FinanceController@defaultersReport');
