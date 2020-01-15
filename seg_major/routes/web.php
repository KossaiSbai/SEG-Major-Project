<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| For the documentation , check out the docs/routes.html and open it in a browser.
|
*/


Route::get('/',function ()
{
    return redirect(route('login'));
});


Auth::routes();
Route::get('/home', 'ContentsController@home')->name('home');



Route::get('/tests/allTestUnder', 'PatientController@allTestUnder12')->name('allTestUnder');
Route::get('/tests/allTestOver', 'PatientController@allTestOver12')->name('allTestOver');
Route::get('/tests/allTestComplex', 'PatientController@allTestComplex')->name('allTestComplex');
Route::get('/bloodtests', 'PatientController@bloodTests')->name('tests');
Route::post('/bloodtests/modify/{patient_id}{page}', 'PatientController@changeTestDate')->name('changeTestDate');
Route::get('/bloodtests/show/{patient_id}{page}','PatientController@showTestDate')->name('showTestDate');

Route::get('/patients', 'PatientController@allPatients')->name('patients');
Route::get('/patients/under12', 'PatientController@allPatientsUnder12')->name('patients<12');
Route::get('/patients/over12', 'PatientController@allPatientsOver12')->name('patients>12');
Route::get('/patients/complex', 'PatientController@filterComplex')->name('complex_patients');
Route::get('/patients/overdue/under12', 'PatientController@overdueUnder')->name('overdueUnder');
Route::get('/patients/overdue/over12', 'PatientController@overdueOver')->name('overdueOver');
Route::get('/patients/overdue/complex', 'PatientController@filterOverdueComplex')->name('overdueComplex');
Route::post('/patients/test{patient_id}', 'PatientController@setReviewed')->name('review');
Route::post('/patients/tests{patient_id}/received','PatientController@setReceived')->name('receive');
Route::post('/patients/new', 'PatientController@newPatient')->name('create_patient');
Route::get('/patients/new', 'PatientController@newPatient')->name('new_patient');
Route::post('/patients/edit/{patient_id}','PatientController@modify')->name('update_patient');
Route::get('patients/show/{patient_id}','PatientController@show')->name('show_patient');
Route::get('patients/delete/{patient_id}','PatientController@destroy')->name('delete_patient');
Route::patch('/patients/test{patient_id}', 'PatientController@nextDate')->name('next_date');
Route::get('/patients/overdue','PatientController@overdueTests')->name('overdue');

Route::get('/hospitals', 'HospitalController@index')->name('hospitals');
Route::get('/hospital/new','HospitalController@newHospital')->name('new_hospital');
Route::post('/hospital/new','HospitalController@newHospital')->name('create_hospital');
Route::post('/hospital/edit/{hospital_id}','HospitalController@modify')->name('update_hospital');
Route::get('/hospital/show/{hospital_id}', 'HospitalController@show')->name('show_hospital');
Route::get('hospitals/delete/{patient_id}','HospitalController@destroy')->name('delete_hospital');


Route::get('/editCredentials','UserController@showEditCredentialsForm')->name('editCredentials');
Route::post('/updateCredentials','UserController@updateCredentials')->name('updateCredentials');
Route::get('user/delete','UserController@destroy')->name('delete_account');

Route::get('/email/scheduleAppointment{patient_id}','MailController@scheduleAppointment')->name('schedule');
Route::get('/email/notification{patient_id}','MailController@mailNotification')->name('notification');
Route::get('/email/missedAppointment{patient_id}','MailController@reschedule')->name('reschedule');

