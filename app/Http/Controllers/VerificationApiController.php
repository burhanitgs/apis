<?php

namespace App\Http\Controllers;
//use App\User;
use App\Models\Patient;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Validator;
use App\Http\Resources\UserResource;
class VerificationApiController extends Controller
{

	use VerifiesEmails;

	/**

	* Show the email verification notice.
	*
	*/

	public function show()
	{
	//
	}

	/**

	* Mark the authenticated user’s email address as verified.

	*

	* @param \Illuminate\Http\Request $request

	* @return \Illuminate\Http\Response

	*/

	public function verify(Request $request) 
	{

		//fullname
		//emial address
		//phone number
		//date of birth 
		//phone
		$userID = $request['id'];
		$user = Patient::findOrFail($userID);
		//print_r($user);
		
		
		$date = date("Y-m-d g:i:s");
		$user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
		$user->save();
		//return response()->json("Email verified!");
		
		$patient_full_name=$user->first_name." ".$user->last_name;
		$patient_phone=$user->phone_number;
		$dob=$user->date_of_birth;
		$email=$user->email ;
		$mytokenforaccess=$user->createToken('MyApp')->accessToken;
		$url="https://eclectic-blancmange-8e1e25.netlify.app/?email=$email&fullname=$patient_full_name&phone=$patient_phone&date_of_birth=$dob&token=$mytokenforaccess";
		//header("Location:$url");
		//echo $url;
		//exit;
		return redirect($url)->with('success', 'Email verified Successfully!');
		//print_r($mytokenforaccess);
		//die("testing phase");
	}

	/**

	* Resend the email verification notification.

	*

	* @param \Illuminate\Http\Request $request

	* @return \Illuminate\Http\Response

	*/

	public function resend(Request $request)
	{

		if ($request->user()->hasVerifiedEmail()) 
		{
			return response()->json('User already have verified email!', 422);
			// return redirect($this->redirectPath());
		}
		$request->user()->sendEmailVerificationNotification();
		return response()->json('The notification has been resubmitted');
		// return back()->with(‘resent’, true);
	}

}