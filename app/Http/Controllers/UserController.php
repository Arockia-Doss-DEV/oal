<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Carbon\Carbon;
use App\Subscription;
use App\Country;
use App\InvestmentClass;
use Faker\Factory as Faker;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index(Request $request)
    {

        $user = \Auth::user();
        print_r($user);

        $data = User::orderBy('id','DESC')->paginate(5);
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }*/

    public function index(Request $request){

        $request->session()->put('back', "index");

        $groupSubCond1[] = [
            ['is_first', '=', 1],
            ['status', '=', 3],
        ];

        $groupSubCond2[] = [
            ['is_first', '=', 0],
            ['status', '=', 3],
        ];

        $search =  $request->input('q');
        if($search!=""){

            $users = User::whereHas('subscriptions', function ($query){
                        $query->where('is_first', 1);
                        $query->where('status', 3);
                    })

                    ->where(function($q) use ($search) {
                            $q->where('email', 'LIKE', '%'.$search.'%');
                            $q->orWhere('mobile_no', 'LIKE', '%'.$search.'%');
                            $q->orWhere('name', 'LIKE', '%'.$search.'%');
                        }
                    )
                    ->where('active', 1)
                    ->where('email_verified', 1)
                    ->where('role_id', '!=', 2)
                    ->latest()
                    ->paginate(10);

            $users->appends(['q' => $search]);

        } else {
    
            $users = User::whereHas('subscriptions', function ($query){
                        $query->where('is_first', 1);
                        $query->where('status', 3);
                    })
                    ->withCount('subscriptions')
                    ->where('role_id', '!=', 2)
                    ->where('email_verified', 1)
                    ->where('active', 1)
                    ->latest()
                    ->paginate(10);
        }

        return view('admin.users.index')->with(['users' =>$users, 'title'=> "Active Investors"]);
    }

    public function investerDeactive(Request $request){

        $request->session()->put('back', "investerDeactive");

        // return session('back');
        
        $groupSubCond1[] = [
            ['is_first', '=', 1],
            ['status', '!=', 3],
        ];

        $groupSubCond2[] = [
            ['is_first', '=', 0],
            ['status', '!=', 3],
        ];

        $search =  $request->input('q');
        if($search!=""){

            $users = User::whereHas('subscriptions', function ($query){
                        $query->where('is_first', 1);
                        $query->whereIn('status', [0, 1, 2, 4, 5, 6, 7, 8, 9]);
                    })

                    ->where(function($q) use ($search) {
                            $q->where('email', 'LIKE', '%'.$search.'%');
                            $q->orWhere('mobile_no', 'LIKE', '%'.$search.'%');
                            $q->orWhere('name', 'LIKE', '%'.$search.'%');
                        }
                    )
                    
                    ->orDoesntHave('subscriptions')
                    ->whereIn('email_verified', [0, 1])
                    ->where('role_id', '!=', 2)

                    ->orderBy('id', 'ASC')
                    ->paginate(10);

            $users->appends(['q' => $search]);

        } else {

            // $users = User::whereHas('subscriptions', function ($query){
            //             $query->where('is_first', 1);
            //             $query->whereIn('status', [0, 1, 2, 4, 5, 6, 7, 8, 9]);
            //         })
            //         ->withCount('subscriptions')
            //         ->where('role_id', '!=', 2)
            //         ->whereIn('email_verified', [0, 1])
            //         ->latest()
            //         ->paginate(10);


            $users = User::with('subscriptions')
                ->where(function ($query) {
                    $query->whereHas('subscriptions', function ($query) {
                        $query->where('is_first', 1);
                        $query->whereNotIn('status', [3]);
                    });
                    
                    // ->orWhereHas('subscriptions', function ($query) {
                    //     $query->where('draft', 1);
                    // });
                })
                ->orDoesntHave('subscriptions')
                ->where('role_id', '!=', 2)
                ->whereIn('email_verified', [0, 1])
                ->orderBy('id', 'ASC')
                ->paginate(10);
        }

        return view('admin.users.index')->with(['users' =>$users, 'title'=> "Deactive Investors"]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');
        $roles = Role::pluck('name','name')->all();
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";

            // $phone_prefix[$value->calling_code] = "+(".$value->calling_code.")-".$value->name;
        }

        $phone_prefix = array_reverse($phone_prefix,true);
        
        // return $phone_prefix;

        return view('admin.users.create',compact('roles', 'countries', 'phone_prefix'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $input = $request->all();

        // return $input;

        $input['password'] = Hash::make($input['password']);
        $input['role_id'] = 3;
        // $input['email_verified_at'] = $this->freshTimestamp();
        $input['email_verified_at'] = Carbon::now()->timestamp;
        $input['email_verified'] = 1;
        $input['model_type'] = "App\User";
        $input['status'] = 0;


        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $back = $request->session()->get('back');

        if(!empty($back)){
            if($back == "index"){
                return redirect()->route('users.index')
                        ->with('success','User created successfully');
            }else{
                return redirect('/deactive-invester')
                        ->with('success','User created successfully');
            }
        }

        return redirect('/')->route('users.index')
                        ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        // $search =  $request->input('q');
        // if($search!=""){

        //     $users = User::with(['subscriptions'])
        //                 ->whereHas('subscriptions', function($query) use($groupSubCond1, $groupSubCond2) {
        //                     $query->where([$groupSubCond1]);
        //                     $query->orWhere([$groupSubCond2]);
        //                 })

        //                 ->where(function($q) use ($search) {
        //                         $q->where('email', 'LIKE', '%'.$search.'%');
        //                         $q->orWhere('mobile_no', 'LIKE', '%'.$search.'%');
        //                         $q->orWhere('name', 'LIKE', '%'.$search.'%');
        //                     }
        //                 )
        //                 ->where('active', 1)
        //                 ->where('email_verified', 1)
        //                 ->where('role_id', '!=', 2)
        //                 ->latest()
        //                 ->paginate(10);

        //     $users->appends(['q' => $search]);

        // } else {
    
        //     $users = User::with('subscriptions')
        //                 ->whereHas('subscriptions', function ($query) use($groupSubCond1, $groupSubCond2) {
        //                     $query->where([$groupSubCond1]);
        //                     $query->orWhere([$groupSubCond2]);
        //                     // $query->orWhere([$groupSubCond3]);
        //                 })
        //                 ->where('active', 1)
        //                 ->where('email_verified', 1)
        //                 ->where('role_id', '!=', 2)
        //                 ->latest()
        //                 ->paginate(10);
        // }

        $user = User::with(['countryAs', 'stateAs'])->find($id);
        $q = Subscription::query();

        // if(auth()->user()->isAgent) {
        //     $q->where('agent_id', auth()->user()->id);
        // }elseif(auth()->user()->isIntermediary){
        //     $q->where('intermediary_id', auth()->user()->id);
        // }

        // if($request->is_first) {
        //     $q->where('is_first', $request->is_first);
        // }

        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        $term = trim($request->input('q'));
        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('user_id', $user->id);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->get();
        
        // $subscriptions = Subscription::where(['user_id' => $user->id])->get();
        $investmentClasses = InvestmentClass::where('active', 1)->get();
        $endClass = count($investmentClasses);

        $check_investment = $this->checkAdditionalInvestment($user->id);
        $check_investment_class = $this->checkInvestmentClass($user->id);

        // return $check_investment_class;

        return view('admin.users.show',compact('user', 'subscriptions', 'investmentClasses', 'endClass', 'check_investment', 'check_investment_class'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $countries = Country::pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }

        $phone_prefix = array_reverse($phone_prefix,true);

        // foreach ($phone_prefixData as $value) {
        //     $phone_prefix[$value->calling_code] = "+(".$value->calling_code.")-".$value->name;
        // }

        return view('admin.users.edit',compact('user','roles','userRole', 'countries', 'phone_prefix'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();       
        $user = User::find($id);
        $user->update($input);

        //DB::table('model_has_roles')->where('model_id',$id)->delete();
        //$user->assignRole($request->input('roles'));

        $back = $request->session()->get('back');
        if(!empty($back)){
            if($back == "index"){
                return redirect()->route('users.index')
                        ->with('success','User created successfully');
            }else{
                return redirect('/deactive-invester')
                        ->with('success','User created successfully');
            }
        }
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function userChangePassword(Request $request, $id){
        
        $userData = User::find($id);
        if (empty($userData)) {
            return redirect()->back()->with("error","User not found. Please try again.");
        }
        return view('admin.users.userChangePassword', ['user' => $userData]);
    }
    
    public function userChangePasswordSave(Request $request, $id){
        
        $userData = User::find($id);
        
        if (empty($userData)) {
            return redirect()->back()->with("error","User not found. Please try again.");
        }
        
        if (!(Hash::check($request->get('current_password'), $userData->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $userData->password = Hash::make($request->get('new_password'));
        $userData->save();
    
        $back = $request->session()->get('back');

        if(!empty($back)){
            if($back == "index"){
                return redirect()->route('users.index')
                        ->with('success','Password changed successfully');
            }else{
                return redirect('/deactive-invester')
                        ->with('success','Password changed successfully');
            }
        }
        
        return redirect()->back()->with("success","Password changed successfully !");
    }
    
     public function enable2FaUser(Request $request, $id){
         
        $userData = User::find($id);
        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();

        $qr_image = $google2fa->getQRCodeInline(
            config('app.name'),
            $userData->email,
            $google2fa_secret
        );

        return view('admin.users.enable2FaUser', ['google2fa_secret' => $google2fa_secret, 'qr_image' => $qr_image, 'user' =>$userData]);
     }
     
     
    public function enable2FaUserSave(Request $request, $id){
        
        $userData = User::find($id);
        
        $secret = $request->input('secretcode');
        $oneCode = $request->input('code');

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($secret, $oneCode, 2); // 2 = 2*30sec clock tolerance
        if ($valid) {
            $userData['2fa_key'] =  $secret;
            $userData['2fa_status'] = 1;
            $userData->save();

            //return response()->json(['data' => "0"], 201);
        }
        
        $back = $request->session()->get('back');

        if(!empty($back)){
            if($back == "index"){
                return redirect()->route('users.index')
                        ->with('success','Password changed successfully');
            }else{
                return redirect('/deactive-invester')
                        ->with('success','Password changed successfully');
            }
        }
        
        return redirect()->back()->with("success","Password changed successfully !");
    }
    
    public function disable2FaUser(Request $request){
        
        $id = $request->input('id');
        $userData = User::find($id);
        if (empty($userData)) {
            return redirect()->back()->with("error","User not found. Please try again.");
        }
        
        if($request->input('disable') == "disable"){
            $userData['2fa_key'] =  "";
            $userData['2fa_status'] = 0;   
            $userData->save();
            return response()->json(['data' => "success"], 201);
        }     
        return response()->json(['data' => "error"], 201);     
    }
    
    public function activeUser(Request $request){
        
        $id = $request->input('id');
        $userData = User::find($id);
        if (empty($userData)) {
            return redirect()->back()->with("error","User not found. Please try again.");
        }
        
        if($request->input('active') == "active"){
            $userData['active'] = 1;   
            $userData->save();
            return response()->json(['data' => "success"], 201);
        }     
        return response()->json(['data' => "error"], 201);     
    }
    
    public function deactiveUser(Request $request){
        
        $id = $request->input('id');
        $userData = User::find($id);
        if (empty($userData)) {
            return redirect()->back()->with("error","User not found. Please try again.");
        }
        
        if($request->input('deactive') == "deactive"){
            $userData['active'] = 0;   
            $userData->save();
            return response()->json(['data' => "success"], 201);
        }     
        return response()->json(['data' => "error"], 201);     
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        $back = $request->session()->get('back');
        if(!empty($back)){
            if($back == "index"){
                return redirect()->route('users.index')
                        ->with('success','User created successfully');
            }else{
                return redirect('/deactive-invester')
                        ->with('success','User created successfully');
            }
        }
        
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    private function checkAdditionalInvestment($userId) {
        
        $subscriptionData = Subscription::where('user_id', $userId)
                                ->where('is_first', '=', 1)
                                ->whereIn('status', [1, 2, 3, 6, 7, 8, 9])
                                ->orderBy('created_at', 'desc')->first();

        $investmentClasses = InvestmentClass::where('active', 1)->get();
        $endClass = count($investmentClasses);

        if(!empty($subscriptionData)){
            
            if ($subscriptionData->investment_class_type < $endClass) {
                return 1;//initi 
            } else {
                return 0;//additinal
            }
        } else {
            return 1;//initi
        }

        // $user_id = Auth::user()->id;
        // $subscriptionData = Subscription::where('user_id', $user_id)
        //                         ->where('is_first', '=', 1)
        //                         ->whereIn('status', [1, 2, 3, 6, 7])
        //                         ->first();

        // if(empty($subscriptionData)){
        //     return 1;//initi
        // } else {
        //     return 0;//additinal
        // }
    }

    private function checkInvestmentClass($userId) {

        $investmentClasses = InvestmentClass::where('active', 1)->pluck('id')->toArray();
        $subscriptionData = Subscription::where('user_id', $userId)
                                ->whereIn('is_first', [0, 1])
                                ->whereIn('status', [1, 2, 3, 6, 7, 8, 9])
                                ->whereIn('investment_class_type', $investmentClasses)
                                ->orderBy('created_at', 'desc')->first();

        // return $subscriptionData;
        if(empty($subscriptionData)){
            return 0; 
        } else {
            return $subscriptionData;
        }
    }
}