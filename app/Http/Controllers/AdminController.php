<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Subscription;
use App\InvestmentClass;
use App\UserSourceWealth;
use App\Country;
use App\User;
use App\Setting;
use App\SsDocument;
use App\Payout;
use App\Price;
use Image;
use Auth;
use Session;
use PDF;
use Mail;
use DB;
use File;
use Carbon\Carbon;
use App\Helper\ViewHelper;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Mail\ActiveInvestmentMail;
use App\Mail\ChangeBankDetailsUpdateEmail;
use App\Mail\BankSlipConfirmEmail;
use App\Mail\RedemptionApproval;
use App\Mail\RedemptionReject;
use App\Mail\InvestmentRejectMail;
use App\Mail\PendingFundingMail;
use App\Mail\FundReceivedMail;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Faker\Factory as Faker;

class AdminController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        //////////////////
        $draft_investment = Subscription::where('status', '=',0)
                                ->get();
        $total_draft = $draft_investment->count();
        //////////////////

        // Total Pending

        // $pending_investment = Subscription::where('status', '=',1)
        //                         ->get();
        // $total_pending = $pending_investment->count();

        $pending_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 1)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_pending = $pending_investment->count();

        //////////////////

        // Total Pending Funding

        // $pending_funding_investment = Subscription::where('status', '=',2)
        //                         ->get();
        // $total_pending_funding = $pending_funding_investment->count();

        $pending_funding_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 2)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_pending_funding = $pending_funding_investment->count();

        //////////////////

        // Total activeinvestments

        // $active_investment = Subscription::where('status', '=',3)
        //                         ->get();
        // $total_active = $active_investment->count();

        $active_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 3)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_active = $active_investment->count();

        // Total initial investments
        $initial_active_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 3)
            ->where('is_first', 1)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_initial = $initial_active_investment->count();

        // Total additional investments
        $additional_active_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 3)
            ->where('is_first', 0)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_additional = $additional_active_investment->count();

        // Total joint investments
        $additional_active_joint_investment = Subscription::with(['UserAs'])
            ->whereHas('UserAs', function($q) {
                $q->where('role_id', '=', 3);
            })
            ->where('status', 3)
            ->where('is_joint_account', 2)
            ->where('reinvestment_status', 0)
            ->where('draft_delete', 0)
            ->get();

        $total_joint = $additional_active_joint_investment->count();


        // Total active investors
        $groupSubCond1[] = [
            ['is_first', '=', 1],
            ['status', '=', 3],
        ];

        $groupSubCond2[] = [
            ['is_first', '=', 0],
            ['status', '=', 3],
        ];

        $total_active_investors = User::with('subscriptions')
            ->whereHas('subscriptions', function ($query) use($groupSubCond1, $groupSubCond2) {
                $query->where([$groupSubCond1]);
                $query->orWhere([$groupSubCond2]);
                // $query->orWhere([$groupSubCond3]);
            })
            ->where('active', 1)
            ->where('email_verified', 1)
            ->where('role_id', '=', 3)
            ->count();


        $groupSubCond3[] = [
            ['is_first', '=', 1],
            ['status', '!=', 3],
        ];

        $groupSubCond4[] = [
            ['is_first', '=', 0],
            ['status', '!=', 3],
        ];

        $total_inactive_investors = User::with(['subscriptions'])
            ->whereHas('subscriptions', function ($query) use($groupSubCond3, $groupSubCond4) {
                // $query->where([$groupSubCond3]);
                $query->orWhere([$groupSubCond4]);
            })
            
            ->where('active', 1)
            ->where('email_verified', 0)
            ->where('role_id', '=', 3)
            ->count();

        
        //////////////////+
        $rejected_investment = Subscription::where('status', '=',5)
                                ->get();
        $total_rejected = $rejected_investment->count();
        //////////////////


        //////////////////////////////////////////////

        // month wise initial investment chart

        $month_wise_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '=', 3);
            })
            ->select(
                DB::raw("(sum(amount)) as amount"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['is_first'=>1])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->latest()->take(12)->get();

        $investment_amount_rows=[];
        $investment_month_rows2=[]; 
        $investment_month_rows = []; 

        foreach ($month_wise_investment as $key => $value) {

            $investment_amount_rows[]=$value['amount'];
            $investment_month_rows2[]= $value['month'];
        }

        usort($investment_month_rows2 , function($a, $b){
                $a = strtotime($a);
                $b = strtotime($b);
                return $a - $b;
            });

        foreach ($investment_month_rows2 as $key => $value) {
            $monthName = strtotime($value);
            $monthName2 = date("M", $monthName);
            $investment_month_rows[]= $monthName2;
        }

        //////////////////////////////////////////////

        // month wise additional investment chart

        $month_wise_add_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '=', 3);
            })
            ->select(
                DB::raw("(sum(amount)) as amount"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['is_first'=>0])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->latest()->take(12)->get();

        $addinvestment_amount_rows=[];
        $addinvestment_month_rows=[];  
        $addinvestment_month_rows2=[];

        foreach ($month_wise_add_investment as $key => $value) {
            $addinvestment_amount_rows[]=$value['amount'];
            $addinvestment_month_rows2[]= $value['month'];
        }

        usort( $addinvestment_month_rows2 , function($a, $b){
                $a = strtotime($a);
                $b = strtotime($b);
                return $a - $b;
            });

        foreach ($addinvestment_month_rows2 as $key => $value) {
            $monthName = strtotime($value);
            $monthName2 = date("M", $monthName);
            $addinvestment_month_rows[]= $monthName2;
        }

        /////////////////////////////////////////////////

        // month wise new investments chart

        $month_wise_new_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '=', 3);
            })
            ->select(
                DB::raw("(count(id)) as count"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->latest()->take(12)->get();

        $month_wise_new_investment_rows2=[];
        $month_wise_new_investment_rows = [];

        foreach ($month_wise_new_investment as $key => $value) {
            $monthName = $value['month'];
        

            $month_wise_new_investment_rows2[] = array(
                    'a' => $value['count'],
                    'y' => $monthName
                );
        }

        usort($month_wise_new_investment_rows2 , function($a, $b){
            $a = strtotime($a['y']);
            $b = strtotime($b['y']);
            return $a - $b;
        });

        foreach ($month_wise_new_investment_rows2 as $key => $value) {
            $monthName = strtotime($value['y']);
            $monthName2 = date("M", $monthName);
            $month_wise_new_investment_rows[]= array(
                    'a' => $value['a'],
                    'y' => $monthName2
                );
        }


        ////////////////////////////////////////////////////

        //subscription year

        $subscription_years= Subscription::select(DB::raw('YEAR(created_at) year'))
                ->distinct()
                ->get(['year']);

        // return $investment_month_rows;

        /////////////////////////////////////////////////

        return view('admin.dashboard',compact('total_draft', 'total_pending', 'total_pending_funding', 'total_active', 'total_initial', 'total_additional', 'total_joint', 'total_active_investors', 'total_inactive_investors', 'investment_month_rows', 'investment_amount_rows', 'addinvestment_month_rows', 'addinvestment_amount_rows', 'month_wise_new_investment_rows', 'total_rejected', 'subscription_years'));
    }

    public function draft(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');
        
        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 0);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(10);


        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 0)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 0])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.draft', compact('subscriptions', 'investmentClasses'));
    }

    public function pending(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');
    
        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 1);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::with('InvestmentClassAs')->where(function ($query) use ($search){
        //         $query->where('status', '=', 1)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::with('InvestmentClassAs')->where(['status' => 1])->latest()->paginate(10);
        // }

        // return $subscriptions;
        
        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.pending', compact('subscriptions', 'investmentClasses'));
    }

    public function pendingFunding(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 2);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 2)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 2])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.pendingFunding', compact('subscriptions', 'investmentClasses'));
    }

    public function fundReceived(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 9);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.fundReceived', compact('subscriptions', 'investmentClasses'));
    }

    public function active(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 3);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 3)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 3])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.active', compact('subscriptions', 'investmentClasses'));

        // return view('admin.active')->with('subscriptions',$subscriptions);
    }

    public function deactive(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 4);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.deactive', compact('subscriptions', 'investmentClasses'));


        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 4)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 4])->latest()->paginate(10);
        // }

        // return view('admin.deactive')->with('subscriptions',$subscriptions);
    }

    public function rejected(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 5);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);


        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 5)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 5])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.rejected', compact('subscriptions', 'investmentClasses'));
    }

    public function matured(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 6);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);


        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 6)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 6])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.matured', compact('subscriptions', 'investmentClasses'));
    }

    public function maturedRequest(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 3);
        $q->where('redemption_request', '=', 1);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);


        // $search = trim($request->input('q'));
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search, $class_type){
        //         $query->where('status', '=', 3)
        //             ->where('investment_class_type', '=', $class_type)
        //             ->where('redemption_request', '=', 1)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 3, 'redemption_request' => 1])->latest()->paginate(10);
        // }

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.matured_request', compact('subscriptions', 'investmentClasses'));
    }

    public function reinvestment(Request $request){

        $term = trim($request->input('q'));
        $class_type = $request->input('class_type');
        $investment_type = $request->input('investment_type');

        $q = Subscription::query();
        if($class_type) {
            $q->where('investment_class_type', $class_type);
        }

        if($investment_type != null) {
            $q->where('is_first', $investment_type);
        }

        if( $term ) {
            $q->whereRaw("( subscriptions.name like '%".$term."%' or subscriptions.investment_name like '%".$term."%' or subscriptions.investment_class_type like '%".$term."%' or subscriptions.amount like '%".$term."%' or subscriptions.investment_no like '%".$term."%' 
                           )");
        }

        $q->where('status', '=', 7);
        $q->orderBy("id", "DESC");
        $subscriptions = $q->paginate(20);

        $investmentClasses = InvestmentClass::where('active', 1)->get();

        return view('admin.reinvestment', compact('subscriptions', 'investmentClasses'));


        // $search =  $request->input('q');
        // if($search!=""){
        //     $subscriptions = Subscription::where(function ($query) use ($search){
        //         $query->where('status', '=', 7)
        //             ->where('name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_name', 'like', '%'.$search.'%')
        //             ->orWhere('investment_no', 'like', '%'.$search.'%');
        //     })
        //     ->paginate(10);
        //     $subscriptions->appends(['q' => $search]);
        // }
        // else{
        //     $subscriptions = Subscription::where(['status' => 7])->latest()->paginate(10);
        // }

        // return view('admin.reinvestment')->with('subscriptions',$subscriptions);
    }

    public function reinvestmentRequest(Request $request){

        $search =  $request->input('q');
        if($search!=""){
            $subscriptions = Subscription::where(function ($query) use ($search){
                $query->where('status', '=', 3)
                    ->where('reinvestment_request', '=', 1)
                    ->where('name', 'like', '%'.$search.'%')
                    ->orWhere('investment_name', 'like', '%'.$search.'%')
                    ->orWhere('investment_no', 'like', '%'.$search.'%');
            })
            ->paginate(20);
            $subscriptions->appends(['q' => $search]);
        }
        else{
            $subscriptions = Subscription::where(['status' => 3, 'reinvestment_request' => 1])->latest()->paginate(10);
        }

        return view('admin.reinvestment_request')->with('subscriptions',$subscriptions);
    }

    public function subscriptionView($id){ 
        
        $subscription = Subscription::with(['SsDocumentAs', 'PayoutAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('id',$id)->first();
        if(!$subscription){
           return redirect()->back()->with('error', 'requested page not found');
        }
        
        $price = Price::where('class_type', $subscription->investment_class_type)->where('active', 1)->first();

        if ($subscription->is_first == 1) {
            $subscriptions_history = Subscription::with(['SsDocumentAs', 'PayoutAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])

                // ->where('status',$subscription->status)
                ->where('investment_class_type',$subscription->investment_class_type)
                ->where('user_id',$subscription->user_id)
                ->where('id','!=' ,$subscription->id)
                ->where('is_first', 0)
                ->get();
        } else {
            $subscriptions_history = null;
        }

        // return $subscriptions_history;
        
        $edit = true;
        if($subscription->status == 0){
            $edit = false;
        }
        return view('admin.subscriptionView',['subscription'=> $subscription, 'subscriptions_history'=> $subscriptions_history, 'price' => $price, 'edit' => $edit]);
    }

    public function subscriptionCreate(Request $request){ 

        $classId = $request->get('classId');
        $user_id = $request->get('userId');

        // return $user_id;

        $request->session()->forget('subscription_id');
        $subscription = "";
        $edit = false;
        $additional = false;
        $amount = config('settings.initial_amount');

        $isAdditionalClass = false;
        
        $userData = User::findOrFail($user_id);
        $countries = Country::pluck('name', 'id');

        if(!empty($classId)){
            // $investmentClasses = InvestmentClass::where('active', 1)->where('id', '!=', $classId)->pluck('name', 'id');

            $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
            $subscriptionClassData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('investment_class_type', $classId)->first();
        } else {
            $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
            $subscriptionClassData = "";
        }
        
        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

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
        
        $user_id = $userData['id'];
        $subscription = Subscription::with(['SsDocumentAs'])->where('user_id',$user_id)->where('is_first',1)->first();
        
        if(!empty($subscription)){
            $edit = true;
        }
        
        $check_additional = $this->checkAdditionalInvestment($userData['id']);
        if($check_additional == 0){
            $amount = config('settings.additional_amount');
            $additional = true;
        }
        
        return view('admin.subscriptionCreate', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'amount' => $amount, 'additional' => $additional, 'subscriptionClassData' => @$subscriptionClassData, 'isAdditionalClass' => $isAdditionalClass]);

    }

    public function subscriptionEdit(Request $request, $id){ 
        
        $request->session()->put('subscription_id', $id);
        $additional = false;
        $amount = config('settings.initial_amount');

        $isAdditionalClass = false;
        
        $subscription = Subscription::with(['SsDocumentAs'])->where('id',$id)->first();
        if(!$subscription){
           return redirect('/active')->with('error', 'requested page not found');
        }

        $edit = true;
        $userData = User::findOrFail($subscription->user_id);
        $countries = Country::pluck('name', 'id');
        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
        
        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

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
        
        $check_additional = $this->checkAdditionalInvestment($userData['id']);
        if($check_additional == 0){
            $amount = config('settings.additional_amount');
            $additional = true;
        }

        if ($subscription->is_first == 0) {

            $amount = config('settings.additional_amount');
            $isAdditionalClass = true;

            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $subscription->created_at);
            $from=Carbon::now();
            $diff_in_days = $to->diffInDays($from);

            return view('admin.subscriptionAdditionEdit', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'amount' => $amount, 'additional' => $additional, 'isAdditionalClass' => $isAdditionalClass, 'check_date' => @$diff_in_days]);
        }
        
        return view('admin.subscriptionEdit', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'amount' => $amount, 'additional' => $additional, 'isAdditionalClass' => $isAdditionalClass]);

    }

    public function subscriptionSave(Request $request){

        $subscription_id = $request->session()->get('subscription_id');

        // return $subscription_id;

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

        $requestData = $request->all();
        $requestData['investment_no'] = config('settings.investment_no');
        
        $requestData['status'] = 1;
        // $requestData['subscriber_type'] = 1;

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        $requestData['manual_signed_doc'] = $image_name;
            
        $requestData['individual_pep_doc'] = $individualPepImageName;
        $requestData['individual_source_fund_doc'] = $individualFwImageName;
        $requestData['ja_pep_doc'] = $jointPepImageName;
        $requestData['ja_source_fund_doc'] = $jointFwImageName;

        $requestData['manual_signed_doc_enable'] = 1;
        
        if(!empty($subscription_id)){

            $subscription = Subscription::find($subscription_id);

            // if (!empty($requestData['is_additional'])) {
            //     $requestData['is_first'] = 0;
            // } else {
            //     $requestData['is_first'] = $this->checkAdditionalInvestment($subscription->user_id);
            // }

            if (!empty($requestData['is_additional'])) {
                $requestData['is_first'] = 0;
            } else {
                $requestData['is_first'] = 1;
            }

            $originalImage= $request->file('file');
            if(!empty($originalImage)){
                
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = $originalImage->storeAs('manualSignedDoc', $fileName, 'public');
    
                $image_name = $filePath;
            }else{
                $image_name = "";
            }
            
            $requestData['manual_signed_doc'] = $image_name;
            $requestData['manual_signed_doc_enable'] = 1;
            
            //merge investment amout
            // $investmentType = $this->checkAdditionalInvestment($subscription->user_id);
            // if ($investmentType == 0) {
            //     $checkInvestment = new Subscription;
            //     $checkInvestment->mergeInvestmentAmount($subscription->user_id, $request->investment_class_type, $request->amount);
            // }

            $subscription->update($requestData);
        }else{
            $subscription = Subscription::create($requestData);
        }
        
        $increntNo = new User();
        $increntNo->updateInvestmentNo();
            
        $request->session()->forget('subscription_id');
        if($subscription){

            $user_id = $subscription->user_id;

            if(\Request::wantsJson()){
                return response()->json(['data' => "success", 'success' => "Your subcription was saved successfully !!!"], 201); 
            }

            // return redirect('users/'.$user_id)->with("success","Your subcription was saved successfully !!!");
            return redirect()->route('users.index')->with("success","Your subcription was saved successfully !!!");

        }else{

            if(\Request::wantsJson()){
                return response()->json(['data' => "error", 'success' => "Your subcription was saved successfully !!!"], 201);  
            }

            // return redirect('users/'.$user_id)->with("error","Your subcription was not saved !!!");
            return redirect()->route('users.index')->with("success","Your subcription was saved successfully !!!");
        }
          
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

        $requestData = $request->all();
        $userId = $requestData['user_id'];

        // $requestData['is_first'] = $this->checkAdditionalInvestment($userId);

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        // if (!empty($requestData['is_additional'])) {
        //     $requestData['is_first'] = 0;
        // } else {
        //     $requestData['is_first'] = $this->checkAdditionalInvestment($userId);
        // }

        if (!empty($requestData['is_additional'])) {
            $requestData['is_first'] = 0;
        } else {
            $requestData['is_first'] = 1;
        }

        if(!empty($subscription_id)){

            $subscription = Subscription::find($subscription_id);
            $subscription->update($requestData);
        }else{

            $requestData['status'] = 0;
            $requestData['investment_no'] = config('settings.investment_draft_no');
            
            $is_first_subscription_id = $request->input('old_subscription_id');
            $is_first_subscriber_type = $request->input('old_subscriber_type');
            
            $subscription = Subscription::create($requestData);
            $this->copyDocument($subscription->id, $is_first_subscription_id, $is_first_subscriber_type);
            $increntDroftNo = new User();
            $increntDroftNo->updateInvestmentNoDraft();
        }
        if($subscription->id){

            $request->session()->put('subscription_id', $subscription->id);
            return response()->json(['data' => "success", 'subscription' => $subscription], 201); 
        }else{

            return response()->json(['data' => "error"], 201); 
        }
    }
    
    
    public function subscriptionEditSave(Request $request){
        
        $requestData = $request->all();

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

        $requestData['origin_fund_wealth'] = @$origin_fund_wealth;
        $requestData['source_of_wealth'] = @$source_of_wealth;
        $requestData['source_of_wealth_funds_comes'] = @$source_of_wealth_funds_comes;

        $requestData['ja_origin_fund_wealth'] = @$ja_origin_fund_wealth;
        $requestData['ja_source_of_wealth'] = @$ja_source_of_wealth;
        $requestData['ja_source_of_wealth_funds_comes'] = @$ja_source_of_wealth_funds_comes;

        $requestData['manual_signed_doc'] = $image_name;
            
        $requestData['individual_pep_doc'] = $individualPepImageName;
        $requestData['individual_source_fund_doc'] = $individualFwImageName;
        $requestData['ja_pep_doc'] = $jointPepImageName;
        $requestData['ja_source_fund_doc'] = $jointFwImageName;

        $requestData['manual_signed_doc_enable'] = 1;

        // $subscription_id = $request->input('id');
        // $subscription_id = $request->get('id');

        $subscription_id = $request->get('subId');
        $subscription = Subscription::find($subscription_id);
        
        if($subscription->status == 0){
            $requestData['status'] = 1;    
        }
        $subscription->update($requestData);
        
        if($subscription){
            $user_id = $subscription->user_id;

            if($request->ajax()){
                return response()->json(['data' => "success"], 201);
            }
            return redirect('users/'.$user_id)->with("success","Your subcription was updated successfully !!!");
        }else{

            if($request->ajax()){
                return response()->json(['data' => "error"], 500);
            }
            return redirect('users/'.$user_id)->with("error","Your subcription was not updated !!!");
        }
          
    }


    public function subscriptionEditSaveDraft(Request $request){
        
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

        // $subscription_id = $request->input('id');
        $subscription_id = $request->get('subId');
        
        $subscription = Subscription::find($subscription_id);
        $subscription->update($requestData);
        
        if($subscription_id){

            $request->session()->put('subscription_id', $subscription_id);

            return response()->json(['data' => "success", 'subscription' => $subscription], 201); 
        } else {
            return response()->json(['data' => "error"], 500); 
        }

        // return response()->json(['data' => "success", 'subscription' => $subscription], 201);  
    }

    public function subscriptionAdditionCreate(Request $request)
    {
        $classId = $request->get('classId');
        $userId = $request->get('userId');
        $isAdditional = $request->get('isAdditional');

        $userData = User::findOrFail($userId);
        $request->session()->forget('subscription_id');
        $additional = false;
        $edit = false;
        
        $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $userId)->where('investment_class_type', '=', $classId)->first();

        // $subscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $user_id)->where('is_first',1)->first();

        if(!empty($subscriptionData)){

            $subscription = $subscriptionData;
            $edit = true;
        }else{
            $subscription = "";
        }

        // $investmentClasses = InvestmentClass::where('active', 1)->where('id', '!=', $classId)->pluck('name', 'id');
        $investmentClasses = InvestmentClass::where('active', 1)->pluck('name', 'id');
        $subscriptionClassData = Subscription::with('SsDocumentAs')->where('user_id', $userId)->where('investment_class_type', $classId)->first();

        $userSourceWealthDocuments = UserSourceWealth::with('UserSourceWealthDocuments')->where('status', 1)->get();

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
        
        $check_additional = $this->checkAdditionalInvestment($userId);
        if($check_additional == 0){
            $amount = config('settings.additional_amount');
            $additional = true;

            $initialSubscriptionData = Subscription::with('SsDocumentAs')->where('user_id', $userId)->where('investment_class_type', $classId)->whereIn('is_first',[0,1])->first();

            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $initialSubscriptionData->created_at);
            $from=Carbon::now();
            $diff_in_days = $to->diffInDays($from);
        }

        return view('admin.subscriptionAdditionCreate', ['edit' => $edit, 'countries'=> $countries, 'investmentClasses'=> $investmentClasses, 'userSourceWealthDocuments'=> $userSourceWealthDocuments, 'phone_prefix'=> $phone_prefix, 'userData'=> $userData, 'subscription' => @$subscription, 'additional' => $additional, 'subscriptionClassData' => @$subscriptionClassData, 'isAdditional' => $isAdditional, 'check_date' => @$diff_in_days]);
    }
    
    private function copyDocument($new_id, $ols_id, $main_type){
        
        $ssDocumentData = SsDocument::where(['subscription_id' => $ols_id, 'main_type' => $main_type])->get();
        
        foreach($ssDocumentData as $ssDocument){
            $requestData = new SsDocument;
	        $requestData['subscription_id'] = $new_id;
	        $requestData['main_type'] = $ssDocument['main_type'];
	        $requestData['sub_type'] =  $ssDocument['sub_type'];
	        $requestData['file'] =  $ssDocument['file'];
	        $requestData['remarks'] =  $ssDocument['remarks'];
	        $requestData['notification'] =  $ssDocument['notification'];
	        
	        $requestData->save();    
        }
    } 
   
    public function changeStatus(Request $request){ 

        $id = $request->get('subscription_id');

        $subscription = Subscription::with('InvestmentClassAs')->where('id',$id)->first();
        $price = Price::where('active', 1)->where('class_type', $subscription->investment_class_type)->first();
        $payout = Payout::where('subscription_id',$subscription->id)->first();

        $user_id = $subscription->user_id;

        //investment class
        $investment_class = $subscription->investment_class_type;
        if (!empty($investment_class)) {
            $classType = $subscription->InvestmentClassAs['name'];
        } else {
            $classType = "Class A";
        }

        $userEntity = User::where('id',$user_id)->first();

        $email_status = config('settings.email_sent');
         
        if(empty($payout)){       
            //Pending Funding
            if($request->input('status') == 2){
                if($request->get('send_mail') == "send"){
                    $subscription->bank_doc_request = 1;
                    $subscription->bank_instruction_date = Carbon::now();

                    $subscription->save();
    
                    //Notification Save
                    $noti_sender_user_id = 1;
                    $noti_receiver_user_id = $subscription->user_id;
                    $noti_link = "/investor/uploadBankslip";
                    $investment_no = $subscription->investment_name;
                    $noti_message = $investment_no." - Please upload the Bank Slip to confirm the investment";
    
                    $notification = new User;
                    $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
                    //Notification End
    
    
                    //Email Save
                    $objData = new \stdClass();
                    $objData->email = $userEntity->email;
                    $objData->name = $userEntity->name;
                    $objData->salutation = $userEntity->salutation;
                    $objData->investment_no = $investment_no;
                    $objData->investment_class = $classType;
                    $objData->investment_type = $investment_class;
                    $objData->msg = "";
                    $objData->link = "";
                    $to_email = $userEntity->email;

                    //attachment

                    $currency_word = $this->convert_number_to_words($subscription->amount);
                    $bankInsPdf = PDF::loadView('pdf.bankPdf', compact('subscription', 'currency_word'));

                    $path = public_path('pdf/bankInstruction');
                    $fileName =  'bank_instruction'.$noti_receiver_user_id.'.'. 'pdf';

                    if (File::exists(public_path('pdf/bankInstruction/'.$fileName))) {
                        File::delete(public_path('pdf/bankInstruction/'.$fileName));
                    }

                    $bankInsPdf->save($path . '/' . $fileName);
                    $attach = public_path('pdf/bankInstruction/'.$fileName);

                    if(!empty($attach)){
                        $attachment = $attach;
                        
                    }else{
                        $attachment = "";
                    }

                    if ($email_status == 1) {
                        Mail::to($to_email)->send(new PendingFundingMail($objData, $attachment));
                    }
                    
                    //Email Save
                }

                // $subscription->bank_instruction_date = Carbon::now();
            }

            //fund received
            if($request->input('status') == 9){

                //////////////// total fund amount//////////////////

                $subscription_fee = 0;
                $escrow_charge = 0;
                
                if ($subscription->investment_class_type == 1) {
                    $subscription_fee = config('settings.subcription_fee_class_a');
                } elseif($subscription->investment_class_type == 2){
                    $subscription_fee = config('settings.subcription_fee_class_b'); 
                } else {
                    $subscription_fee = 0;
                }

                if ($subscription->is_first == 1) {
                    if ($subscription->is_joint_account == 1) {
                        $escrow_charge = config('settings.single_escrow_charge_initial');
                    } elseif($subscription->is_joint_account == 2){
                        $escrow_charge = config('settings.joint_escrow_charge_initial');
                    } else {
                        $escrow_charge = 0;
                    }

                } else {
                    if ($subscription->is_joint_account == 1) {
                        $escrow_charge = config('settings.single_escrow_charge_additional');
                    } elseif($subscription->is_joint_account == 2){
                        $escrow_charge = config('settings.joint_escrow_charge_additional');
                    } else {
                        $escrow_charge = 0;
                    }
                }

                $amount = $subscription->amount;
                $subscription_fee = $subscription_fee;
                $percent = ($amount * $subscription_fee)/100;
                $total = $amount + $percent + $escrow_charge;

                $total = number_format($total, 2); 

                //////////////// end total fund amount//////////////////

                // $request->request->remove('status');
                if($request->get('send_fund_received_mail') == "send"){
                    //Email Save
                    $objData = new \stdClass();
                    $objData->email = $userEntity->email;
                    $objData->name = $userEntity->name;
                    $objData->salutation = $userEntity->salutation;
                    $objData->investment_no = $subscription->investment_name;
                    $objData->investment_amount = @$total;
                    $objData->msg = "";
                    $objData->link = "";
                    $to_email = $userEntity->email;
                    
                    if ($email_status == 1) {
                        Mail::to($to_email)->send(new FundReceivedMail($objData));
                    }

                    //Email Save
                }
            }
    
            if($request->input('status') == 5){
                //Email Save
                $objData = new \stdClass();
                $objData->email = $userEntity->email;
                $objData->name = $userEntity->name;
                $objData->salutation = $userEntity->salutation;
                $objData->investment_no = $subscription->investment_name;
                $objData->msg = "";
                $objData->link = "";
                $to_email = $userEntity->email;
                
                if ($email_status == 1) {
                    Mail::to($to_email)->send(new InvestmentRejectMail($objData));
                }
                //Email Save
            }
                
            if($request->input('status') == 3){
    
                if(!empty($subscription->commencement_date)){

                    $subscription->status = $request->input('status');
                    $subscription->save();

                    
                    //merge investment amout
                    $investmentType = $this->checkAdditionalInvestment($user_id);
                    
                    // if ($subscription->is_first == 0) {
                    //     $checkInvestment = new Subscription;
                    //     $checkInvestment->mergeInvestmentAmount($user_id, $subscription->investment_class_type, $subscription->amount);
                    // }



                    $subscriptionCommenceDate = $subscription->commencement_date;

                    $newDate = date('Y-m-d', strtotime($subscriptionCommenceDate. ' - 1 month'));
                    $month_lastdate = date("Y-m-t", strtotime($newDate)); //month last date

                    $price = Price::where('class_type', $subscription->investment_class_type)
                                ->where('dealing_date', '=', $month_lastdate)
                                ->first();

                    if (!empty($price)) {
                        $latestPrice =  $price->latest_price;
                    } else {
                        $price = Price::where('class_type', $subscription->investment_class_type)
                                ->where('active', 1)
                                ->first();

                        $latestPrice = $price->latest_price;

                        // return response()->json(['data' => "No Data Found!", 'error'=> true], 500);   
                    }

                    $numbe_of_shares_held = $subscription->amount / $latestPrice;
                    $current_value = $numbe_of_shares_held * $latestPrice;
                    
                    $subscription->bank_doc_request = 0;
                    $subscription->actual_price = $latestPrice;
                    $subscription->actual_no_of_share = $numbe_of_shares_held;
                    $subscription->latest_price = $latestPrice;
                    $subscription->no_of_share = $numbe_of_shares_held;
                    $subscription->current_value = $current_value;
                    
                    $subscription->save();

                    //old

                    // $latest_price = $price->latest_price;
                    // $no_of_share = $subscription->amount/$latest_price;
                    // $current_value = $no_of_share * $latest_price;
                    
                    // $subscription->bank_doc_request = 0;
                    // $subscription->actual_price = $latest_price;
                    // $subscription->actual_no_of_share = $no_of_share;
                    // $subscription->latest_price = $latest_price;
                    // $subscription->no_of_share = $no_of_share;
                    // $subscription->current_value = $current_value;
                    
                    // $subscription->status = $request->input('status');

                    //$subscription->save();

    
                    //Notification Save
                    $noti_sender_user_id = 1;
                    $noti_receiver_user_id = $subscription->user_id;
                    $noti_link = "/investor/subscriptionView/".$subscription->id;
                    $investment_no = $subscription->investment_name;
                    $noti_message = $investment_no." - Your Investment Activated Successfully";
    
                    $notification = new User;
                    $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
                    //Notification End
    
    
                    //Email Save
                    $objData = new \stdClass();
                    $objData->email = $userEntity->email;
                    $objData->name = $userEntity->name;
                    $objData->salutation = $userEntity->salutation;
                    $objData->investment_no = $investment_no;
                    $objData->msg = "";
                    $objData->link = "";
                    $to_email = $userEntity->email;
                    
                    if ($email_status == 1) {
                        Mail::to($to_email)->send(new ActiveInvestmentMail($objData));
                    }

                    //Email Save
    
                    return redirect()->back()->with("success","Successfully Changed status and sent mail.");
                }else{
    
                    return redirect()->back()->with("error","The commencement date not set. Please set first.");
                }
    
            }else{
                $subscription->status = $request->input('status');
                $subscription->save();
                return redirect()->back()->with("success","Successfully Changed status and sent mail.");
            }
        }else{
            return redirect()->back()->with("error","Already this investment payout.");
        }
    }

    public function contractUpdate(Request $request){ 

        // return $request->all();
        $id = $request->input('id');
        

        // if(!empty($id)){

        //     $requestData = $request->all();
        //     $subscriptionData = Subscription::where(['id' => $id])->first();

        //     if(($subscriptionData->is_first == 1) && ($subscriptionData->investment_class_type == 1)){

        //         $subscriptionUserId = $subscriptionData->user_id;
        //         $subscriptions = Subscription::where(['user_id' => $subscriptionUserId, 'investment_class_type' => 1])->get();

        //         // return $subscriptions;

        //         foreach ($subscriptions as $key => $subscription) {

        //             $SubscriptionInput = Subscription::find($subscription->id);
        //             $SubscriptionInput->investment_name = $requestData['investment_name'];

        //             if ($subscription->is_first == 1) {
        //                 $SubscriptionInput->commencement_date = $requestData['commencement_date'];
        //             }
                    
        //             $SubscriptionInput->save();

        //             // $subscriptionData->update($requestData);
        //         }


        //     } elseif(($subscriptionData->is_first == 1) && ($subscriptionData->investment_class_type == 2)) {

        //         $subscriptionUserId = $subscriptionData->user_id;
        //         $subscriptions = Subscription::where(['user_id' => $subscriptionUserId, 'investment_class_type' => 2])->get();

        //         foreach ($subscriptions as $key => $subscription) {

        //             $SubscriptionInput = Subscription::find($subscription->id);
        //             $SubscriptionInput->investment_name = $requestData['investment_name'];

        //             if ($subscription->is_first == 1) {
        //                 $SubscriptionInput->commencement_date = $requestData['commencement_date'];
        //             }
                    
        //             $SubscriptionInput->save();

        //             // $subscriptionData->update($requestData);
        //         }

        //     } else {
        //         $commence_date = $request->input('commencement_date');
        //         // $commence_date = strtotime($commence_date);

        //         $requestInput['commencement_date'] = $commence_date;
        //         $subscriptionData->update($requestInput);
        //     }
        // }


        if(!empty($id)){
            $commence_date = $request->input('commencement_date');
            $commence_date = strtotime($commence_date);

            $requestData = $request->all();
            $subscriptionData = Subscription::where(['id' => $id])->first();

            if(!empty($subscriptionData)){

                $subscriptionData->update($requestData);
            }
        }


        return response()->json(['data' => "success"], 201);  
    }

    public function investmentDetailsUpdate(Request $request){ 

        $id = $request->input('id');
        if(!empty($id)){
            
            $requestData = $request->all();
            $subscriptionData = Subscription::where(['id' => $id])->first();

            if(!empty($subscriptionData)){

                $subscriptionData->update($requestData);
            }
        }
        return response()->json(['data' => "success"], 201);  
    }

    public function investmentShareDetailsUpdate(Request $request){

        $id = $request->input('id');
        if(!empty($id)){
            
            $requestData = $request->all();

            // return $requestData;
            // $subscriptionData = Subscription::where(['id' => $id])->first();

            // merge investment amount
            $subscriptionData = Subscription::where(['id' => $id])
                ->where('user_id', $requestData['user_id'])
                ->where('is_first', 1)
                ->where('investment_class_type', $requestData['investment_class_id'])
                ->where('status', 3)
                ->orderBy('created_at', 'desc')->first();


            if (!empty($subscriptionData)) {
                
                $price = Price::where('active', 1)->where('class_type', $requestData['investment_class_id'])->first();
                $latest_price = $price->latest_price;

                $totalInvestmentAmount = $requestData['current_investment_value'];

                // $subscriptionData = Subscription::where('id', $subscriptionData->id)->where('user_id', $user_id)->first();

                $no_of_share = $totalInvestmentAmount/$latest_price;
                $current_value = $no_of_share * $latest_price;

                $subscriptionData->latest_price = $latest_price;
                $subscriptionData->no_of_share = $no_of_share;
                $subscriptionData->current_value = $current_value;

                $subscriptionData->save();

                return response()->json(['data' => "success"], 201);

            } else {

                return response()->json(['data' => "error"], 500);
            }
        }
    }

    public function bankDetailsUpdate(Request $request){ 

        $id = $request->input('id');
        if(!empty($id)){
            
            $requestData = $request->all();
            $requestData['changebank_request'] = 0;
            $requestData['changebank_status'] = 1;
            $subscriptionData = Subscription::where(['id' => $id])->first();

            if(!empty($subscriptionData)){

                $subscriptionData->update($requestData);

                $user_id = $subscriptionData->user_id;
                $userEntity = User::where('id',$user_id)->first();

                //Notification Save
                $noti_sender_user_id = 1;
                $noti_receiver_user_id = $user_id;
                $noti_link = "/investor/subscriptionView/".$subscriptionData->id;
                $investment_no = $subscriptionData->investment_name;
                $noti_message = $investment_no." - Your bank details change request has been approved & updated";
                    
                $notification = new User;
                $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
                //Notification End


                //Email Save
                $objData = new \stdClass();
                $objData->email = $userEntity->email;
                $objData->name = $userEntity->name;
                $objData->salutation = $userEntity->salutation;
                $objData->investment_no = $investment_no;
                $objData->msg = "";
                $objData->link = "";
                $to_email = $userEntity->email;

                $email_status = config('settings.email_sent');
                if ($email_status == 1) {
                    Mail::to($to_email)->send(new BankSlipConfirmEmail($objData));
                }
                
                //Email Save
            }
        }
        return response()->json(['data' => "success"], 201);  
    }

    public function deleteSubscription(Request $request){ 

        $subsID = $request->get('id');
        Subscription::find($subsID)->delete();

        return response()->json(['data' => "success"], 201);
    }

    public function setDefaultNotification(Request $request){ 

        $id = $request->input('id');
        if ($id != 0) {
            
            $mcilFund = User::where(['role_id' => 2, 'active' => 1])->update(['setdefault' => 0]);
            User::where(['id' => $id, 'role_id' => 2, 'active' => 1])->update(['setdefault' => 1]);

        } else {
           
            User::where(['role_id' => 2, 'active' => 1])
                ->update([
                   'setdefault' => 0
                ]);
        }
    }

    public function manualSignedDocumentUpload(Request $request){ 

        $id = $request->input('id');
        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('manualSignedDoc', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($id)){

            $requestData = $request->all();
            $requestData['manual_signed_doc'] = $image_name;
            $requestData['manual_signed_doc_enable'] = 1;
            $subscriptionData = Subscription::where(['id' => $id])->first();

            if(!empty($subscriptionData)){
                $subscriptionData->update($requestData);
            }
        }
        return response()->json(['data' => "success"], 201);  
    }

    public function manualBankSlipDocumentUpload(Request $request){ 

        $id = $request->input('id');
        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('ssattachment', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($id)){

            $requestData = $request->all();
            $requestData['subscription_id'] = $id;
            $requestData['main_type'] = 7;
            $requestData['sub_type'] = 71;
            $requestData['file'] = $image_name;
            $requestData['remarks'] = "Bank Slip";

            $ssDocumentData = SsDocument::where(['subscription_id' => $id, 'main_type' => 7, 'sub_type' => 71])->first();

            if(!empty($ssDocumentData)){

                $ssDocument = SsDocument::find($ssDocumentData->id);
                $ssDocument->update($requestData);
            }else{

                $ssDocument = SsDocument::create($requestData);
            }   

            $subscription = Subscription::find($id);

            $requestData = $request->all();
            $requestData['bank_doc_request_hidden'] = 1;
            $subscription->update($requestData);

            return response()->json(['data' => "success"], 201);  
        } else {
            return response()->json(['data' => "failed"], 201);
        }
    }

    public function documentUpload(Request $request){ 

        $ss_id = $request->input('id');
        $originalImage= $request->file('file');
        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $originalImage->storeAs('ssattachment', $fileName, 'public');

            $image_name = $filePath;
        }else{
            $image_name = "";
        }

        if(!empty($ss_id)){

            $requestData = $request->all();
            $requestData['file'] = $image_name;
            $ssDocumentData = SsDocument::where(['id' => $ss_id])->first();

            if(!empty($ssDocumentData)){
                $ssDocument = SsDocument::find($ssDocumentData->id);

                $ssDocument->update($requestData);
            }
        }
        return response()->json(['data' => "success"], 201);  
    }

    public function additionalSupportdocumentUpload(Request $request){ 

        $subs_id = $request->input('subs_id');
        $upload_document_id = $request->input('upload_document_id');
        $originalImage= $request->file('file');

        $requestData = $request->all();

        if(!empty($originalImage)){
            
            $fileName = time().'_'.$request->file->getClientOriginalName();

            if ($upload_document_id == 1) {

                $filePath = $originalImage->storeAs('individualPEPSignedDoc', $fileName, 'public');
                $requestData['individual_pep_doc'] = $filePath;

            } else if ($upload_document_id == 2) {

                $filePath = $originalImage->storeAs('individualFWSignedDoc', $fileName, 'public');
                $requestData['individual_source_fund_doc'] = $filePath;

            } else if ($upload_document_id == 3) {

                $filePath = $originalImage->storeAs('jointPEPSignedDoc', $fileName, 'public');
                $requestData['ja_pep_doc'] = $filePath;

            } else if ($upload_document_id == 4) {

                $filePath = $originalImage->storeAs('jointFWSignedDoc', $fileName, 'public');
                $requestData['ja_source_fund_doc'] = $filePath;

            } else {

                $filePath = "";
            }
            
            $image_name = $filePath;

        } else {
            $image_name = "";
        }

        if(!empty($subs_id)){

            $subscription = Subscription::find($subs_id);
            $requestData['manual_signed_doc_enable'] = 1;

            $subscription->update($requestData);
        }

        return response()->json(['data' => "success"], 201); 
    }

    public function bankSlipConfirmEmail(Request $request){

        $id = $request->get('id');
        $subscription = Subscription::where('id',$id)->first();
        
        $subscription->bank_doc_request = 0;
        $subscription->bank_doc_request_hidden = 0;
        $subscription->save();

        $user_id = $subscription->user_id;
        $userEntity = User::where('id',$user_id)->first();


        //Notification Save
        $noti_sender_user_id = 1;
        $noti_receiver_user_id = $user_id;
        $noti_link = "/investor/subscriptionView/".$subscription->id;
        $investment_no = $subscription->investment_name;
        $noti_message = $investment_no." - Bank in slip accepted";
            
        $notification = new User;
        $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
        //Notification End


        //Email Save
        $objData = new \stdClass();
        $objData->email = $userEntity->email;
        $objData->name = $userEntity->name;
        $objData->salutation = $userEntity->salutation;
        $objData->investment_no = $investment_no;
        $objData->msg = $subscription->redemption_msg;
        $objData->link = "";
        $to_email = $userEntity->email;

        $email_status = config('settings.email_sent');
        if ($email_status == 1) {
            Mail::to($to_email)->send(new BankSlipConfirmEmail($objData));
        }

        //Email Save

        return response()->json(['data' => "success", 'error'=> true], 201);   
    }


    public function settings(){

        $user = Auth::user();
        $settings = Setting::where('id',1)->first();

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

        return view('admin.settings', ['google2fa_secret' => $google2fa_secret, 'qr_image' => $qr_image, 'fa_status' => $fa_status, 'settings' => $settings]);
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

    public function masterSettings(Request $request){

        $setting = Setting::where('id',1)->first();
        $requestData = $request->all();
        $setting->update($requestData);

        return redirect()->back()->with("success", "Master settings updated successfully.");
    }

    public function systemAdmins(){

        $users = User::where('active', 1)
                        ->where('email_verified', 1)
                        ->whereNotIn('role_id', [3,6])
                        ->get();

        return view('admin.users.admin-index', compact('users'));
    }

    public function createAdmin()
    {
        $countries = Country::orderBy('name','asc')->pluck('name', 'id');
        $phone_prefixData = Country::orderBy('name','desc')->whereNotNull('calling_code')->get();
        $phone_prefix = [];

        foreach ($phone_prefixData as $key => $value) {
            $phone_prefix[$key]['code'] = $value->calling_code;
            $phone_prefix[$key]['country'] = $value->name ." (+".$value->calling_code.")";
        }

        $phone_prefix = array_reverse($phone_prefix,true);
        $roles = Role::orderBy('id','ASC')->get();
        
        // $roles = Role::pluck('name','name')->all();

        // return $roles;
        return view('admin.users.admin-create', compact('roles', 'countries', 'phone_prefix'));
    }

    public function storeAdmin(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required'
        ]);
    
        $input = $request->all();
        $input['name'] = $input['username'];
        $input['model_type'] = "App\User";
        $input['email_verified'] = 1;  
        $input['email_verified_at'] = Carbon::now();
        $input['status'] = 1;
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        // $user->assignRole($request->input('roles'));
        
        return redirect()->back()->with('success', 'User created successfully');

        // return redirect()->route('users.index')
        //                 ->with('success','User created successfully');
    }
    
    public function redemptionUpdate(Request $request){

        $id = $request->get('sub_id');
        $sub_class_type = $request->get('sub_class_type');
        
        $subscription = Subscription::where('id',$id)->first();
        
        $redemption_status = $request->get('redemption_status');
        $redemption_msg = $request->get('redemption_msg');
        $redemption_amount = $request->get('redemption_amount');

        $subscription->redemption_status = $redemption_status;
        $subscription->redemption_msg = $redemption_msg;
        $subscription->save();

        $user_id = $subscription->user_id;
        $userEntity = User::where('id',$user_id)->first();

        if($redemption_status == 1){
            if ($sub_class_type == 1) {

                $currentDate = date('F');
                $quaterDate = ViewHelper::findQuarterMonth($currentDate);

                // return $quaterDate;

                $newDate = date('Y-m-d', strtotime($quaterDate. ' - 1 month'));
                $month_lastdate = date("Y-m-t", strtotime($newDate)); //month last date

                $price = Price::where('class_type', 1)
                            ->where('dealing_date', '=', $month_lastdate)
                            ->first();

                if (!empty($price)) {
                    $latestPrice =  $price->latest_price;
                } else {
                    $price = Price::where('class_type', 1)
                            ->where('active', 1)
                            ->first();

                    $latestPrice =  $price->latest_price;

                    // return response()->json(['data' => "No Data Found!", 'error'=> true], 500);   
                }

                // get user latest initial amount
                $subscriptionData = Subscription::where('investment_class_type', 1)
                                        ->where('id', $id)
                                        ->where('status', 3)
                                        ->first();

                $investmentAmount =  $subscriptionData->amount;
                // $numbe_of_shares_held = $investmentAmount / $latestPrice;

                $numbe_of_shares_held = $subscription->no_of_share;
                $units_redeemed = $redemption_amount / $latestPrice;
                $numbe_of_shares_held = $numbe_of_shares_held - $units_redeemed;
                $value_of_shareholding =  $numbe_of_shares_held * $latestPrice;

                $current_share = $subscription->no_of_share;
                $current_amount = $current_share*$latestPrice;
                $update_amount = $current_amount - $redemption_amount;
                
                $requestData = $request->all();
                $requestData['subscription_id'] = $subscription->id;
                $requestData['current_amount'] = $update_amount;
                $requestData['redemption_amount'] = $redemption_amount;
                $requestData['latest_price'] = $latestPrice;
                $requestData['no_of_share'] = $numbe_of_shares_held;
                $requestData['current_value'] = $value_of_shareholding;
                $requestData['redemption_status'] = $redemption_status;
                $requestData['investment_class_id'] = 1; 
                $requestData['redemption_msg'] = $redemption_msg;
                $requestData['redemption_file'] = $subscription->redemption_file;
                $requestData['payout_date'] = $newDate; 

                $payout = Payout::create($requestData);

                Subscription::where('id', $id)->update(['latest_price'=>$latestPrice, 'no_of_share'=> $numbe_of_shares_held, 'current_value'=> $value_of_shareholding]);

            }

            // $price = Price::where('active', 1)->where('class_type', $subscription->investment_class_type)->first();
            // $latest_price = $price->latest_price;

            // $current_share = $subscription->no_of_share;
            // $current_amount = $current_share*$latest_price;
            // $update_amount = $current_amount - $redemption_amount;
            // $redemption_no_of_share = $redemption_amount/$latest_price;
            
            // $update_current_share = $subscription->no_of_share - $redemption_no_of_share;
            
            // $requestData = $request->all();
            // $requestData['subscription_id'] = $subscription->id;
            // $requestData['current_amount'] = $update_amount;
            // $requestData['redemption_amount'] = $redemption_amount;
            // $requestData['latest_price'] = $latest_price;
            // $requestData['no_of_share'] = $redemption_no_of_share;
            // $requestData['current_value'] = $current_amount;
            // $requestData['redemption_status'] = $redemption_status;
            // $requestData['redemption_msg'] = $redemption_msg;
            // $requestData['redemption_file'] = $subscription->redemption_file;

            // $cumulativePrice = Payout::sum('redemption_amount');
            // $totalCumulativePrice = $cumulativePrice+$redemption_amount;
            // if (!empty($cumulativePrice)) {
            //     $requestData['cumulative_amount'] = $totalCumulativePrice;
            // } else {
            //     $requestData['cumulative_amount'] = $redemption_amount;
            // }

            // $payout = Payout::create($requestData);

            // Subscription::where('id', $id)->update(['latest_price'=>$latest_price, 'no_of_share'=> $update_current_share, 'current_value'=> $update_amount]);
        }

        //Notification Save
        $noti_sender_user_id = 1;
        $noti_receiver_user_id = $user_id;
        $noti_link = "/investor/subscriptionView/".$subscription->id;
        $investment_no = $subscription->investment_name;
        
        if($redemption_status == 1){
            $noti_message = $investment_no." - Your Redemption Request Accept";
        }else if($redemption_status == 2){
            $noti_message = $investment_no." - Your Redemption Request Reject";
        }

        $notification = new User;
        $notification->notificationSave($noti_sender_user_id, $noti_receiver_user_id, $noti_link, $noti_message);
        //Notification End

        //Email Save
        $objData = new \stdClass();
        $objData->email = $userEntity->email;
        $objData->name = $userEntity->name;
        $objData->salutation = $userEntity->salutation;
        $objData->investment_no = $investment_no;
        $objData->msg = $subscription->redemption_msg;
        $objData->link = "";
        $to_email = $userEntity->email;

        $email_status = config('settings.email_sent');
        if ($email_status == 1) {
            
            if($redemption_status == 1){
                Mail::to($to_email)->send(new RedemptionApproval($objData));
            }else if($redemption_status == 2){
                Mail::to($to_email)->send(new RedemptionReject($objData));
            }  
        }
          
        //Email Save

        return response()->json(['data' => "success", 'error'=> false], 201);
    }

    public function signedPdf(Request $request, $id){

        $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('id',$id)->first();

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

        // return view('pdf.singedPdf', compact('subscription', 'currency_word'));
        
        return $pdf->inline();
    }

    public function signedPdfDownload(Request $request){

        $subscription_id = $request->session()->get('subscription_id');

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('id',$subscription_id)->first();
    
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

    public function bankPdf(Request $request, $id){

        $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('id',$id)->first();

        if(empty($subscription)){
            return redirect()->back()->with("success","Your requested data not found");
        }

        $currency_word = $this->convert_number_to_words($subscription->amount);

        $pdf = PDF::loadView('pdf.bankPdf', compact('subscription', 'currency_word'));
        //return $pdf->download('userlist.pdf');
        return $pdf->inline();
    }

    public function monthInvestment(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $month_wise_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '!=', 2);
            })
            ->select(
                DB::raw("(sum(amount)) as amount"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['is_first'=>1])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();

        $investment_amount_rows=[];
        $investment_month_rows2=[]; 
        $investment_month_rows = []; 

        foreach ($month_wise_investment as $key => $value) {

            $investment_amount_rows[]=$value['amount'];
            $investment_month_rows2[]= $value['month'];
        }

        usort($investment_month_rows2 , function($a, $b){
                $a = strtotime($a);
                $b = strtotime($b);
                return $a - $b;
            });

        foreach ($investment_month_rows2 as $key => $value) {
            $monthName = strtotime($value);
            $monthName2 = date("M", $monthName);
            $investment_month_rows[]= $monthName2;
        }

        $data['investment_month_rows'] = $investment_month_rows;
        $data['investment_amount_rows'] = $investment_amount_rows;

        // return $data;
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'Request Success'
        ], 200);
    }

    public function monthAdditionalInvestment(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $month_wise_add_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '!=', 2);
            })
            ->select(
                DB::raw("(sum(amount)) as amount"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['is_first'=>0])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();

        $addinvestment_amount_rows=[];
        $addinvestment_month_rows=[];  
        $addinvestment_month_rows2=[];

        foreach ($month_wise_add_investment as $key => $value) {
            $addinvestment_amount_rows[]=$value['amount'];
            $addinvestment_month_rows2[]= $value['month'];
        }

        usort( $addinvestment_month_rows2 , function($a, $b){
                $a = strtotime($a);
                $b = strtotime($b);
                return $a - $b;
            });

        foreach ($addinvestment_month_rows2 as $key => $value) {
            $monthName = strtotime($value);
            $monthName2 = date("M", $monthName);
            $addinvestment_month_rows[]= $monthName2;
        }

        $data['addinvestment_amount_rows'] = $addinvestment_amount_rows;
        $data['addinvestment_month_rows'] = $addinvestment_month_rows;

        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'Request Success'
        ], 200);
    }

    public function monthNewInvestment(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $month_wise_new_investment =Subscription::with('UserAs')
            ->WhereHas('UserAs', function($query) {
                $query->where('role_id', '!=', 2);
            })
            ->select(
                DB::raw("(count(id)) as count"),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month")
            )
            ->where(['status'=>3])
            ->where(['reinvestment_status'=>0])
            ->where(['draft_delete'=>0])
            ->groupBy('month')
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();

        $month_wise_new_investment_rows2=[];
        $month_wise_new_investment_rows = [];

        foreach ($month_wise_new_investment as $key => $value) {
            $monthName = $value['month'];
        

            $month_wise_new_investment_rows2[] = array(
                    'a' => $value['count'],
                    'y' => $monthName
                );
        }

        usort($month_wise_new_investment_rows2 , function($a, $b){
            $a = strtotime($a['y']);
            $b = strtotime($b['y']);
            return $a - $b;
        });

        foreach ($month_wise_new_investment_rows2 as $key => $value) {
            $monthName = strtotime($value['y']);
            $monthName2 = date("M", $monthName);
            $month_wise_new_investment_rows[]= array(
                    'a' => $value['a'],
                    'y' => $monthName2
                );
        }

        $data['month_wise_new_investment_rows'] = $month_wise_new_investment_rows;

        // return $data;
        
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'Request Success'
        ], 200);
    }

    public function reportIndex(Request $request)
    {
        $status = $request->get('status');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $class_type = $request->get('class_type');

        $q = $request->get('query');

        if(!empty($status) or $status != ""){

            $cond = [
                ['draft_delete', '=', 0],
            ];

        } else {

            $cond = [
                ['draft_delete', '=', 0],
            ];
        }

        if(request()->isMethod('get')){

            if($q!=""){

                $subscriptions = Subscription::whereHas('UserAs', function($query) use($q) {
                    $query->where('name', 'like', '%'.$q.'%');
                })
                ->where($cond)
                ->orWhere('investment_name','LIKE','%'.$q.'%')
                ->orWhere('investment_no', 'LIKE','%'.$q.'%')
                ->orWhere('bank_name', 'LIKE','%'.$q.'%')
                ->orWhere('account_name', 'LIKE','%'.$q.'%')
                ->orWhere('account_number', 'LIKE','%'.$q.'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);

                // $subscriptions->appends(['query' => $q]);

            } else {

                $subscriptions = Subscription::with('UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'PayoutAs');
                $subscriptions = $subscriptions->where($cond);
                if (!empty($status) or $status != "") {

                    $obj = new \stdClass;
                    foreach($status as $key => $value){
                        $obj->{$key} = $value;
                    }
                    $status = (array) $obj;
                    // return $status;
                    $subscriptions = $subscriptions->whereIn('status', $status);
                }

                if (!empty($start_date)) {

                    $start_date = Carbon::parse($start_date)->format('Y-m-d');
                    $end_date = Carbon::parse($end_date)->format('Y-m-d'); 

                    $subscriptions = $subscriptions->whereBetween('created_at',[$start_date,$end_date]);
                }

                if (!empty($class_type) or $class_type != "") {

                    $subscriptions = $subscriptions->where('investment_class_type', $class_type);
                }

                $subscriptions = $subscriptions->paginate(10);
            }

            $price = Price::where('class_type', $class_type?? 1)->where('active', 1)->first();
            $investmentClasses = InvestmentClass::where('active', 1)->get();

            // return $subscriptions;

            if ($request->ajax()) {
                return view('admin.report.child', ['subscriptions' => $subscriptions, 'price' => $price, 'investmentClasses' => $investmentClasses])->render();
            } else {

                $subscriptions = Subscription::with('UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'PayoutAs')->where($cond)->paginate(10);

                return view('admin.report.index', compact('subscriptions', 'price', 'investmentClasses'));
            }
        } 

        return view('admin.report.index', compact('subscriptions', 'price', 'investmentClasses'));
    }


    public function uploadImage(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
         
            $request->file('upload')->move(public_path('images/ckeditor'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/ckeditor/'.$fileName); 

            // $msg = 'Image uploaded successfully'; 
            // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                
            // @header('Content-type: text/html; charset=utf-8'); 
            // echo $response;

            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }


    public function downloadReport(Request $request)
    {
        ob_start();
        $cond = [];
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $status = $request->get('status');
        $class_type = $request->get('class_type');

        $status = explode(',', $status);

        if(!empty($status) or $status != ""){

            $cond = [
                ['draft_delete', '=', 0],
            ];
            
        } else {

            $cond = [
                ['draft_delete', '=', 0],
            ];
        }

        $subscriptions = Subscription::with('UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'PayoutAs', 'InvestmentClassAs');
        $subscriptions = $subscriptions->where($cond);
        if (!empty($status) or $status != "") { 

            $subscriptions = $subscriptions->whereIn('status', $status);
        }

        if (!empty($start_date)) {

            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            $subscriptions = $subscriptions->whereBetween('created_at',[$start_date,$end_date]);
        }

        if (!empty($class_type) or $class_type != "") {

            $subscriptions = $subscriptions->where('investment_class_type', $class_type);
        }

        $subscriptions = $subscriptions->get();

        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet();

        //Headings
        $output_table_thead = array();
        $output_table_thead['no']="NO";
        $output_table_thead['salution']="SALUTATION";
        $output_table_thead['name']="NAME (PLUS) JOINT APPLICANT";
        $output_table_thead['investment_type']="INVESTMENT TYPE";
        $output_table_thead['amount']="PRINCIPAL INVESTMENT (USD)";
        $output_table_thead['investment_id']="INVESTMENT ID";

        $output_table_thead['investment_class']="INVESTMENT CLASS";
        $output_table_thead['investment_status']="INVESTMENT STATUS";

        $output_table_thead['no_of_share']="NO OF SHARES";
        $output_table_thead['current_share_value']="CURRENT SHARE VALUE";
        $output_table_thead['latest_nav']="LATEST NAV";

        $output_table_thead['comm_date']="COMMENCEMENT DATE";
        $output_table_thead['bank']="BANK";
        $output_table_thead['account_name']="ACCOUNT NAME";
        $output_table_thead['bank_account']="BANK ACCOUNT";
        $output_table_thead['swift_code']="SWIFT CODE";
        $output_table_thead['orginal_investment_id']="ORIGINAL INVESTMENT ID";

        $col1 = 1;
        $row1 = 1;  
        foreach ($output_table_thead as $thead){
            $sheet->setCellValueByColumnAndRow($col1, $row1, $thead);
            $col1++;     
        }

        $col2 = 1;
        $row2 = 2;
        $i =1;
        $invest_total = 0;
        foreach ($subscriptions as $subscription){

            $user_id = $subscription->user_id;
            if(!empty($user_id)){

                $user = User::with('countryAs','stateAs')->findOrFail($user_id);
                $price = Price::where('class_type', $class_type?? 1)->where('active', 1)->first();

                if(!empty($user)){
                    if($user->role_id != 2){
                        $salutation = str_replace(".", "", $user->salutation);
                        $gender = $user->gender ? $user->gender : '';
                    }

                    if($subscription->is_first == 1){
                        $investment_type = "INITIAL";
                    }else if($subscription->reinvestment_status == 1){
                        $investment_type = "RE INVESTMENT";
                    } else {
                        $investment_type = "TOP UP";
                    }

                    if ($subscription->is_joint_account == 2) {
                        $joint_applicant_name = " + " . $subscription->ja_name;
                    } else {
                        $joint_applicant_name = "";
                    }

                    $name = $user->name.$joint_applicant_name;
                    $home_address =  $user->address_line1." ".$user->address_line2." ".$user->city." ".$user->post_code." ".$user->stateAs->name." ".$user->countryAs->name;

                }else{
                    $salutation = "";
                    $name = "";
                    $gender = '';
                    $home_address = "";
                }

            } else{
                $salutation = "";
                $name = "";
                $gender = '';
                $home_address = "";
            }

            if(!empty($subscription->commencement_date)){
                $commence_date = date('Y-M-d', strtotime($subscription->commencement_date));
            }else{
                $commence_date = "-";
            }

            // if ($subscription->Payments->count() > 0) {
            //     $divident_percentage = 0;
            //     $divident_amount = 0;
            //     $total_divident_amount = 0;

            //     foreach ($subscription->Payments as $key => $payment) {
                   
            //        $total_divident_amount += $payment['amount'];
            //     }

            // } else {
            //     $divident_percentage = 0;
            //     $divident_amount = 0;
            //     $total_divident_amount = 0;
            // }

            if(!empty($subscription->bank_name)){
                $bank_name = $subscription->bank_name;
            } else {
                $bank_name = "";
            }

            if(!empty($subscription->account_name)){
                $account_name = $subscription->account_name;
            } else {
                $account_name = "";
            }

            if(!empty($subscription->account_number)){
                $account_number = $subscription->account_number;
            } else {
                $account_number = "";
            }

            if(!empty($subscription->swift_address)){
                $swift_code = $subscription->swift_address;
            } else {
                $swift_code = "";
            }

            if(!empty($subscription->reinvestment_parant_id)){
                $reinvestment_parant_id = $subscription->reinvestment_parant_id;

                $old_subscription = \App\Subscription::findOrFail($reinvestment_parant_id);

                if(!empty($old_subscription['investment_no'])){
                    if(($old_subscription['status'] == 3) || ($old_subscription['status'] == 6)){
                        $original_investment_no = $old_subscription['investment_name'];
                    }else{
                        $original_investment_no = $old_subscription['investment_no']."-".$old_subscription['investment_name'];
                    }
                }else{
                    $original_investment_no = $old_subscription['reference_no'].$old_subscription['investment_name'];
                }

            } else {
                $original_investment_no = "";
            }

            if(!empty($subscription['investment_no'])){
                if(($subscription['status'] == 3) || ($subscription['status'] == 6)){
                    $investment_no = $subscription['reference_no'].$subscription['investment_name'];
                }else{
                    $investment_no = $subscription['investment_no']."-".$subscription['investment_name'];
                }
            }else{
                $investment_no = $subscription['reference_no'].$subscription['investment_name'];
            }

            //investment class
            if(!empty($subscription['investment_class_type'])){
                $investment_class = $subscription->InvestmentClassAs['name'];
            }else{
                $investment_class = 'Not Updated';
            }

            //investment status
            if($subscription->status == 1){
                $investment_status = 'Pending';
            }else if($subscription->status == 2){
                $investment_status = 'Pending Funding';
            }else if($subscription->status == 3){
                $investment_status = 'Active';
            }else if($subscription->status == 4){
                $investment_status = 'Deactive';
            }else if($subscription->status == 5){
                $investment_status = 'Rejected';
            }else if($subscription->status == 6){
                $investment_status = 'Matured';
            }else if($subscription->status == 7){
                $investment_status = 'Re-Investmented';
            }else if($subscription->status == 8){
                $investment_status = 'Payment Received';
            }else if($subscription->status == 9){
                $investment_status = 'Fund Received';
            }else{
                $investment_status = 'Draft';
            }

            //No of Shares
            $latest_price = $price->latest_price;
            $current_value = $subscription->no_of_share * $latest_price;

            if($subscription->no_of_share){
                $round_current_value = number_format($subscription->no_of_share * $latest_price, 2);
            }else{
                $round_current_value = 0;
            }

            if($subscription->no_of_share){
                $no_of_share = floatval($subscription->no_of_share);
                $no_of_share = number_format($no_of_share, 4);
            }else{
                $no_of_share = "0.00";
            }
            //No of Shares

            //Current Share Value
            if($latest_price){
                $latest_price = number_format($latest_price, 4);
            }else{
                $latest_price = "0.00";
            }
            //Current Share Value

            //Current NAV Amount Value   
            if($subscription->current_value){
                $current_value = floatval($subscription->current_value);
                $current_nav_value = number_format($current_value, 2);
            }else{
                $current_nav_value = "0.00";
            }
            //Current NAV Amount Value

            $banking_address = $subscription->bank_address;

            $sheet->setCellValueByColumnAndRow($col2, $row2, $i);
            $sheet->setCellValueByColumnAndRow($col2+1, $row2, $salutation);
            $sheet->setCellValueByColumnAndRow($col2+2, $row2, $name);
            $sheet->setCellValueByColumnAndRow($col2+3, $row2, $investment_type);
            $sheet->setCellValueByColumnAndRow($col2+4, $row2, $subscription['amount']);
            $sheet->setCellValueByColumnAndRow($col2+5, $row2, $investment_no);

            $sheet->setCellValueByColumnAndRow($col2+6, $row2, $investment_class);
            $sheet->setCellValueByColumnAndRow($col2+7, $row2, $investment_status);

            $sheet->setCellValueByColumnAndRow($col2+8, $row2, $no_of_share);
            $sheet->setCellValueByColumnAndRow($col2+9, $row2, $latest_price);
            $sheet->setCellValueByColumnAndRow($col2+10, $row2, $current_nav_value);

            $sheet->setCellValueByColumnAndRow($col2+11, $row2, $commence_date);
            
            // $sheet->setCellValueByColumnAndRow($col2+7, $row2, $divident_percentage);
            // $sheet->setCellValueByColumnAndRow($col2+8, $row2, $divident_amount);

            $sheet->setCellValueByColumnAndRow($col2+12, $row2, $bank_name);
            $sheet->setCellValueByColumnAndRow($col2+13, $row2, $account_name);
            $sheet->setCellValueByColumnAndRow($col2+14, $row2, $account_number);
            $sheet->setCellValueByColumnAndRow($col2+15, $row2, $swift_code);
            // $sheet->setCellValueByColumnAndRow($col2+14, $row2, $total_divident_amount);
            $sheet->setCellValueByColumnAndRow($col2+16, $row2, $original_investment_no);
                
            $row2++;
            $i++;
        }

        $writer = new Xlsx($spreadsheet); 
        $rand = rand();
        $path = public_path('project_img/reports');
        $fileName =  time().'_'.'contract-summary'.'.'. 'xlsx';

        if (File::exists(public_path('project_img/reports/'.$fileName))) {
            File::delete(public_path('project_img/reports/'.$fileName));
        }

        $writer->save($path . '/' . $fileName);

        if(!empty($fileName)){
           $file = $fileName;
        }

        return response()->json(['data' => "success", 'filename' => $file], 201);
    }

    public function signedPdfApplicationsDownload(Request $request){
 
        // $subscription_id = $request->session()->get('subscription_id');

        $subscription_id = $request->input('subscriptionId');
        $userId = $request->get('userId');

        if(!empty($subscription_id)){
            $subscription = Subscription::with(['SsDocumentAs', 'UserAs', 'SubscriptionCountryAs', 'SubscriptionStateAs', 'SubscriptionJaCountryAs', 'SubscriptionJaStateAs', 'SubscriptionOsCountryAs', 'SubscriptionOsStateAs'])->where('user_id', $userId)->where('id',$subscription_id)->first();
    
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

                $pepDeclarationPdf = PDF::loadView('pdf.PEPDeclarationPdf', compact('subscription'));

                $principalPEPDeclarationPdfPath = public_path('pdf/principalPEPDeclarationPdf');
                $principalPEPDeclarationPdfFile = 'principal-pep-application-'.$subscription_id.'.'. 'pdf';
                

                if (\File::exists(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile))) {
                    \File::delete(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile));
                }
                $pepDeclarationPdf->save($principalPEPDeclarationPdfPath . '/' . $principalPEPDeclarationPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////

                $sourceOfFundPdf = PDF::loadView('pdf.sourceOfFundPdf', compact('subscription'));

                $principalSourceOfFundPdfFile = 'principal-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';
                $principalsourceOfFundPdfPath = public_path('pdf/principalSourceOfFundPdf');

                if (\File::exists(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile))) {
                    \File::delete(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile));
                }
                $sourceOfFundPdf->save($principalsourceOfFundPdfPath . '/' . $principalSourceOfFundPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////

                if(!empty($investmentPdfFile)){
                   $pdfDocs['investmentPdf'] = "pdf/investmentPdf/".$investmentPdfFile;
                   $pdfDocs['principalPEPDeclarationPdf'] = "pdf/principalPEPDeclarationPdf/".$principalPEPDeclarationPdfFile;
                   $pdfDocs['principalSourceOfFundPdf'] = "pdf/principalSourceOfFundPdf/".$principalSourceOfFundPdfFile;
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

                $pepDeclarationPdf = PDF::loadView('pdf.PEPDeclarationPdf', compact('subscription'));

                $principalPEPDeclarationPdfPath = public_path('pdf/principalPEPDeclarationPdf');
                $principalPEPDeclarationPdfFile = 'principal-pep-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile))) {
                    \File::delete(public_path('pdf/principalPEPDeclarationPdf/'.$principalPEPDeclarationPdfFile));
                }
                $pepDeclarationPdf->save($principalPEPDeclarationPdfPath . '/' . $principalPEPDeclarationPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////

                $sourceOfFundPdf = PDF::loadView('pdf.sourceOfFundPdf', compact('subscription'));

                $principalsourceOfFundPdfPath = public_path('pdf/principalSourceOfFundPdf');
                $principalSourceOfFundPdfFile = 'principal-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile))) {
                    \File::delete(public_path('pdf/principalSourceOfFundPdf/'.$principalSourceOfFundPdfFile));
                }
                $sourceOfFundPdf->save($principalsourceOfFundPdfPath . '/' . $principalSourceOfFundPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////

                $jointPEPDeclarationPdf = PDF::loadView('pdf.jointPEPDeclarationPdf', compact('subscription'));

                $jointPEPDeclarationPdfPath = public_path('pdf/jointPEPDeclarationPdf');
                $jointPEPDeclarationPdfFile = 'joint-pep-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/jointPEPDeclarationPdf/'.$jointPEPDeclarationPdfFile))) {
                    \File::delete(public_path('pdf/jointPEPDeclarationPdf/'.$jointPEPDeclarationPdfFile));
                }
                $jointPEPDeclarationPdf->save($jointPEPDeclarationPdfPath . '/' . $jointPEPDeclarationPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////

                $jointSourceOfFundPdf = PDF::loadView('pdf.jointSourceOfFundPdf', compact('subscription'));

                $jointSourceOfFundPdfPath = public_path('pdf/jointSourceOfFundPdf');
                $jointSourceOfFundPdfFile = 'joint-source-of-wealth-application-'.$subscription_id.'.'. 'pdf';

                if (\File::exists(public_path('pdf/jointSourceOfFundPdf/'.$jointSourceOfFundPdfFile))) {
                    \File::delete(public_path('pdf/jointSourceOfFundPdf/'.$jointSourceOfFundPdfFile));
                }
                $jointSourceOfFundPdf->save($jointSourceOfFundPdfPath . '/' . $jointSourceOfFundPdfFile);

                ///////////////////////////////////////////////////////////////////////////////////
                
                // return $pdf->download('signed-application.pdf');

                if(!empty($investmentPdfFile)){
                   $pdfDocs['investmentPdf'] = "pdf/investmentPdf/".$investmentPdfFile;
                   $pdfDocs['principalPEPDeclarationPdf'] = "pdf/principalPEPDeclarationPdf/".$principalPEPDeclarationPdfFile;
                   $pdfDocs['principalSourceOfFundPdf'] = "pdf/principalSourceOfFundPdf/".$principalSourceOfFundPdfFile;
                   $pdfDocs['jointPEPDeclarationPdf'] = "pdf/jointPEPDeclarationPdf/".$jointPEPDeclarationPdfFile;
                   $pdfDocs['jointSourceOfFundPdf'] = "pdf/jointSourceOfFundPdf/".$jointSourceOfFundPdfFile;
                }

            }

            return response()->json(['data' => "success", 'is_joint_applicant' => $is_joint_applicant, 'pdfDocs' => $pdfDocs, 'subscription_id' => $subscription_id], 201);  

        }else{
            return "";
        }
    }


    private function checkAdditionalInvestment($user_id) {
        
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

        // $subscriptionData = Subscription::where('user_id',$user_id)
        //                         ->where('is_first', '=', 1)
        //                         ->whereIn('status', [1, 2, 3, 6, 7])
        //                         ->first();

        // if(empty($subscriptionData)){
        //     return 1;
        // }else{
        //     return 0;
        // }
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
    
}
