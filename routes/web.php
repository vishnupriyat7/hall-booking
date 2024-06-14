<?php

Route::view('/', 'welcome');
Auth::routes(['register' => false]);

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
    Route::resource('id-types', 'IdTypesController', ['except' => ['show']]);

    // Visitor Pass
    Route::resource('visitor-passes', 'VisitorPassController', ['except' => ['destroy']]);

    // Recommending Office
    Route::delete('recommending-offices/destroy', 'RecommendingOfficeController@massDestroy')->name('recommending-offices.massDestroy');
    Route::resource('recommending-offices', 'RecommendingOfficeController');

    // Visiting Office Category
    Route::delete('visiting-office-categories/destroy', 'VisitingOfficeCategoryController@massDestroy')->name('visiting-office-categories.massDestroy');
    Route::resource('visiting-office-categories', 'VisitingOfficeCategoryController');

    // Visiting Office
    Route::delete('visiting-offices/destroy', 'VisitingOfficeController@massDestroy')->name('visiting-offices.massDestroy');
    Route::resource('visiting-offices', 'VisitingOfficeController');

    // Recommending Office Category
    Route::delete('recommending-office-categories/destroy', 'RecommendingOfficeCategoryController@massDestroy')->name('recommending-office-categories.massDestroy');
    Route::resource('recommending-office-categories', 'RecommendingOfficeCategoryController');

    // Member
    Route::delete('members/destroy', 'MemberController@massDestroy')->name('members.massDestroy');
    Route::post('members/parse-csv-import', 'MemberController@parseCsvImport')->name('members.parseCsvImport');
    Route::post('members/process-csv-import', 'MemberController@processCsvImport')->name('members.processCsvImport');
    Route::resource('members', 'MemberController');
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

    // Recommending Office
    Route::delete('recommending-offices/destroy', 'RecommendingOfficeController@massDestroy')->name('recommending-offices.massDestroy');
    Route::resource('recommending-offices', 'RecommendingOfficeController');

    // Visiting Office Category
    Route::delete('visiting-office-categories/destroy', 'VisitingOfficeCategoryController@massDestroy')->name('visiting-office-categories.massDestroy');
    Route::resource('visiting-office-categories', 'VisitingOfficeCategoryController');

    // Visiting Office
    Route::delete('visiting-offices/destroy', 'VisitingOfficeController@massDestroy')->name('visiting-offices.massDestroy');
    Route::resource('visiting-offices', 'VisitingOfficeController');

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
