<?php		
		// app/Http/Controllers/API/RegisterController.php
        namespace App\Http\Controllers\API;
 
        use Illuminate\Http\Request;
        use App\Http\Controllers\API\BaseController as BaseController;
        use App\Models\User;
        use Illuminate\Support\Facades\Auth;
        use Validator;
 
        class RegisterController extends BaseController
        {
            /**
            * Register api
            *
            * @return \Illuminate\Http\Response
            */
            public function register(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    //'email' => 'required|email',
					'email' => 'unique:users,email,'.$request->email,
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                ]);
 
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
 
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
				$success['first_name'] =  $user->first_name;
				$success['middle_name'] =  $user->middle_name;
				$success['last_name'] =  $user->last_name;
				$success['phone_number'] =  $user->phone_number;
				$success['address'] =  $user->address;
				$success['date_of_birth'] =  $user->date_of_birth;
                return $this->sendResponse($success, 'User register successfully.');
            }
 
            /**
            * Login api
            *
            * @return \Illuminate\Http\Response
            */
            public function login(Request $request)
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                    $user = Auth::user(); 
                    $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                    $success['name'] =  $user->name;
					$success['first_name'] =  $user->first_name;
					$success['middle_name'] =  $user->middle_name;
					$success['last_name'] =  $user->last_name;
					$success['phone_number'] =  $user->phone_number;
					$success['address'] =  $user->address;
					$success['date_of_birth'] =  $user->date_of_birth;
                    return $this->sendResponse($success, 'User login successfully.');
                } 
                else{ 
                    return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
                } 
            }
        }