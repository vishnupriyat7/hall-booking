<?php

use App\Http\Controllers\Admin\VisitorPassControllerCustom;

Route::redirect('/', 'admin');
Route::redirect('/pubregister_visitor', 'public/self-registrations/create_visitor');
Route::redirect('/pubregister_gallery', 'public/self-registrations/create_gallery');
Auth::routes(['register' => false]);

// Route::get('api/pindetails/{pincode}', [VisitorPassControllerCustom::class, 'fetchPinDetails']);


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Person
    Route::delete('people/destroy', 'PersonController@massDestroy')->name('people.massDestroy');
    Route::post('people/media', 'PersonController@storeMedia')->name('people.storeMedia');
    Route::post('people/ckmedia', 'PersonController@storeCKEditorImages')->name('people.storeCKEditorImages');
    Route::resource('people', 'PersonController');

    // Id Types
    Route::delete('id-types/destroy', 'IdTypesController@massDestroy')->name('id-types.massDestroy');
    Route::post('id-types/parse-csv-import', 'IdTypesController@parseCsvImport')->name('id-types.parseCsvImport');
    Route::post('id-types/process-csv-import', 'IdTypesController@processCsvImport')->name('id-types.processCsvImport');
    Route::resource('id-types', 'IdTypesController', ['except' => ['show']]);

    // Visitor Pass
    Route::get('visitor-passes/print/{id}', 'VisitorPassControllerCustom@print')->name('visitor-passes.print');;
    Route::get('visitor-passes/register', 'VisitorPassControllerCustom@register')->name('visitor-passes.register');;
    Route::resource('visitor-passes', 'VisitorPassController', ['except' => ['destroy']]);

    // Visiting Office Category
    Route::delete('visiting-office-categories/destroy', 'VisitingOfficeCategoryController@massDestroy')->name('visiting-office-categories.massDestroy');
    Route::post('visiting-office-categories/parse-csv-import', 'VisitingOfficeCategoryController@parseCsvImport')->name('visiting-office-categories.parseCsvImport');
    Route::post('visiting-office-categories/process-csv-import', 'VisitingOfficeCategoryController@processCsvImport')->name('visiting-office-categories.processCsvImport');
    Route::resource('visiting-office-categories', 'VisitingOfficeCategoryController');

    // Recommending Office Category
    Route::delete('recommending-office-categories/destroy', 'RecommendingOfficeCategoryController@massDestroy')->name('recommending-office-categories.massDestroy');
    Route::post('recommending-office-categories/parse-csv-import', 'RecommendingOfficeCategoryController@parseCsvImport')->name('recommending-office-categories.parseCsvImport');
    Route::post('recommending-office-categories/process-csv-import', 'RecommendingOfficeCategoryController@processCsvImport')->name('recommending-office-categories.processCsvImport');
    Route::resource('recommending-office-categories', 'RecommendingOfficeCategoryController');

    // Member
    Route::delete('members/destroy', 'MemberController@massDestroy')->name('members.massDestroy');
    Route::post('members/parse-csv-import', 'MemberController@parseCsvImport')->name('members.parseCsvImport');
    Route::post('members/process-csv-import', 'MemberController@processCsvImport')->name('members.processCsvImport');
    Route::resource('members', 'MemberController');

    // Gallery Pass
    Route::get('gallery-passes/print/{id}', 'GalleryPassControllerCustom@print')->name('gallery-passes.print');;
    Route::get('gallery-passes/register', 'GalleryPassControllerCustom@register')->name('gallery-passes.register');;
      Route::resource('gallery-passes', 'GalleryPassController', ['except' => ['destroy']]);

    // Group Person
    Route::delete('group-people/destroy', 'GroupPersonController@massDestroy')->name('group-people.massDestroy');
    Route::resource('group-people', 'GroupPersonController');

    // Country
    Route::delete('countries/destroy', 'CountryController@massDestroy')->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', 'CountryController@parseCsvImport')->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', 'CountryController@processCsvImport')->name('countries.processCsvImport');
    Route::resource('countries', 'CountryController');

    // Guiding Officer
    Route::delete('guiding-officers/destroy', 'GuidingOfficerController@massDestroy')->name('guiding-officers.massDestroy');
    Route::resource('guiding-officers', 'GuidingOfficerController');

    // Locker
    Route::delete('lockers/destroy', 'LockerController@massDestroy')->name('lockers.massDestroy');
    Route::resource('lockers', 'LockerController');

    // Locker Item
    Route::delete('locker-items/destroy', 'LockerItemController@massDestroy')->name('locker-items.massDestroy');
    Route::resource('locker-items', 'LockerItemController');

    // Locker Token
    Route::delete('locker-tokens/destroy', 'LockerTokenController@massDestroy')->name('locker-tokens.massDestroy');
    Route::resource('locker-tokens', 'LockerTokenController');

    // State
    Route::delete('states/destroy', 'StateController@massDestroy')->name('states.massDestroy');
    Route::post('states/parse-csv-import', 'StateController@parseCsvImport')->name('states.parseCsvImport');
    Route::post('states/process-csv-import', 'StateController@processCsvImport')->name('states.processCsvImport');
    Route::resource('states', 'StateController');

    // District
    Route::delete('districts/destroy', 'DistrictController@massDestroy')->name('districts.massDestroy');
    Route::post('districts/parse-csv-import', 'DistrictController@parseCsvImport')->name('districts.parseCsvImport');
    Route::post('districts/process-csv-import', 'DistrictController@processCsvImport')->name('districts.processCsvImport');
    Route::resource('districts', 'DistrictController');

    // Post Office Details
    Route::delete('post-office-details/destroy', 'PostOfficeDetailsController@massDestroy')->name('post-office-details.massDestroy');
    Route::post('post-office-details/parse-csv-import', 'PostOfficeDetailsController@parseCsvImport')->name('post-office-details.parseCsvImport');
    Route::post('post-office-details/process-csv-import', 'PostOfficeDetailsController@processCsvImport')->name('post-office-details.processCsvImport');
    Route::resource('post-office-details', 'PostOfficeDetailsController');

    // Session
    Route::delete('sessions/destroy', 'SessionController@massDestroy')->name('sessions.massDestroy');
    Route::resource('sessions', 'SessionController');


    //  // Self Registration
 Route::get('self-registrations/search', 'SelfRegistrationController@search')->name('self-registrations.search');
 Route::delete('self-registrations/destroy', 'SelfRegistrationController@massDestroy')->name('self-registrations.massDestroy');
 Route::post('self-registrations/media', 'SelfRegistrationController@storeMedia')->name('self-registrations.storeMedia');
 Route::post('self-registrations/ckmedia', 'SelfRegistrationController@storeCKEditorImages')->name('self-registrations.storeCKEditorImages');
 Route::resource('self-registrations', 'SelfRegistrationController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Person
    Route::delete('people/destroy', 'PersonController@massDestroy')->name('people.massDestroy');
    Route::post('people/media', 'PersonController@storeMedia')->name('people.storeMedia');
    Route::post('people/ckmedia', 'PersonController@storeCKEditorImages')->name('people.storeCKEditorImages');
    Route::resource('people', 'PersonController');

    // Id Types
    Route::delete('id-types/destroy', 'IdTypesController@massDestroy')->name('id-types.massDestroy');
    Route::resource('id-types', 'IdTypesController', ['except' => ['show']]);

    // Visitor Pass
    Route::resource('visitor-passes', 'VisitorPassController', ['except' => ['destroy']]);

    // Visiting Office Category
    Route::delete('visiting-office-categories/destroy', 'VisitingOfficeCategoryController@massDestroy')->name('visiting-office-categories.massDestroy');
    Route::resource('visiting-office-categories', 'VisitingOfficeCategoryController');

    // Recommending Office Category
    Route::delete('recommending-office-categories/destroy', 'RecommendingOfficeCategoryController@massDestroy')->name('recommending-office-categories.massDestroy');
    Route::resource('recommending-office-categories', 'RecommendingOfficeCategoryController');

    // Member
    Route::delete('members/destroy', 'MemberController@massDestroy')->name('members.massDestroy');
    Route::resource('members', 'MemberController');


    
    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
//////////////
Route::group(['prefix' => 'public', 'as' => 'public.', 'namespace' => 'Public'], function () {
    //Route::get('/home', 'HomeController@index')->name('home');
    // Self Registration
    Route::delete('self-registrations/destroy', 'SelfRegistrationController@massDestroy')->name('self-registrations.massDestroy');
    Route::post('self-registrations/media', 'SelfRegistrationController@storeMedia')->name('self-registrations.storeMedia');
    Route::post('self-registrations/ckmedia', 'SelfRegistrationController@storeCKEditorImages')->name('self-registrations.storeCKEditorImages');
    //Route::resource('self-registrations', 'SelfRegistrationController');
    Route::get('self-registrations/create_visitor', 'SelfRegistrationController@create_visitor');
    Route::get('self-registrations/create_gallery', 'SelfRegistrationController@create_gallery');

    Route::post('self-registrations/store_visitor', 'SelfRegistrationController@store_visitor')->name('self-registrations.store_visitor');;
    Route::post('self-registrations/store_gallery', 'SelfRegistrationController@store_gallery')->name('self-registrations.store_gallery');;

});
