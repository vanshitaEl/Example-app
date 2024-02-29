<?php

use App\Enum\Status;
use App\Events\Message;
use App\Models\Doctor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\controllers\PostController;
use App\Http\controllers\CommentController;
use App\Http\controllers\LikeableController;
use App\Http\controllers\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Servant\ServantController;
use App\Enum;
use App\Enum\UserStatus as EnumsUserStatus;
use App\Jobs\TestEmailJob;
use App\Mail\TestMail;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum as RulesEnum;

// use App\Http\controllers\Doctor\RegistarionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::post('send-message',function (Request $request){
//     event(new Message($request->username, $request->message));
//     return ['success' => true];
// });



Route::get('/', function(){
   return view('header');
  });

// Route::get('/Test', function () {
//     return view('Hello wold');
// });


Route::resource('students', StudentController::class);

Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);

Route::resource('likeable', LikeableController::class);
Route::get('/liked/{id}/{type}', [LikeableController::class, 'likeable']);
Route::get('/doctor', [PatientController::class, 'doctors']);


Route::get('/posts', [PostController::class, 'index'])->name('posts.index1');
Route::get('/posts/create1', [PostController::class, 'create'])->name('posts.create1');
Route::post('/posts', [PostController::class, 'store'])->name('post.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show1');



// Route::get('/', function () {
//     return view('patient');
// });
// Route::post('patient-add', [PatientController::class, 'patient_add']);
// Route::get('patient-view', [PatientController::class, 'patient_view']);
// Route::get('patient-delete', [PatientController::class, 'patient_delete']);
// Route::post('patient-edit', [PatientController::class, 'patient_edit']);

Route::group(['prefix' => '{lang?}', 'where' => ['lang' => 'hi|en|ta'], 'middleware' => 'localizationMiddleware'], function () {
    Route::prefix('/doctor')->name('doctor.')->group(function () {

        Route::post('upload_image', [DoctorController::class, 'uploadImage'])->name('upload');

        Route::post('/sendImages', [DoctorController::class, 'sendImages'])->name('sendImages');
        Route::post('/deletechat/{id}', [DoctorController::class, 'chatDelete'])->name('chatdelete');
        Route::post('/pusher/send-message', [DoctorController::class, 'sendMessage'])->name('send-message');
        Route::get('/messages', [DoctorController::class, 'messages'])->name('messages');

        Route::get('/login', [DoctorController::class, 'index'])->name('login');
        Route::get('/verification/{token}', [DoctorController::class, 'verification'])->name('verification');
        Route::get('/register', [DoctorController::class, 'register'])->name('register');
        Route::get('/save', [DoctorController::class, 'save'])->name('save');

        Route::get('/check', [DoctorController::class, 'check'])->name('check');
        Route::post('/verify/{token}', [DoctorController::class, 'verify'])->name('verify');

        Route::get('/mailsend', [DoctorController::class, 'sendMail']);
        Route::get('/logout', [DoctorController::class, 'logout'])->name('logout');
       
        
   
   

        // Route::get('/login/google', [DoctorController::class, 'redirect'])->name('login.google-redirect');
        // Route::get('/login/google/callback', [DoctorController::class, 'callback'])->name('login.google-callback');

        Route::group(['middleware' => 'auth:doctor'], function () {
            Route::get('/chat/{id}', [DoctorController::class, 'chat'])->name('chat');

            // Route::get('/chat', function () {
            //     return view('welcome');
            // });  
            
            Route::resource('/patient', PatientController::class)->middleware('auth:doctor'); 
           
            // Route::get('/patient/{id}/edit/', [PatientController::class, 'edit'])->name('patient_edit');
            Route::get('/patient-list', [PatientController::class, 'list'])->name('patient-list');
            Route::get('/patient-delete', [PatientController::class, 'delete'])->name('patient_delete');

            Route::get('/patient-trash', [PatientController::class, 'trash'])->name('patient_trash');
       
            // Route::get('/messages', [DoctorController::class, 'messages'])->name('messages');
            Route::get('/store-token', [DoctorController::class, 'updateDeviceToken'])->name('store.token');
            Route::post('/send-web-notification', [DoctorController::class, 'sendNotification'])->name('send.web-notification');

            Route::get('patient', function () {
                return view('patient');
            })->name('patient.index');
        });
    });
});

Route::get('doctor/patient/{id}/edit/', [PatientController::class, 'edit'])->name('patient_edit'); 

// Route::post('/deletechat/{id}', [DoctorController::class, 'chatDelete'])->name('chatdelete');

Route::get('/cilentrequest', [DoctorController::class, 'cilentrequest']);

// Route::prefix('/doctor')->name('doctor.')->group(function () {
//     // Route::get("locale/{lange}",[DoctorController::class, 'setLang']);
//     Route::get('/login', [DoctorController::class, 'index'])->name('login');
//     Route::get('/verification/{token}', [DoctorController::class, 'verification'])->name('verification');
//     Route::get('/register', [DoctorController::class, 'register'])->name('register');
//     Route::get('/save', [DoctorController::class, 'save'])->name('save');

//     Route::get('/check', [DoctorController::class, 'check'])->name('check');
//     Route::get('/verify/{token}', [DoctorController::class, 'verify'])->name('verify');

//     Route::get('/mailsend', [DoctorController::class, 'sendMail']);
//     Route::get('/logout', [DoctorController::class, 'logout'])->name('logout');

//     Route::resource('/patient', PatientController::class);
//     Route::get('/patient-list', [PatientController::class, 'list'])->name('patient-list');
//     Route::get('/patient-delete', [PatientController::class, 'delete'])->name('patient_delete');

//     Route::get('patient', function () {
//         return view('patient');
//     })->name('patient.index')->middleware('auth:doctor');
// });
Route::get('/login/google', [DoctorController::class, 'redirect'])->name('login.google-redirect')->middleware('auth:doctor');
Route::get('/login/google/callback', [DoctorController::class, 'callback'])->name('login.google-callback')->middleware('auth:doctor');


Route::group(['prefix' => '/servant'], function () {
    
    Route::resource('register', ServantController::class);
    Route::get('/login', [ServantController::class, 'index'])->name('login');
    Route::get('/register', [ServantController::class, 'register'])->name('register');
    Route::get('/save', [ServantController::class, 'save'])->name('save');
    Route::get('/check', [ServantController::class, 'check'])->name('check');
    Route::get('/logout', [ServantController::class, 'logout'])->name('logout');
});

Route::get('/servant', function () {
    return view('servant');
})->name('servant')->middleware(['auth:servant']);

// Route::get('/test',function(){
//     App::setLocale('fr');

//     if(App::isLocal('fr')){
//         dd(App::getLocale());
//     }
// });


Route::get('/chats', function () {

    $user = [
             'name' => 'Visha',
             'email' => 'visha12@gmail.com',
             'password' => bcrypt('12345'),
             'user_role' => 2
            ];


            $validator = Validator::make($user, [
                    'user_role' => [new RulesEnum(Status::class)]
            ]);

            if($validator->fails()){
                dd('fail');
            }
            dd('done');

    //         Doctor::create($user);
    //         dd('done'); 


    // $user = Doctor::find(338);
    // $user->user_role = Status::active;
    // $user->save();
    // return;


    // $user =  Status::cases();

    //Enum Method
    // $user = Status::active;
    // dd($user->Status());
});

Route::get('user/{Status}', function (Status $Status) {
    $user = Doctor::where('user_role', $Status->value)->get();
    dd($user->toArray());
});

Route::get('user-test', function () {
    $nice = ["bhavik", "sidhhi", "vanshu"]; 
    return view('home', compact('nice'));
});

Route::view('/wel', 'home');