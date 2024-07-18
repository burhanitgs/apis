<?php		
		// app/Http/Controllers/API/RegisterController.php
        namespace App\Http\Controllers\API;
 
        use Illuminate\Http\Request;
        use App\Http\Controllers\API\BaseController as BaseController;
        use App\Models\User;
		use App\Models\Patient;
		use App\Models\Onboard;
        use Illuminate\Support\Facades\Auth;
        use Validator;
		use App\Http\Resources\Onboard as OnboardResource;
		
        class OnboardController extends BaseController
        {
           /**
            * Display a listing of the resource.
            *
            * @return \Illuminate\Http\Response
            */
            public function index()
            {
                $Onboard = Onboard::all();
 
                return $this->sendResponse(OnboardResource::collection($Onboard), 'Onboard retrieved successfully.');
            }
 
            /**
            * Store a newly created resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @return \Illuminate\Http\Response
            */
            public function store(Request $request)
            {
				$user = Auth::User();
                $input = $request->all();
				$input['user_id']=$user->id;
                $validator = Validator::make($input, [
                    'birth_sex' => 'required',
                    'employment_status' => 'required',
					'occupation' => 'required',
					'education_level' => 'required',
					'total_children' => 'required',
					'pregnant' => 'required',
					'gestation' => 'required',
					'expected_babies' => 'required',
                ]);
				
 
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
				
                //$Onboard = Onboard::create($input);
				$Onboard = Onboard::updateOrCreate(['user_id'=>$user->id],$input);

                return $this->sendResponse(new OnboardResource($Onboard), 'Onboard created successfully.');
            } 
 
            /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
 
            public function show($id)
            {
                $Onboard = Onboard::find($id);
                if (is_null($Onboard)) {
                    return $this->sendError('Onboard not found.');
                }
 
                return $this->sendResponse(new OnboardResource($Onboard), 'Onboard retrieved successfully.');
            }
 
            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
 
            public function update(Request $request, Onboard $Onboard)
            {
                $input = $request->all();
 
                $validator = Validator::make($input, [
                    'birth_sex' => 'required',
                    'employment_status' => 'required'
                ]);
 
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
 
                $Onboard->birth_sex = $input['birth_sex'];
                $Onboard->employment_status = $input['employment_status'];
				$Onboard->occupation = $input['occupation'];
				$Onboard->education_level = $input['education_level'];
				$Onboard->total_children = $input['total_children'];
				$Onboard->pregnant = $input['pregnant'];
				$Onboard->gestation = $input['gestation'];
                $Onboard->save();
 
                return $this->sendResponse(new OnboardResource($Onboard), 'Onboard updated successfully.');
            }
 
            /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function destroy(Onboard $Onboard)
            {
                $Onboard->delete();
                return $this->sendResponse([], 'Onboard deleted successfully.');
            }
        }