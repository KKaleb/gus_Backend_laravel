<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "Hi";
});


$router->group(['prefix' => 'gus/api'], function () use ($router) {
    //authenticated routes
    $router->group(['prefix' => 'admin', 'middleware' => ['auth']], function () use ($router) {
        $router->post('validate/token', 'NewAdminController@validateToken');
        $router->get('data/count', 'NewAdminController@dataCount');
        $router->get('view/applicants', 'NewAdminController@viewApplicants');
        $router->get('view/applicants/pending', 'NewAdminController@viewPendingApplicants');
        $router->get('view/applicants/accepted', 'NewAdminController@viewAcceptedApplicants');
        $router->get('view/applicants/rejected', 'NewAdminController@viewRejectedApplicants');
        $router->get('show/applicant/{id}', 'NewAdminController@showApplicant');
        $router->get('watch/{id}', 'NewAdminController@watchApplicantVideo');
        $router->get('accept/applicant/{id}', 'NewAdminController@acceptApplicant');
        $router->get('reject/applicant/{id}', 'NewAdminController@rejectApplicant');
        $router->post('applicant/filter', 'NewAdminController@applicantFilter');
        $router->post('upload/barcode', 'NewAdminController@uploadBarcode');
        $router->get('show/barcode', 'RegisterController@showBarcodes');
        $router->get('filter/byage/{age}', 'NewAdminController@filterByAge');
        $router->get('filter/byauditionlocation/{location}', 'NewAdminController@filterByAuditionLocation');
        $router->get('filter/bygender/{gender}', 'NewAdminController@filterByGender');
        $router->get('filter/byheight/{height}', 'NewAdminController@filterByHeight');
        $router->post('enrol/applicant/voting', 'NewAdminController@enroleApplicatForVoting');
        $router->post('remove/applicant/voting', 'NewAdminController@unenrolApplicantForVoting');
        $router->get('applicant/barcode', 'RegisterController@applicantBarcode');
        $router->post('select/contestant', 'NewAdminController@selectContestant');
        $router->post('deselect/contestant', 'NewAdminController@deSelectContestant');
        $router->get('list/selected/contestant', 'NewAdminController@displaySelectedContestant');
        $router->get('list/deselected/contestant', 'NewAdminController@displayDeSelectedContestant');
    });
    //unauthenticated routes
    $router->post('register', 'RegisterController@register'); //create user
    $router->post('register/step', 'RegisterController@registerStep');
    $router->post('register/step/two', 'RegisterController@registerStepTwo');
    $router->post('upload/image', 'RegisterController@uploadImage'); //create user
    $router->post('upload/video', 'RegisterController@uploadVideo'); //create user
    $router->post('full/register', 'RegisterController@fullRegister');
    //questions routes
    $router->get('questions', 'QuestionsController@getQuestions'); // get questions
    $router->post('questions/submit', 'QuestionsController@submitQuestions'); // get questions

    //Voting routes
    $router->get('applicants/voting/list', 'VotingController@index');
    $router->get('applicants/highest/votes', 'VotingController@highestVote');
    $router->post('vote', 'VotingController@vote');
    $router->post('verify/code', 'VotingController@verifyCode');
    $router->post('cast/vote', 'VotingController@castVote');
    $router->post('verify/otp', 'VotingController@verify');
    $router->get('vote/count', 'VotingController@getVoteCount');
    $router->post('create/start/date', 'VotingController@createStartDate');
    $router->get('get/date', 'VotingController@getDateTime');

    $router->get('admin/show/barcode', 'RegisterController@showBarcodes');
    $router->get('admin/applicant/barcode', 'RegisterController@applicantBarcode');
    $router->get('admin/applicant/abuja', 'RegisterController@applicantBarcodeAbuja');
    $router->get('admin/applicant/enugu', 'RegisterController@applicantBarcodeEnugu');
    $router->get('admin/applicant/lagos', 'RegisterController@applicantBarcodeLagos');

    //list contestants
    $router->get('contestant/list', 'RegisterController@contestantList');

   //Admin login/logout system
    $router->post('admin/login', 'LoginController@adminLogin'); //admin login user
    $router->post('logout', 'LoginController@logout');//user logout
});
