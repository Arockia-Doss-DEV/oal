<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Subscription;
use App\InvestmentClass;
use App\Country;
use App\User;
use App\SsDocument;
use App\Flashmsg;
use App\Newsletter;
use App\UserEmails;
use App\UserEmailRecipients;
use App\Price;
use App\UserSourceWealth;
use Image;
use Auth;
use Session;
use PDF;
use Mail;
use DB;
use Carbon\Carbon;
use App\Mail\RedemptionMailForAdmin;
use App\Mail\RedemptionRequestForUser;
use App\Mail\ChangeBankDetailsRequestForUser;
use App\Mail\ChangeBankDetailsRequestForAdmin;
use App\Mail\NewInvestmentEmail;
use App\Mail\NewInvestmentEmailForInvester;
use App\Mail\BankSlipReupload;
use App\Mail\NewAdditionalInvestmentEmailForAdmin;
use App\Mail\NewAdditionalInvestmentEmailForInvester;

class InvestorController extends Controller{
    
    /*function __construct()
    {
        $this->middleware('permission:investor-landing', ['only' => ['index']]);
        $this->middleware('permission:investor-dashboard', ['only' => ['create','store']]);
        $this->middleware('permission:investor-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:investor-delete', ['only' => ['destroy']]);
    }*/

    public function dashboard(){

        $user_id = \Auth::user()->id;
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('+2 months'));
        
        $flash_msg = Flashmsg::where('active', '=',1)
                                ->whereDate('start_date','<=', $start_date)
                                ->whereDate('end_date','>=', $start_date)
                                ->first();

        ////////////////////

        $ini_investment = Subscription::where('status', '=',3)
                                ->where('is_first','=', 1)
                                ->where('user_id','=', $user_id)
                                ->get();
        $ini_investment_count = $ini_investment->count();

        $add_investment = Subscription::where('status', '=',3)
                                ->where('is_first','=', 0)
                                ->where('user_id','=', $user_id)
                                ->get();
        $add_investment_count = $add_investment->count();


        $total_investment_count = $ini_investment_count + $add_investment_count;
        
        if($ini_investment_count != 0){
            $initial_avg = $ini_investment_count * 100 / $total_investment_count;
        }else{
            $initial_avg = 0;
        }
        
        if($add_investment_count != 0){
            $addinitial_avg = $add_investment_count * 100 / $total_investment_count;
        }else{
            $addinitial_avg = 0;
        }
        
        $initial_obj=[];
        $initial_obj[] = array(
                    'value' => number_format($initial_avg, 2),
                    'label' => "Initial Investment"
                );
        $initial_obj[] = array(
                    'value' => number_format($addinitial_avg, 2),
                    'label' => "Additional Investment"
                );

        //////////////////
        $active_investment = Subscription::where('status', '=',3)
                                ->where('user_id','=', $user_id)
                                ->get();
                                
        $total_active_investment = $active_investment->count();
                                    
        // $investmentClasses = [];                       
        // foreach ($active_investment as $key => $activeInvestment) {
        //     $investmentClasses[] = $activeInvestment->investment_class_type;  
        // }

        // $investmentClasses = array(1, 2, 2, 1, 1);
        // return array_count_values($investmentClasses);


        // return array_values(array_unique($investmentClasses));


        


        //////////////////
        $active_investment_sum = Subscription::where('status', '=',3)
                                ->where('user_id','=', $user_id)
                                ->sum('amount');
        //////////////////
        $payouts = Subscription::with(['PayoutAs'])
                                ->where('status', '=',3)
                                ->where('user_id',$user_id)
                                ->get();                       
        //////////////////

       

        return view('investor.dashboard', compact('flash_msg', 'initial_obj', 'total_active_investment', 'active_investment_sum', 'payouts'));
    }

    public function profile(){
        $user_id = \Auth::user()->id;
        $userData = User::with(['countryAs', 'stateAs'])->findOrFail($user_id);

        return view('investor.profile', ['userData' => $userData]);
    }

    //Subscription Details
    public function subscriptions(Request $request){
        
        $user_id = \Auth::user()->id;
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();

        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        $term = trim($request->input('q'));
        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.investment_no like '%".$term."%')");
        }

        $q->where('user_id', $user_id);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->latest()->paginate(20);

        // return $subscriptions;

        $investmentClasses = InvestmentClass::where('active', 1)->get();
        $endClass = count($investmentClasses);

        $check_investment = $this->checkAdditionalInvestment();
        $check_investment_class = $this->checkInvestmentClass();
        $current_investment_class = $this->currentInvestmentClass();

        // return $check_investment_class;

        return view('investor.subscriptions', [
            'subscriptions' => $subscriptions,
            'check_investment' => $check_investment,
            'investmentClasses' => $investmentClasses,
            'check_investment_class' => $check_investment_class,
            'current_investment_class' => $current_investment_class,
            'endClass' => $endClass
        ]);
    }

    public function subscriptionView($id){ 
        
        $user_id = \Auth::user()->id;
        $subscription = Subscription::with(['SsDocumentAs', 'PayoutAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])
                ->where('id',$id)
                ->where('user_id',$user_id)
                ->first();
        
        $price = Price::where('class_type', $subscription->investment_class_type)->where('active', 1)->first();

        if ($subscription->is_first == 1) {
            $subscriptions_history = Subscription::with(['SsDocumentAs', 'PayoutAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])
                ->where('investment_class_type',$subscription->investment_class_type)
                ->where('user_id',$user_id)
                ->where('id','!=' ,$subscription->id)
                ->get();
        } else {
            $subscriptions_history = null;
        }
        
        if(!$subscription){
           return redirect('/investor/subscriptions')->with('error', 'requested page not found');
        }
        return view('investor.subscriptionView',['subscription'=> $subscription, 'subscriptions_history'=> $subscriptions_history, 'price' => $price]);
    }


    public function subscriptionInitialCreate(Request $request){
        
        $user_id = \Auth::user()->id;
        $userData = User::findOrFail($user_id);
        $request->session()->forget('subscription_id');
        $additional = false;
        
        $isAdditionalClass = false;
        
        $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id',$user_id)->first();
        if(!empty($subscriptionData)){

            $request->session()->put('subscription_id', $subscriptionData->id);
            $subscription = $subscriptionData;
            $edit = true;
        }else{
            $edit = false;
            $subscription = "";
        }

        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
        // $investmentClasses = InvestmentClass::where('active', 1)->get();

        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

        $countries = Country::pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        // foreach ($phone_prefixData as $value) {
        //     if(!empty($value->calling_code)){
        //         $phone_prefix[$value->calling_code] = $value->name." +".$value->calling_code;
        //     }
        // }

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }

        $phone_prefix = array_reverse($phone_prefix,true);

        return view('investor.subscriptionCreate', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'isAdditionalClass' => @$isAdditionalClass]);
    }

    public function createNewSubscription(Request $request) {

        //additional class create function

        $classId = $request->get('classId');

        $user_id = \Auth::user()->id;
        $userData = User::findOrFail($user_id);
        $request->session()->forget('subscription_id');
        $additional = false;

        $isAdditionalClass = true;

        $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', '=', $classId)->first();

        // return $subscriptionData;

        if(!empty($subscriptionData)){

            // $request->session()->put('subscription_id', $subscriptionData->id);
            $subscription = $subscriptionData;
            $edit = true;
        } else {
            $edit = false;
            $subscription = "";
        }

        // $investmentClasses = InvestmentClass::where('active', 1)->where('id', '!=', $classId)->pluck('name', 'id');

        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');

        $subscriptionClassData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', $classId)->first();

        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

        // return $subscriptionClassData;

        $countries = Country::pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        // foreach ($phone_prefixData as $value) {
        //     if(!empty($value->calling_code)){
        //         $phone_prefix[$value->calling_code] = $value->name." +".$value->calling_code;
        //     }
        // }

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }

        $phone_prefix = array_reverse($phone_prefix,true);

        // return $edit;

        return view('investor.subscriptionAdditionClassCreate', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'subscriptionClassData' => @$subscriptionClassData, 'isAdditionalClass' => $isAdditionalClass]);

    }

    public function subscriptionSaveDraft(Request $request){

        $subscription_id = $request->session()->get('subscription_id');

        if (!empty($request->origin_fund_wealth)) {
            $origin_fund_wealth = implode(", ",$request->origin_fund_wealth);
        }

        if (!empty($request->source_of_wealth)) {
            $source_of_wealth = implode(", ",$request->source_of_wealth);
        }

        if (!empty($request->source_of_wealth_funds_comes)) {
            $source_of_wealth_funds_comes = implode(", ",$request->source_of_wealth_funds_comes);
        }

        if (!empty($request->ja_origin_fund_wealth)) {
            $ja_origin_fund_wealth = implode(", ",$request->ja_origin_fund_wealth);
        }

        if (!empty($request->ja_source_of_wealth)) {
            $ja_source_of_wealth = implode(", ",$request->ja_source_of_wealth);
        }

        if (!empty($request->ja_source_of_wealth_funds_comes)) {
            $ja_source_of_wealth_funds_comes = implode(", ",$request->ja_source_of_wealth_funds_comes);
        }

        $user_id = Auth::user()->id;

        $requestData = $request->all();
        $requestData['user_id'] = $user_id;
        $requestData['status'] = 0;
        $requestData['investment_class_type'] = $request->investment_class_type;

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        // $requestData['is_first'] = $this->checkAdditionalInvestment();


        // if (!empty($requestData['is_additional'])) {
        //     $requestData['is_first'] = 0;
        // } else {
        //     $requestData['is_first'] = $this->checkAdditionalInvestment();
        // }

        if (!empty($requestData['is_additional'])) {
            $requestData['is_first'] = 0;
        } else {
            $requestData['is_first'] = 1;
        }

        // $requestData['investment_no'] = config('settings.investment_draft_no');
        // $requestData['draft_refrence_id'] = config('settings.draft_refrence_id');

        if(!empty($subscription_id)){

            $subscription = Subscription::find($subscription_id);
            $subscription->update($requestData);
            
        } else {

            $requestData['investment_no'] = config('settings.investment_draft_no');
            $requestData['draft_refrence_id'] = config('settings.draft_refrence_id');

            $subscription = Subscription::create($requestData);
            $increntDrftNo = new User();
            $increntDrftNo->updateDraftReferenceId();
            // $increntDroftNo->updateInvestmentNoDraft();

            $this->copyDocument($subscription->id);
        }
        if($subscription->id){

            $request->session()->put('subscription_id', $subscription->id);

            return response()->json(['data' => "success", 'subscription' => $subscription], 201); 
        } else {
            return response()->json(['data' => "error"], 201); 
        }
    }

    public function subscriptionSave(Request $request){

        $subscription_id = $request->session()->get('subscription_id');
        $user_id = Auth::user()->id;

        if (!empty($request->origin_fund_wealth)) {
            $origin_fund_wealth = implode(", ",$request->origin_fund_wealth);
        }

        if (!empty($request->source_of_wealth)) {
            $source_of_wealth = implode(", ",$request->source_of_wealth);
        }

        if (!empty($request->source_of_wealth_funds_comes)) {
            $source_of_wealth_funds_comes = implode(", ",$request->source_of_wealth_funds_comes);
        }

        if (!empty($request->ja_origin_fund_wealth)) {
            $ja_origin_fund_wealth = implode(", ",$request->ja_origin_fund_wealth);
        }

        if (!empty($request->ja_source_of_wealth)) {
            $ja_source_of_wealth = implode(", ",$request->ja_source_of_wealth);
        }

        if (!empty($request->ja_source_of_wealth_funds_comes)) {
            $ja_source_of_wealth_funds_comes = implode(", ",$request->ja_source_of_wealth_funds_comes);
        }

        $requestData = $request->all();
        $requestData['user_id'] = $user_id;
        $requestData['status'] = 1;
        $requestData['investment_no'] = config('settings.investment_no');
        $requestData['investment_class_type'] = $request->investment_class_type;

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        // $requestData['is_first'] = $this->checkAdditionalInvestment();
        

        // if (!empty($requestData['is_additional'])) {
        //     $requestData['is_first'] = 0;
        // } else {
        //     $requestData['is_first'] = $this->checkAdditionalInvestment();
        // }


        if (!empty($requestData['is_additional'])) {
            $requestData['is_first'] = 0;
        } else {
            $requestData['is_first'] = 1;
        }

        // return $requestData;

        $email_status = config('settings.email_sent');

        if(!empty($subscription_id)){

            $subscription = Subscription::find($subscription_id);

            $originalImage= $request->file('file');

            $individualPepFile= $request->file('individual_pep_file');
            $individualFwFile= $request->file('individual_fw_file');
            $jointPepFile= $request->file('joint_pep_file');
            $jointFwFile= $request->file('joint_fw_file');


            if(!empty($originalImage)){
                
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = $originalImage->storeAs('manualSignedDoc', $fileName, 'public');
    
                $image_name = $filePath;
            }else{
                $image_name = "";
            }

            if(!empty($individualPepFile)){
            
                $individualPepFileName = time().'_'.$individualPepFile->getClientOriginalName();
                $individualPepFilePath = $individualPepFile->storeAs('individualPEPSignedDoc', $individualPepFileName, 'public');

                $individualPepImageName = $individualPepFilePath;
            }else{
                $individualPepImageName = "";
            }

            if(!empty($individualFwFile)){
                
                $individualFwFileName = time().'_'.$individualFwFile->getClientOriginalName();
                $individualFwFilePath = $individualFwFile->storeAs('individualFWSignedDoc', $individualFwFileName, 'public');

                $individualFwImageName = $individualFwFilePath;
            }else{
                $individualFwImageName = "";
            }

            if(!empty($jointPepFile)){
                
                $jointPepFileName = time().'_'.$jointPepFile->getClientOriginalName();
                $jointPepFilePath = $jointPepFile->storeAs('jointPEPSignedDoc', $jointPepFileName, 'public');

                $jointPepImageName = $jointPepFilePath;
            }else{
                $jointPepImageName = "";
            }

            if(!empty($jointFwFile)){
                
                $jointFwFileName = time().'_'.$jointFwFile->getClientOriginalName();
                $jointFwFilePath = $jointFwFile->storeAs('jointFWSignedDoc', $jointFwFileName, 'public');

                $jointFwImageName = $jointFwFilePath;
            }else{
                $jointFwImageName = "";
            }
            
            $requestData['manual_signed_doc'] = $image_name;
            
            $requestData['individual_pep_doc'] = $individualPepImageName;
            $requestData['individual_source_fund_doc'] = $individualFwImageName;
            $requestData['ja_pep_doc'] = $jointPepImageName;
            $requestData['ja_source_fund_doc'] = $jointFwImageName;

            $requestData['manual_signed_doc_enable'] = 1;
            
            //merge investment amout
            // $investmentType = $this->checkAdditionalInvestment();
            // if ($investmentType == 0) {
            //     $checkInvestment = new Subscription;
            //     $checkInvestment->mergeInvestmentAmount($user_id, $request->investment_class_type, $request->amount);
            // }

            $subscription->update($requestData);

        } else {

            // $requestData = $request->all();
            $subscription = Subscription::create($requestData);

            $increntNo = new User();
            $increntNo->updateInvestmentNo();
        }
        
        $increntNo = new User();
        $increntNo->updateInvestmentNo();

        $request->session()->forget('subscription_id');
        if($subscription){

            //Notification Save
            $noti_sender_user_id = Auth::user()->id;
            $noti_receiver_user_id = 1;
            $noti_link = "/subscriptionView/".$subscription->id;
            $investment_no = $subscription->investment_name . $subscription->investment_no;
            $noti_message = $investment_no." New Investment Email";
            
            $notification = new User;
            $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
            //Notification END

            //Email For admin
            $objData = new \stdClass();
            $objData->email = Auth::user()->email;
            $objData->name = Auth::user()->name;
            $objData->salutation = Auth::user()->salutation;
            $objData->investment_no = $investment_no;
            $objData->msg = "";
            $objData->link = "";
            $to_admin_email = config('settings.from_email');

            if ($email_status == 1) {
                if ($request->is_additional == 1) {
                    Mail::to($to_admin_email)->send(new NewAdditionalInvestmentEmailForAdmin($objData)); 
                } else {
                    Mail::to($to_admin_email)->send(new NewInvestmentEmail($objData));
                }
            }
            //Email admin


            //Email For Investor
            $objData = new \stdClass();
            $objData->email = Auth::user()->email;
            $objData->name = Auth::user()->name;
            $objData->salutation = Auth::user()->salutation;
            $objData->investment_no = $investment_no;
            $objData->msg = "";
            $objData->link = "";
            $to_user_email = Auth::user()->email;

            if ($email_status == 1) {
                if ($request->is_additional == 1) {
                    Mail::to($to_user_email)->send(new NewAdditionalInvestmentEmailForInvester($objData)); 
                } else {
                    Mail::to($to_user_email)->send(new NewInvestmentEmailForInvester($objData));
                }
            }
            //Email Investor

            $request->session()->put('subscription_id', $subscription->id);

            return response()->json(['data' => "success"], 201); 

        } else {

            return response()->json(['data' => "error"], 201); 
        }
    }

    public function subscriptionAdditionCreate(Request $request){
        
        $classId = $request->get('classId');
        $isAdditional = $request->get('isAdditional');
        // return $classId;

        $user_id = \Auth::user()->id;
        $userData = User::findOrFail($user_id);
        $request->session()->forget('subscription_id');
        $additional = false;
        $edit = false;
        
        $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', '=', $classId)->first();

        // $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('is_first',1)->first();
        if(!empty($subscriptionData)){

            $subscription = $subscriptionData;
            $edit = true;
        }else{
            $subscription = "";
        }

        // $investmentClasses = InvestmentClass::where('active', 1)->where('id', '!=', $classId)->pluck('name', 'id');

        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
        $subscriptionClassData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', $classId)->first();

        // $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');

        $countries = Country::pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }

        // foreach ($phone_prefixData as $value) {
        //     if(!empty($value->calling_code)){
        //         $phone_prefix[$value->calling_code] = $value->name." +".$value->calling_code;
        //     }
        // }

        $phone_prefix = array_reverse($phone_prefix,true);
        
        $check_additional = $this->checkAdditionalInvestment();
        if($check_additional == 0){
            $amount = config('settings.additional_amount');
            $additional = true;

            $initialSubscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', $classId)->whereIn('is_first',[0,1])->first();

            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', @$initialSubscriptionData->created_at);
            $from=Carbon::now();
            $diff_in_days = $to->diffInDays($from);
        }

        return view('investor.subscriptionAdditionCreate', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'subscriptionClassData' => @$subscriptionClassData, 'isAdditional' => $isAdditional, 'check_date' => @$diff_in_days]);
    }

    // public function subscriptionEdit(Request $request, $id){ 
    public function subscriptionEdit(Request $request){ 

        $subscription_id = $request->get('subId');
        $subscription_class = $request->get('classId');

        $request->session()->put('subscription_id', $subscription_id);
        $additional = false;

        $isAdditionalClass = true;

        $amount = config('settings.initial_amount');
        
        $subscription = Subscription::with(['SsDocumentAs'])->where('id',$subscription_id)->first();
        if(!$subscription){
           return redirect('/active')->with('error', 'requested page not found');
        }

        $edit = true;
        $user_id = \Auth::user()->id;
        $userData = User::findOrFail($user_id);
        $countries = Country::pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        // foreach ($phone_prefixData as $value) {
        //     if(!empty($value->calling_code)){
        //         $phone_prefix[$value->calling_code] = $value->name." +".$value->calling_code;
        //     }
        // }

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }
        
        $phone_prefix = array_reverse($phone_prefix,true);
        
        // $investmentClasses = InvestmentClass::where('active', 1)->get();
        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');

        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

        $check_additional = $this->checkAdditionalInvestment();
        if($check_additional == 0){
            $amount = config('settings.additional_amount');
            $additional = true;

            $initialSubscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', $subscription_class)->whereIn('is_first',[0,1])->first();

            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', @$initialSubscriptionData->created_at);
            $from=Carbon::now();
            $diff_in_days = $to->diffInDays($from);
        }

        // return $subscription;

        if ($subscription->is_first == 1) {
            return view('investor.subscriptionEdit', ['edit' => $edit, 'countries'=> $countries, 'phone_prefix'=> $phone_prefix, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'isAdditionalClass' => @$isAdditionalClass, 'check_date' => @$diff_in_days]);
        } else {
            return view('investor.subscriptionAdditionEdit', ['edit' => $edit, 'countries'=> $countries, 'phone_prefix'=> $phone_prefix, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'isAdditionalClass' => @$isAdditionalClass, 'check_date' => @$diff_in_days]);
        }

        
    }
    
    public function subscriptionEditSaveDraft(Request $request){
        
        $subscription_id = $request->get('subId');

        if (!empty($request->origin_fund_wealth)) {
            $origin_fund_wealth = implode(", ",$request->origin_fund_wealth);
        }

        if (!empty($request->source_of_wealth)) {
            $source_of_wealth = implode(", ",$request->source_of_wealth);
        }

        if (!empty($request->source_of_wealth_funds_comes)) {
            $source_of_wealth_funds_comes = implode(", ",$request->source_of_wealth_funds_comes);
        }

        if (!empty($request->ja_origin_fund_wealth)) {
            $ja_origin_fund_wealth = implode(", ",$request->ja_origin_fund_wealth);
        }

        if (!empty($request->ja_source_of_wealth)) {
            $ja_source_of_wealth = implode(", ",$request->ja_source_of_wealth);
        }

        if (!empty($request->ja_source_of_wealth_funds_comes)) {
            $ja_source_of_wealth_funds_comes = implode(", ",$request->ja_source_of_wealth_funds_comes);
        }

        $user_id = Auth::user()->id;

        $requestData = $request->all();
        $requestData['user_id'] = $user_id;
        $requestData['investment_class_type'] = $request->investment_class_type;

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        if(!empty($subscription_id)){
            $subscription = Subscription::find($subscription_id);
            $subscription->update($requestData);
        }
        

        if($subscription_id){

            $request->session()->put('subscription_id', $subscription_id);

            return response()->json(['data' => "success", 'subscription' => $subscription], 201); 
        } else {
            return response()->json(['data' => "error"], 201); 
        }

        // return response()->json(['data' => "success"], 201); 
       
    }

    public function subscriptionEditSave(Request $request){
        
        // return $request->all();

        $subscription_id = $request->get('subId');
        $user_id = Auth::user()->id;

        if (!empty($request->origin_fund_wealth)) {
            $origin_fund_wealth = implode(", ",$request->origin_fund_wealth);
        }

        if (!empty($request->source_of_wealth)) {
            $source_of_wealth = implode(", ",$request->source_of_wealth);
        }

        if (!empty($request->source_of_wealth_funds_comes)) {
            $source_of_wealth_funds_comes = implode(", ",$request->source_of_wealth_funds_comes);
        }

        if (!empty($request->ja_origin_fund_wealth)) {
            $ja_origin_fund_wealth = implode(", ",$request->ja_origin_fund_wealth);
        }

        if (!empty($request->ja_source_of_wealth)) {
            $ja_source_of_wealth = implode(", ",$request->ja_source_of_wealth);
        }

        if (!empty($request->ja_source_of_wealth_funds_comes)) {
            $ja_source_of_wealth_funds_comes = implode(", ",$request->ja_source_of_wealth_funds_comes);
        }
        
        $requestData = $request->all();

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;
    
        $subscription = Subscription::find($subscription_id);
        
        if($subscription->status == 0){
            $requestData['status'] = 1;    
        }

        $originalImage= $request->file('file');

        $individualPepFile= $request->file('individual_pep_file');
        $individualFwFile= $request->file('individual_fw_file');
        $jointPepFile= $request->file('joint_pep_file');
        $jointFwFile= $request->file('joint_fw_file');

        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('manualSignedDoc', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($individualPepFile)){
            
            $individualPepFileName = time().'_'.$individualPepFile->getClientOriginalName();
            $individualPepFilePath = $individualPepFile->storeAs('individualPEPSignedDoc', $individualPepFileName, 'public');

            $individualPepImageName = $individualPepFilePath;
        }else{
            $individualPepImageName = "";
        }

        if(!empty($individualFwFile)){
            
            $individualFwFileName = time().'_'.$individualFwFile->getClientOriginalName();
            $individualFwFilePath = $individualFwFile->storeAs('individualFWSignedDoc', $individualFwFileName, 'public');

            $individualFwImageName = $individualFwFilePath;
        }else{
            $individualFwImageName = "";
        }

        if(!empty($jointPepFile)){
            
            $jointPepFileName = time().'_'.$jointPepFile->getClientOriginalName();
            $jointPepFilePath = $jointPepFile->storeAs('jointPEPSignedDoc', $jointPepFileName, 'public');

            $jointPepImageName = $jointPepFilePath;
        }else{
            $jointPepImageName = "";
        }

        if(!empty($jointFwFile)){
            
            $jointFwFileName = time().'_'.$jointFwFile->getClientOriginalName();
            $jointFwFilePath = $jointFwFile->storeAs('jointFWSignedDoc', $jointFwFileName, 'public');

            $jointFwImageName = $jointFwFilePath;
        }else{
            $jointFwImageName = "";
        }
        
        $requestData['manual_signed_doc'] = $image_name;
        $requestData['individual_pep_doc'] = $individualPepImageName;
        $requestData['individual_source_fund_doc'] = $individualFwImageName;
        $requestData['ja_pep_doc'] = $jointPepImageName;
        $requestData['ja_source_fund_doc'] = $jointFwImageName;

        $requestData['manual_signed_doc_enable'] = 1;
        $requestData['investment_class_type'] = $request->investment_class_type;

        $subscription->update($requestData);

        $email_status = config('settings.email_sent');
        
        if($subscription){
            //Notification Save
            $noti_sender_user_id = Auth::user()->id;
            $noti_receiver_user_id = 1;
            $noti_link = "/subscriptionView/".$subscription->id;
            $investment_no = $subscription->investment_name . $subscription->investment_no;
            $noti_message = $investment_no." New Investment Email";
            
            $notification = new User;
            $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
            //Notification END

            //Email For admin
            $objData = new \stdClass();
            $objData->email = Auth::user()->email;
            $objData->name = Auth::user()->name;
            $objData->salutation = Auth::user()->salutation;
            $objData->investment_no = $investment_no;
            $objData->msg = "";
            $objData->link = "";
            $to_email = config('settings.from_email');

            if ($email_status == 1) {
                Mail::to($to_email)->send(new NewInvestmentEmail($objData));
            }            
            //Email admin


            //Email For Investor
            $objData = new \stdClass();
            $objData->email = Auth::user()->email;
            $objData->name = Auth::user()->name;
            $objData->salutation = Auth::user()->salutation;
            $objData->investment_no = $investment_no;
            $objData->msg = "";
            $objData->link = "";
            $to_email = Auth::user()->email;

            if ($email_status == 1) {
                Mail::to($to_email)->send(new NewInvestmentEmailForInvester($objData));
            }
            //Email Investor

            $request->session()->put('subscription_id', $subscription->id);
            return response()->json(['data' => "success"], 201); 
        }else{

            return response()->json(['data' => "error"], 201); 
        }
          
    }

    //Investment Details End


    //Newslatter Details
    public function newsletters(){
        
        $news = Newsletter::where('active', '=',1)->latest()->paginate(10);
        return view('investor.newsletters.index',compact('news'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }


    public function newsletterShow($id){

        $news = Newsletter::where('active', '=',1)->where('id',$id)->first();
        if(!$news){
           return redirect('/investor/newsletters')->with('error', 'requested page not found');
        }

        return view('investor.newsletters.show',compact('news'));
    }
    //Newslatter Details End


    public function messages(){

        $user_id = Auth::user()->id;
        $messages = UserEmailRecipients::with('user_emailAs')->where('user_id', $user_id)->latest()->paginate(10);

        return view('investor.messages.index',compact('messages'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function messagesShow($id){

        $user_id = Auth::user()->id;
        $msg = UserEmails::with('recipientAs')->where('id',$id)->first();
        if(!$msg){
           return redirect('/investor/messages')->with('error', 'requested page not found');
        }

        return view('investor.messages.show',compact('msg'));
    }

    //Flash Messages Details
    public function flashmsgs(Request $request){
        
        $flashmsgs = Flashmsg::where('active', '=',1)->latest()->paginate(10);
            return view('investor.flashmsgs.index',compact('flashmsgs'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function flashmsgView(Request $request, $id){
        
        $flashmsg = Flashmsg::where('active',1)->where('id',$id)->first();
        if(!$flashmsg){
           return redirect('/flashmsgs')->with('error', 'requested page not found');
        }

        return view('investor.flashmsgs.show',compact('flashmsg'));
    }
    //Flash Messages Details End

    public function settings(){
        
        $user = Auth::user();

        if($user["2fa_status"] == 1){
            $google2fa_secret = "";
            $qr_image = "";
            $fa_status = true;

        }else{
            $google2fa = app('pragmarx.google2fa');
            $google2fa_secret = $google2fa->generateSecretKey();

            $qr_image = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $google2fa_secret
            );
            $fa_status = false;
        }

        return view('investor.settings', ['google2fa_secret' => $google2fa_secret, 'qr_image' => $qr_image, 'fa_status' => $fa_status]);
    }

    public function changePassword(Request $request){
        
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
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
        $user = Auth::user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function enable2Fa(Request $request){

        $user = Auth::user();
        $userstatus =  $user['2fa_status'];
        $userkey =  $user['2fa_key'];

        if($userstatus==1 && $userkey!="") {

            return response()->json(['data' => "2"], 201); 
        }else{

            $secret = $request->input('secretcode');
            $oneCode = $request->input('code');

            $google2fa = app('pragmarx.google2fa');
            $valid = $google2fa->verifyKey($secret, $oneCode, 2); // 2 = 2*30sec clock tolerance
            if ($valid) {
                $user['2fa_key'] =  $secret;
                $user['2fa_status'] = 1;
                $user->save();

                return response()->json(['data' => "0"], 201);
            }else {
                //$this->Flash->error(__('Wrong code entered.Please try again.'));
                return response()->json(['data' => "1"], 201);
            }

            return response()->json(['data' => "51"], 201);
        }
    }

    public function disable2Fa(Request $request){

        if($request->input('disable') == "disable"){
            $user = Auth::user();
            $user['2fa_key'] =  "";
            $user['2fa_status'] = 0;   
            $user->save();
            return response()->json(['data' => "success"], 201);
        }     
        return response()->json(['data' => "error"], 201);     
    }

    public function signedPdf(Request $request, $id){

        $user_id = Auth::user()->id;
        $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$id)->first();

        if(empty($subscription)){
            return redirect()->back()->with("success","Your requested data not found");
        }

        $currency_word = $this->convert_number_to_words($subscription->amount);
        if ($subscription->is_first == 1) {
            $pdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word'));
        } else {
            $pdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word'));
        }

        // $pdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word'));
        //return $pdf->download('userlist.pdf');
        
        return $pdf->inline();
    }

    public function signedPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');

        // return $subscription_id;
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            // $user_id = Auth::user()->id;
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
    
            $currency_word = $this->convert_number_to_words($subscription->amount);
            
            if ($subscription->is_first == 1) {
                $pdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word'));
            } else {
                $pdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word'));
            }
            
            return $pdf->download('signed-application.pdf');
        }else{
            return "";
        }
    }

    public function pepPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');

        // return $subscription_id;
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            // $user_id = Auth::user()->id;
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
            
            $pdf = PDF::loadView('pdf.PEPDeclarationPdf', compact('subscription'));
            
            return $pdf->inline();
            // return $pdf->download('Individual-PEP-Application.pdf');

        }else{
            return "";
        }
    }

    public function fundPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
            
            $pdf = PDF::loadView('pdf.sourceOfFundPdf', compact('subscription'));
            
            return $pdf->inline();
            // return $pdf->download('Individual-source-of-wealth-application.pdf');

        }else{
            return "";
        }
    }

    public function pepJointPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
            
            $pdf = PDF::loadView('pdf.jointPEPDeclarationPdf', compact('subscription'));
            
           return $pdf->download('Joint-PEP-Application.pdf');

        }else{
            return "";
        }
    }

    public function fundJointPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
            
            $pdf = PDF::loadView('pdf.jointSourceOfFundPdf', compact('subscription'));
            
            // return $pdf->inline();
            return $pdf->download('Joint-source-of-wealth-application.pdf');

        }else{
            return "";
        }
    }


    public function bankPdf(Request $request, $id){

        $user_id = Auth::user()->id;
        $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$id)->first();

        if(empty($subscription)){
            return redirect()->back()->with("success","Your requested data not found");
        }

        $currency_word = $this->convert_number_to_words($subscription->amount);

        $pdf = PDF::loadView('pdf.bankPdf', compact('subscription', 'currency_word'));
        //return $pdf->download('userlist.pdf');
        return $pdf->inline();
    }

    public function uploadBankslip(){

        $user_id = Auth::user()->id;
        $subscriptions = Subscription::with(['SsDocumentAs'])->where(['user_id' => $user_id, 'bank_doc_request' => 1])->get();

        return view('investor.bankslip')->with('subscriptions',$subscriptions);
    }
    
    public function uploadBankslipSave(Request $request){

        $user_id = Auth::user()->id;
        $subscription_id = $request->get('sub_att_id');

        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('ssattachment', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($subscription_id)){

            $requestData = $request->all();
            $requestData['subscription_id'] = $subscription_id;
            $requestData['main_type'] = 7;
            $requestData['sub_type'] = 71;
            $requestData['file'] = $image_name;
            $requestData['remarks'] = "Bank Slip";

            $ssDocumentData = SsDocument::where(['subscription_id' => $subscription_id, 'main_type' => 7, 'sub_type' => 71])->first();

            if(!empty($ssDocumentData)){

                $ssDocument = SsDocument::find($ssDocumentData->id);
                $ssDocument->update($requestData);
            }else{

                $ssDocument = SsDocument::create($requestData);
            }   

            //Notification Save
            $subscription = Subscription::find($subscription_id);
            $noti_sender_user_id = $user_id;
            $noti_receiver_user_id = 1;
            $noti_link = "/subscriptionView/".$subscription->id;
            $investment_no = $subscription->investment_name . $subscription->investment_no;
            $noti_message = $investment_no." The Bank Slip";
            
            $notification = new User;
            $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
            //Notification END

            $requestData = $request->all();
            $requestData['bank_doc_request_hidden'] = 1;
            $subscription->update($requestData);


            //Email Save
            $objData = new \stdClass();
            $objData->email = Auth::user()->email;
            $objData->name = Auth::user()->name;
            $objData->salutation = Auth::user()->salutation;
            $objData->investment_no = $investment_no;
            $objData->msg = "";
            $objData->link = "";
            $to_email = config('settings.from_email');

            $email_status = config('settings.email_sent');
            if ($email_status == 1) {
                Mail::to($to_email)->send(new BankSlipReupload($objData));
            }

            //Email Save

            return response()->json(['data' => "success"], 201);   
        }
    }

    public function bankingDetailsPdfDownload(Request $request, $id){

        $subscription_id = $id;
        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);
        if(!empty($subscription_id)){

            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
    
            $currency_word = $this->convert_number_to_words($subscription->amount);
            
            // if ($subscription->is_first == 1) {
            //     $pdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word', 'user_id'));
            // } else {
            //     $pdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word', 'user_id'));
            // }

            $pdf = PDF::loadView('pdf.bankDetailsPdf', compact('subscription', 'currency_word', 'user'));
            
            return $pdf->download('bank-details-update-form.pdf');

            // return $pdf->inline('bank-details-update-form.pdf');

        }else{
            return "";
        }
    }

    public function changeBankDetailsUpload(Request $request){

        $user_id = Auth::user()->id;
        $id = $request->get('sub_att_id');

        $subscription = Subscription::where('user_id', $user_id)->where('id',$id)->first();
                        
        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('bank_details', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }
         
        $subscription->changebank_file = $image_name;
        $subscription->changebank_request = 1;
        $subscription->changebank_status = 0;
        $subscription->changebank_msg = "";
        $subscription->save();

        //Notification Save
        $noti_sender_user_id = $user_id;
        $noti_receiver_user_id = 1;
        $noti_link = "/subscriptionView/".$subscription->id;
        $investment_no = $subscription->investment_name . $subscription->investment_no;
        $noti_message = $investment_no." The Bank Details Change Request";
        
        $notification = new User;
        $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
        //Notification END


        //Email Save
        $objData = new \stdClass();
        $objData->email = Auth::user()->email;
        $objData->name = Auth::user()->name;
        $objData->salutation = Auth::user()->salutation;
        $objData->investment_no = $investment_no;
        $objData->msg = "";
        $objData->link = "";
        $to_email = config('settings.from_email');

        $email_status = config('settings.email_sent');
        if ($email_status == 1) {
            
            Mail::to(Auth::user()->email)->send(new ChangeBankDetailsRequestForUser($objData));
            Mail::to($to_email)->send(new ChangeBankDetailsRequestForAdmin($objData));
        }
        
        //Email Save

        return response()->json(['data' => "success"], 201);   
    }

    public function redemptionPdfDownload(Request $request, $id){

        $subscription_id = $id;
        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);
        if(!empty($subscription_id)){

            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
    
            $currency_word = $this->convert_number_to_words($subscription->amount);
            
            // if ($subscription->is_first == 1) {
            //     $pdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word', 'user_id'));
            // } else {
            //     $pdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word', 'user_id'));
            // }

            $pdf = PDF::loadView('pdf.redemptionPdf', compact('subscription', 'currency_word', 'user'));
            
            return $pdf->download('redemption-form.pdf');

            // return $pdf->inline('redemption-form.pdf');

        }else{
            return "";
        }
    }

    public function redemptionUpload(Request $request){

        $user_id = Auth::user()->id;
        $id = $request->get('sub_att_id');

        $subscription = Subscription::where('user_id', $user_id)->where('id',$id)->first();
                        
        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('redemption', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }
         
        $subscription->redemption_file = $image_name;
        $subscription->redemption_request = 1;
        $subscription->redemption_status = 0;
        $subscription->redemption_msg = "";
        $subscription->save();

        //Notification Save
        $noti_sender_user_id = $user_id;
        $noti_receiver_user_id = 1;
        $noti_link = "/subscriptionView/".$subscription->id;
        $investment_no = $subscription->investment_name;
        $noti_message = $investment_no." The Redemption Request";
        
        $notification = new User;
        $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
        //Notification END


        //Email Save
        $objData = new \stdClass();
        $objData->email = Auth::user()->email;
        $objData->name = Auth::user()->name;
        $objData->salutation = Auth::user()->salutation;
        $objData->investment_no = $investment_no;
        $objData->msg = "";
        $objData->link = "";
        $to_email = config('settings.from_email');

        $email_status = config('settings.email_sent');
        if ($email_status == 1) {
            
            Mail::to(Auth::user()->email)->send(new RedemptionRequestForUser($objData));
            Mail::to($to_email)->send(new RedemptionMailForAdmin($objData));
        }
        
        //Email Save

        return response()->json(['data' => "success"], 201);   
    }


    public function reinvestRequest(Request $request, $id){

        $user_id = Auth::user()->id;
        $subscription = Subscription::where('user_id', $user_id)->where('id',$id)->first();

        $subscription->reinvestment_request = 1;
        $subscription->save();

        //Notification Save
        $noti_sender_user_id = $user_id;
        $noti_receiver_user_id = 1;
        $noti_link = "/subscriptionView/".$subscription->id;
        $investment_no = $subscription->investment_name;
        $noti_message = $investment_no." The Re-Investment Request";
        
        $notification = new User;
        $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
        //Notification END

        return response()->json(['data' => "success"], 201);   

    }

    public function getUserSubscription(Request $request){

        $subscription_id = $request->get('subscription_id');
        $subscription = Subscription::where('id', $subscription_id)->first();
        // $subscription = Subscription::where('id', 214)->first();

        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

        if(@$subscription->is_joint_account == 1){

            $is_joint = false;
            $jointWealthDocuments = "";

            $principle_sw_option = explode(', ', $subscription->source_of_wealth);

            if (!empty($subscription->source_of_wealth_other)) {
                $principle_sw_option[] = $subscription->source_of_wealth_other;
            }

            foreach ($userSourceWealthDocuments as $key => $userSourceWealth) {
            
                if (in_array($userSourceWealth->name, $principle_sw_option)) {
                    
                    if ($userSourceWealth->name != "Other") {
                        $principleWealthDocuments[] = $userSourceWealth;
                    }
                }
            }
            
        } elseif(@$subscription->is_joint_account == 2) {
            
            $is_joint = true;

            ///////////// principle account //////////////

            $principle_sw_option = explode(', ', $subscription->source_of_wealth);

            if (!empty($subscription->source_of_wealth_other)) {
                $principle_sw_option[] = $subscription->source_of_wealth_other;
            }

            foreach ($userSourceWealthDocuments as $key => $userSourceWealth) {
            
                if (in_array($userSourceWealth->name, $principle_sw_option)) {
                    
                    if ($userSourceWealth->name != "Other") {
                        $principleWealthDocuments[] = $userSourceWealth;
                    }
                }
            }

            ///////////// principle account //////////////

            ///////////// joint account //////////////

            $joint_sw_option = explode(', ', $subscription->ja_source_of_wealth);

            if (!empty($subscription->ja_source_of_wealth_other)) {
                $joint_sw_option[] = $subscription->ja_source_of_wealth_other;
            }

            foreach ($userSourceWealthDocuments as $key => $jointUserSourceWealth) {
            
                if (in_array($jointUserSourceWealth->name, $joint_sw_option)) {
                    
                    if ($jointUserSourceWealth->name != "Other") {
                        $jointWealthDocuments[] = $jointUserSourceWealth;
                    }
                }
            }

            ///////////// joint account //////////////
        }

        // return $principleWealthDocuments;

        return response()->json(['data' => "success", 'is_joint' => @$is_joint, 'principleWealthDocuments' => @$principleWealthDocuments, 'jointWealthDocuments' => @$jointWealthDocuments], 201);
    }

    public function signedPdfApplicationsDownload(Request $request){

        $subscription_id = $request->input('subscriptionId');
        $user_id = Auth::user()->id;

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $user_id)->where('id',$subscription_id)->first();
    
            if(empty($subscription)){
                return "";
            }
    
            $currency_word = $this->convert_number_to_words($subscription->amount);

            //define PDF's paths

            if ($subscription->is_joint_account == 1) {

                $is_joint_applicant=false;

                ///////////////////////////////////////////////////////////////////////////////////

                if ($subscription->is_first == 1) {
                    $investmentPdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word'));
                } else {
                    $investmentPdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word'));
                }

                $investmentPdfPath = public_path('pdf/investmentPdf');
                $investmentPdfFile = 'signed-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/investmentPdf/'.$investmentPdfFile))) {
                    \File::delete(public_path('pdf/investmentPdf/'.$investmentPdfFile));
                }
                $investmentPdf->save($investmentPdfPath . '/' . $investmentPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////


                // $pepDeclarationPdf = PDF::loadView('pdf.PEPDeclarationPdf', compact('subscription'));

                // $principalPEPDeclarationPdfPath = public_path('pdf/principalPEPDeclarationPdf');
                // $principalPEPDeclarationPdfFile = 'principal-pep-application-'.$subscription_id.'.'. 'pdf';
                

                // if (\File::exists(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile))) {
                //     \File::delete(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile));
                // }
                // $pepDeclarationPdf->save($principalPEPDeclarationPdfPath . '/' . $principalPEPDeclarationPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////


                // $sourceOfFundPdf = PDF::loadView('pdf.sourceOfFundPdf', compact('subscription'));

                // $principalSourceOfFundPdfFile = 'principal-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';
                // $principalsourceOfFundPdfPath = public_path('pdf/principalSourceOfFundPdf');

                // if (\File::exists(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile))) {
                //     \File::delete(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile));
                // }
                // $sourceOfFundPdf->save($principalsourceOfFundPdfPath . '/' . $principalSourceOfFundPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////

                if(!empty($investmentPdfFile)){
                   $pdfDocs['investmentPdf'] = "pdf/investmentPdf/".$investmentPdfFile;

                   // $pdfDocs['principalPEPDeclarationPdf'] = "pdf/principalPEPDeclarationPdf/".$principalPEPDeclarationPdfFile;
                   // $pdfDocs['principalSourceOfFundPdf'] = "pdf/principalSourceOfFundPdf/".$principalSourceOfFundPdfFile;
                }

            } elseif($subscription->is_joint_account == 2) {

                $is_joint_applicant=true;

                ///////////////////////////////////////////////////////////////////////////////////


                if ($subscription->is_first == 1) {
                    $investmentPdf = PDF::loadView('pdf.singedPdf', compact('subscription', 'currency_word'));
                } else {
                    $investmentPdf = PDF::loadView('pdf.additionalSingedPdf', compact('subscription', 'currency_word'));
                }

                $investmentPdfPath = public_path('pdf/investmentPdf');
                $investmentPdfFile = 'signed-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/investmentPdf/'.$investmentPdfFile))) {
                    \File::delete(public_path('pdf/investmentPdf/'.$investmentPdfFile));
                }
                $investmentPdf->save($investmentPdfPath . '/' . $investmentPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////


                // $pepDeclarationPdf = PDF::loadView('pdf.PEPDeclarationPdf', compact('subscription'));

                // $principalPEPDeclarationPdfPath = public_path('pdf/principalPEPDeclarationPdf');
                // $principalPEPDeclarationPdfFile = 'principal-pep-application-'.$subscription_id.'.'. 'pdf';

                // if (\File::exists(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile))) {
                //     \File::delete(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile));
                // }
                // $pepDeclarationPdf->save($principalPEPDeclarationPdfPath . '/' . $principalPEPDeclarationPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////


                // $sourceOfFundPdf = PDF::loadView('pdf.sourceOfFundPdf', compact('subscription'));

                // $principalsourceOfFundPdfPath = public_path('pdf/principalSourceOfFundPdf');
                // $principalSourceOfFundPdfFile = 'principal-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';

                // if (\File::exists(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile))) {
                //     \File::delete(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile));
                // }
                // $sourceOfFundPdf->save($principalsourceOfFundPdfPath . '/' . $principalSourceOfFundPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////


                // $jointPEPDeclarationPdf = PDF::loadView('pdf.jointPEPDeclarationPdf', compact('subscription'));

                // $jointPEPDeclarationPdfPath = public_path('pdf/jointPEPDeclarationPdf');
                // $jointPEPDeclarationPdfFile = 'joint-pep-application-'.$subscription_id.'.'. 'pdf';

                // if (\File::exists(public_path('pdf/jointPEPDeclarationPdf/'.$jointPEPDeclarationPdfFile))) {
                //     \File::delete(public_path('pdf/jointPEPDeclarationPdf/'.$jointPEPDeclarationPdfFile));
                // }
                // $jointPEPDeclarationPdf->save($jointPEPDeclarationPdfPath . '/' . $jointPEPDeclarationPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////


                // $jointSourceOfFundPdf = PDF::loadView('pdf.jointSourceOfFundPdf', compact('subscription'));

                // $jointSourceOfFundPdfPath = public_path('pdf/jointSourceOfFundPdf');
                // $jointSourceOfFundPdfFile = 'joint-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';

                // if (\File::exists(public_path('pdf/jointSourceOfFundPdf/'.$jointSourceOfFundPdfFile))) {
                //     \File::delete(public_path('pdf/jointSourceOfFundPdf/'.$jointSourceOfFundPdfFile));
                // }
                // $jointSourceOfFundPdf->save($jointSourceOfFundPdfPath . '/' . $jointSourceOfFundPdfFile);


                ///////////////////////////////////////////////////////////////////////////////////

                
                // return $pdf->download('signed-application.pdf');


                if(!empty($investmentPdfFile)){
                   $pdfDocs['investmentPdf'] = "pdf/investmentPdf/".$investmentPdfFile;
                   
                   // $pdfDocs['principalPEPDeclarationPdf'] = "pdf/principalPEPDeclarationPdf/".$principalPEPDeclarationPdfFile;
                   // $pdfDocs['principalSourceOfFundPdf'] = "pdf/principalSourceOfFundPdf/".$principalSourceOfFundPdfFile;
                   // $pdfDocs['jointPEPDeclarationPdf'] = "pdf/jointPEPDeclarationPdf/".$jointPEPDeclarationPdfFile;
                   // $pdfDocs['jointSourceOfFundPdf'] = "pdf/jointSourceOfFundPdf/".$jointSourceOfFundPdfFile;
                }

            }

            return response()->json(['data' => "success", 'is_joint_applicant' => $is_joint_applicant, 'pdfDocs' => $pdfDocs, 'subscription_id' => $subscription_id], 201);  

        }else{
            return "";
        }
    }

    private function copyDocument($subscription_id) {
        
        $user_id = \Auth::user()->id;
        $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id',$user_id)->where('is_first',1)->first();
    
        if(!empty($subscriptionData['SsDocumentAs'])){
            $ssDocumentAs = $subscriptionData['SsDocumentAs'];
            foreach ($ssDocumentAs as $document) {
                      
                $id = $document['id'];
                $main_type = $document['main_type'];
                $sub_type = $document['sub_type'];
                $file = $document['file'];
                $name = $document['remarks'];
                
                $requestData = new SsDocument;
                $requestData->subscription_id = $subscription_id;
                $requestData->main_type = $main_type;
                $requestData->sub_type = $sub_type;
                $requestData->file = $file;
                $requestData->remarks = $name;
                $requestData->save();
            }
        }
    }

    private function copyExistDocument($old_subscription_id, $subscription_id) {

        $check_empty = SsDocument::where('subscription_id', $subscription_id)->first();

        if(empty($check_empty)){

            $attachments = SsDocument::where('subscription_id', $old_subscription_id)->get();
            foreach ($attachments as $data) {
                $id = $data->id;
                $main_type = $data->main_type;
                $sub_type = $data->sub_type;
                $file = $data->file;
                $remarks = $data->remarks; 

                $newSsDocument = new SsDocument;
                $newSsDocument->subscription_id = $subscription_id;
                $newSsDocument->main_type = $main_type;
                $newSsDocument->sub_type = $sub_type;
                $newSsDocument->file = $file;
                $newSsDocument->remarks = $remarks;
                $newSsDocument->save();
            }
        }
    }
    
    private function checkAdditionalInvestment() {
        
        $user_id = Auth::user()->id;
        $subscriptionData = Subscription::where('user_id', $user_id)
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

    private function checkInvestmentClass() {

        $user_id = Auth::user()->id;

        $investmentClasses = InvestmentClass::where('active', 1)->pluck('id')->toArray();
        $subscriptionData = Subscription::where('user_id', $user_id)
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

    private function currentInvestmentClass() {

        $user_id = Auth::user()->id;
        $subscriptionData = Subscription::where('user_id', $user_id)
                                ->whereIn('status', [1, 2, 3, 6, 7, 8, 9])
                                ->latest('created_at')
                                ->first();
        $data = [];
        if(empty($subscriptionData)){
            
            $data['class_type'] = 1;
            $data['is_first'] = 1;

            return $data;

        } elseif ($subscriptionData->is_first == 1 and $subscriptionData->investment_class_type == 1) {
            $data['class_type'] = 1;
            $data['is_first'] = 0;

            return $data;

        } elseif ($subscriptionData->is_first == 1 and $subscriptionData->investment_class_type == 2) {
            $data['class_type'] = 2;
            $data['is_first'] = 0;

            return $data;

        } elseif ($subscriptionData->is_first == 0 and $subscriptionData->investment_class_type == 1) {
            $data['class_type'] = 1;
            $data['is_first'] = 1;

            return $data;

        } elseif ($subscriptionData->is_first == 0 and $subscriptionData->investment_class_type == 2) {
            $data['class_type'] = 2;
            $data['is_first'] = 1;

            return $data;
        }
    }

    private function convert_number_to_words($num) {

        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion', 'quindecillion','sexdecillion','septendecillion','octodecillion','novemdecillion', 'vigintillion');
        
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }



    public function findQuarter() {

        $start_date = date('Y') . '-01-01';
        $end_date = date('Y') . '-12-31';

        $months = [
            "January" => [
                "January",
                "February",
                "March"
            ],
                  
            "April" => [
                "April",
                "May",
                "June"
            ],

            "July" => [
                "July",
                "August",
                "September"
            ],

            "October" => [
                "October", 
                "November",
                "December"
            ],
        ];

        $currentDate = date('F');

        foreach ($months as $key => $month) {
            if (in_array($currentDate, $month)) {

                $year = $key . date(' d Y');

                $payment_date = strtotime($year);

                $month_firstdate = strtotime(date("Y-m-d", $payment_date));

                echo date('D\, jS  F Y', $month_firstdate);

                // echo $date = strtotime($todayDate);
            }
        }

    }
}
