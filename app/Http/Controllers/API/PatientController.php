<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Validator;


use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class PatientController extends BaseController
{

	use VerifiesEmails;
	public $successStatus = 200;


	/**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }*/
	public function register(Request $request)
    {
		
		
        /*$validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:patients,email',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $patient = Patient::create([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
            'password' => Hash::make($validatedData['password']),
        ]);*/
		
		
				$validator = Validator::make($request->all(), [
                    //'name' => 'required',
                    //'email' => 'required|email',
					'email' => 'unique:patients,email,'.$request->email,
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                ]);
 
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
 
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $patient = Patient::create($input);
				$patient->sendApiEmailVerificationNotification();


				$success['token'] =  $patient->createToken('MyApp')->accessToken;
                $success['id'] =  $patient->id;
                //$success['name'] =  $user->name;
				$success['first_name'] =  $patient->first_name;
				$success['middle_name'] =  $patient->middle_name;
				$success['last_name'] =  $patient->last_name;
				$success['phone_number'] =  $patient->phone_number;
				$success['address'] =  $patient->address;
				$success['email'] =  $patient->email;
				$success['date_of_birth'] =  $patient->date_of_birth;
				
               //return $this->sendResponse($success, 'User register successfully.');

			   return response()->json($this->formatToFhir($success), 201);
		
	}
			/**
            * Login api
            *
            * @return \Illuminate\Http\Response
            */
            public function login(Request $request)
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                    $user = Auth::User();
					if($user->email_verified_at==null)
					{
						return $this->sendError('usernotverfied.', ['error'=>'User not verified,kindly verify user inorder to proceed']);
					}
                    $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                    $success['name'] =  $user->name;
					$success['first_name'] =  $user->first_name;
					$success['middle_name'] =  $user->middle_name;
					$success['last_name'] =  $user->last_name;
					$success['phone_number'] =  $user->phone_number;
					$success['address'] =  $user->address;
					$success['date_of_birth'] =  $user->date_of_birth;
					//$success['gender'] =  $user->date_of_birth;
                    return $this->sendResponse($success, 'User login successfully.');
                } 
                else{ 
                    return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
                } 
            }
    private function formatToFhir($patient)
    {
		
        return [
            'resourceType' => 'Patient',
            'id' => $patient['id'],
            'name' => [
                [
                    'use' => 'official',
                    'family' => $patient['last_name'],
                    'given' => [$patient['first_name'], $patient['middle_name']]
                ]
            ],
            'gender' => 'unknown',
            'birthDate' => $patient['date_of_birth'],
			'token' => $patient['token'],
            'address' => [
                [
                    'use' => 'home',
                    'line' => $patient['address'],
                    'city' => 'unknown',
                    'state' => 'unknown',
                    'postalCode' => 'unknown',
                    'country' => 'unknown'
                ]
            ],
            'telecom' => [
                [
                    'system' => 'phone',
                    'value' => $patient['phone_number'],
                    'use' => 'home'
                ],
                [
                    'system' => 'email',
                    'value' => $patient['email'],
                    'use' => 'home'
                ]
            ]
        ];
    }	
}
