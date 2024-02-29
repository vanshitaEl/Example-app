<?php

namespace App\Http\Controllers\Doctor;

use App\Events\Message;
use App\Events\TestEmailEvent;
use Illuminate\Auth\Events\Registered;
use App\Models\Doctor;
use Illuminate\Support\Str;
use App\Models\verifyUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Mail\TestMail;
use App\Jobs\TestEmailJob;
use App\Models\ChatRooms;
use App\Models\Message as ModelsMessage;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use App\Notifications\TestEmail;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;
use Laravel\Socialite\Facades\Socialite;

use function Laravel\Prompts\alert;

class DoctorController extends Controller
{

    // //  public function sendMail(){

    // //     $doctor = Doctor::all();
    // //     $url= "https://mailtrap.io/home";
    // //     Mail::to('vanshita.r@elaunchinfotech.in')->send(new TestMail($doctor,$url));

    // //  }

    // public function setLang($locale)
    // {
    //     App::setLocale($locale);
    //     // Session::put("locale", $locale);
    //     return view('doctor.registration');

    // }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();

            if (!$user) {
                // Handle the case when the user is not found in the Google response
                // You might want to redirect to an error page or log the issue
                // dd('User not found in Google response. Redirecting to error page.');
                return redirect()->route('error');
            }

            $finduser = Doctor::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                // dd('User found. Logging in.');
                return redirect()->route('doctor.patient.index', ['lang' => 'en']);
            } else {
                $newUser = Doctor::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy'),
                    'user_role' => 1
                ]);

                Auth::login($newUser);
                // dd('New user created. Logging in.');
                return redirect()->route('doctor.patient.index', ['lang' => 'en']);
            }
        } catch (Exception $e) {
            // Handle exceptions, you might want to redirect to an error page or log the issue
            // dd($e->getMessage());
            return response("Something went wrong!!");
        }
    }



    public function messages()
    {

        // $patients = patients::all();
        $patients = Patient::with('doctor')->get();
        // $patientArray= $patients->toArray();
        // print_r($patientArray);
        foreach ($patients as $patient) {
            // echo $patientArray['doctor']['name']."<br>";
            // $doctorName= $patient->doctor->name;
            echo $patient->doctor->name;
        }

        // return view('home');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    public function chat(Request $request, $lng, $id)
    {
        if ($id == Auth::guard('doctor')->id()) {

            return response("can't Message");
        } else {

            $chatRoom = ChatRooms::where(['f_user' => Auth::guard('doctor')->id(), 's_user' => $id])->first();
            // dd($chatRoom);
            if (!isset($chatRoom)) {
                $chatRoom = ChatRooms::where(['f_user' => $id, 's_user' => Auth::guard('doctor')->id()])->first();
                //  dd($chatRoom);
                if (!isset($chatRoom)) {
                    $data['f_user'] = Auth::guard('doctor')->id();
                    $data['s_user'] = $id;
                    $chatRoom = ChatRooms::create($data);
                }
            }

            //  dd($chatRoom);

            $messages = [];
            if (!empty($chatRoom)) {
                $messages = ModelsMessage::where('chat_room_id', $chatRoom->id)->get();
            } else {
                $messages = ModelsMessage::whereIn('user_id', [$id, Auth::guard('doctor')->id()])->get();
            }

            return view('welcome', compact('id', 'chatRoom', 'messages'));
        }
    }


    public function sendMessage(Request $request)
    {
        $message = $request->only('message', 'receiver_id');

        // $message =   $request->file('images'); 
        // $fileName = pathinfo($message, PATHINFO_FILENAME);
        // $extension = $message->getClientOriginalExtension();
        // $fileName = $fileName . '_' .   time() . '.' . $extension;  
        // $request->file('images')->move(public_path('media'),$fileName);
        // // dd($request);
        // $url = asset('media/' .$fileName);
        // return response()->json(['message' => $fileName, 'uploaded' => 1 ,'url' =>$url]);
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            // $file->move(\public_path("/file"), $filename);
            $path = $file->storeAs('public/file', $filename);
            $message['images'] = $filename;
        }
        $message['user_id'] = Auth::guard('doctor')->id();
        $message['chat_room_id'] = $request->chat_room_id;

        $message = ModelsMessage::create($message);



        $return_data['response_code'] = 0;
        $return_data['message'] = 'Something went wrong, Please try again later.';
        // $rules = ['message' => 'required'];
        // $messages = ['message.required' => 'Please enter message to communicate.'];
        $rules = [
            'images' => 'required_without_all:message',
            'message' => 'required_without_all:images',
        ];
        $messages = [
            'required_without_all' => 'Please enter either a message or select an image.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = implode("", $validator->messages()->all());
            $return_data['message'] = $message;
            return $return_data;
        }

        try {
            event(new Message($request->chat_room_id, $message));
            // return 'message sent';
            $return_data['response_code'] = 1;
            $return_data['message'] = 'Success.';
        } catch (\Exception $e) {
            $return_data['message'] = $e->getMessage();
        }
        return $return_data;
    }

    public function chatDelete($lang, $id)
    {
        // dd($id);    
        $message = ModelsMessage::find($id);
        $message->delete();
        $file_path = storage_path('app/public/file/' . $message->images);
        if (File::exists($file_path)) {

            unlink($file_path);
        }

        // dd($role);
        // $role= ModelsMessage::where('id', 40)->delete();
        if ($message) {
            $response = [
                'status' => 'ok',
                'success' => true,
                'message' => 'message deleted!'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'message deleted failed!'
            ];
            return $response;
        }
    }

    public function index($locale)
    {
        App::setLocale($locale);
        return view('doctor.login');
    }

    public function cilentrequest(Request $request)
    {
    }

    public function verification($token)
    {

        // $token = $request->token;
        // dd($token);
        try {
            $verifyUser =  verifyUser::where('token', $token)->firstOrFail();
            // return $verifyUser;
        } catch (\Exception $exception) {
            // log::info($exception->getMessage());
            Log::info('User Not Found Exception');
        }
        // verifyUser::where('token', $token)->firstOrFail();
        return view('emailverification', compact('token'));
    }

    public function user()
    {
        $doctor = Doctor::get();
        //   return $doctor->KeyBy->id;
        return DoctorResource::collection($doctor);

        // return new DoctorCollection($doctor);
    }

    public function register(Request $request)
    {
        $page = $request->page;

        $fliter = ['skip' => 0, 'limit' => 30, 'total' => 100];

        if (isset($page)) {
            $fliter = ['skip' => 30 * ($page - 1), 'limit' => 30, 'total' => 100];
        }


        $response = Http::get('https://dummyjson.com/quotes', $fliter);
        $quotes = collect($response['quotes']);
        $total = $response['total'];
        $skip = $response['skip'];
        $limit = $response['limit'];
        $totalPage = ceil($total / $fliter['limit']);
        return view('doctor.registration', compact('quotes', 'totalPage'));
    }

    function save(DoctorRegisterRequest $request)
    {

        //Validate requests
        $request->validated();

        //Insert data into database
        // try {
        //     $doctor = Doctor::where('email', '=', $request->email)->with(['verfiyToken'])->first();
        //     return $doctor;
        // } catch (\Exception $exception) {
        //     // log::info($exception->getMessage());
        //     Log::info('User Not Found Exception');
        // }
        $doctor = Doctor::where('email', '=', $request->email)->with(['verfiyToken'])->first();
        if (isset($doctor)) {
            $last_id = $doctor->id;
            $token = $last_id . hash('sha256', Str::random(120));

            $verifyURL = route('doctor.verification', ['token' => $token]);
            $EmailVerifyToken = verifyUser::create([
                'doctor_id' => $last_id,
                'token' => $token,
            ]);



            if (!empty($EmailVerifyToken)) {

                $message =  $request->name;
                $mail_data = [
                    'email' => $request->email,
                    'actionLink' => $verifyURL,
                    'token' => $token,
                ];
                $doctor->notify(new TestEmail($mail_data));
                // Notification::send($doctor, new TestEmail($mail_data));
                // Notification::route('mail', $mail_data)->notify(new TestEmail($mail_data));
                // Mail::to('vanshita.r@elaunchinfotech.in')->send(new TestMail($mail_data, $message));
                // dispatch(new TestEmailJob($mail_data, $message));
                // dispatch(new SendEmailJob($token))->delay(now()->addMinutes(5));
            }
            return back()->with('success', __('lang.success_thank'));
        } else {

            $doctor = new Doctor;
            $doctor->name = $request->name;
            $doctor->email = $request->email;

            $doctor->password = Hash::make($request->psw);
           
            $save = $doctor->save();

            $last_id = $doctor->id;
            $token = $last_id . hash('sha256', Str::random(120));

            $verifyURL = route('doctor.verification', ['token' => $token]);
            $EmailVerifyToken = verifyUser::create([
                'doctor_id' => $last_id,
                'token' => $token,

            ]);

            // event(new TestEmailEvent($EmailVerifyToken));

            if (!empty($EmailVerifyToken)) {

                $message =  $request->name;
                $email = $request->email;
                $mail_data = [
                    'email' => $email,
                    'actionLink' => $verifyURL,
                    'token' => $token,
                ];


                $doctor->notify(new TestEmail($mail_data));
                // Notification::send($doctor,new TestEmail($mail_data));
                // Mail::to($request->email)->send(new TestMail($mail_data, $message));
                // dispatch(new TestEmailJob($mail_data, $message));
                // dispatch(new SendEmailJob($token))->delay(now()->addMinutes(5));
            }

            // Mail::send('email.testmail', $mail_data, function ($mesage) use ($mail_data) {
            //     $mesage->to($mail_data['recipient'])
            //         ->from($mail_data['fromEmail'], $mail_data['fromName'])
            //         ->subject($mail_data['subject']);
            // });

            if ($save) {
                // return view('home');
                return back()->with('success', __('lang.success_thank'));
            } else {
                return back()->with('fail',  __('lang.fail'));
            }
        }
    }

    public function verify($token)
    {
        try {
            $verifyUser = verifyUser::where('token', $token)->firstOrFail();
            // $verifyUser;
        } catch (\Exception $exception) {
            Log::info('User not found');
            return redirect()->route('doctor.register');
        }

        // $verifyUser = verifyUser::where('token', $token)->firstOrFail();
        if (!is_null($verifyUser)) {
            $doctor = $verifyUser->doctor;

            if (!$doctor->status) {
                return redirect()->route('doctor.login')->with('info',  __('lang.info_verify'))->with('status', $doctor->email);
            } else {
                $verifyUser->doctor->status = 'Active';
                // try {
                //     $verifyUser->doctor->save();
                //     // return $verifyUser;
                // } catch (\Exception $exception) {
                //     // log::info($exception->getMessage());
                //     Log::info('not found');
                // }
                $verifyUser->doctor->save();
                $doctor_id = $doctor->id;
                verifyUser::where('doctor_id', $doctor_id)->delete();
                return redirect()->route('doctor.login')->with('info', __('lang.info_verify'))->with('status', $doctor->email);
            }
        }
    }

    function check(LoginRequest $request)
    {
        //Validate requests
        $request->validated();

        // $userInfo = Doctor::where('email', '=', $request->email)->first();
        try {
            $userInfo = Doctor::where('email', '=', $request->email)->first();
            // return $userInfo;
        } catch (\Exception $exception) {
            // log::info($exception->getMessage());
            Log::info('User Not Found Exception');
        }

        // if (!$userInfo) {
        //     return back()->with('fail', 'We do not recognize your email address');
        // } else {

        //     //check password
        //     if (Hash::check($request->password, $userInfo->password)) {
        //         // dd($userInfo);
        //         Auth::guard('doctor')->login($userInfo, true);
        //         return redirect()->route('doctor.patient.index');
        //     } else {
        //         return back()->with('fail', 'Incorrect password');
        //     }
        // }   

        if ($userInfo) {
            if ($userInfo->status != "pending") {
                if (Hash::check($request->password, $userInfo->password)) {
                    Auth::guard('doctor')->login($userInfo, true);
                    return redirect()->route('doctor.patient.index', ['lang' => app()->getLocale()]);
                } else {
                    return back()->with('fail', __('lang.invalid_password'));
                }
            } else {
                return back()->with('fail', __('lang.s_panding'));
            }
        } else {
            return back()->with('fail',  __('lang.invalid_email'));
        }
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return  redirect()->route('doctor.login', ['lang' => app()->getLocale()]);
    }
}
