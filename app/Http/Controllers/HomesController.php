<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;
use App\Newsletter;
use App\TrackRecord;
use App\Mail\TestMail;
use Mail;
use Session;
use DB;
use App\Country;
use App\Mail\ContactUsMail;

class HomesController extends Controller
{
    
    public function index(Request $request){


        //$request->session()->forget('disclaimer');

        $disclaimer = $request->session()->get('disclaimer');
        if(!empty($disclaimer)){
            $disclaimer = '0';
        }else{
            $disclaimer = '1';
        }
        // $price = Price::where('id',1)->where('class_type',1)->first();

        $class_a_price = Price::where('active', 1)->where('class_type', 1)->first();
        $class_b_price = Price::where('active', 1)->where('class_type', 2)->first();

        $countries = Country::orderBy('name','asc')->pluck('name', 'id');
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

        return view("site.index",compact('class_a_price', 'class_b_price', 'disclaimer', 'countries', 'phone_prefix'));
    }
    
    public function disclaimer(Request $request){
        
        $request->session()->put('disclaimer', 'accept');
        return response()->json(['data' => "success"], 201);
    }
    
    public function blogDetail(Request $request){
     
        return view("site.blogDetail");
    }

    public function corporateValues(Request $request){
     
        return view("site.corporateValues");
    }

    public function methdology(Request $request){
        
        $prices = DB::table("prices AS price")
            ->where('price.id', '!=', 1)
            ->where('price.class_type', '=', 1)
            ->select("price.*", DB::raw("DATE_FORMAT(price.dealing_date, '%Y') as year"))
            ->get();

        $result =[];

        for ($i=0; $i < count($prices); $i++) { 
            
            if ($i == 0) {
                $prices[$i]->quarterly_return2 = $prices[$i]->ytd_return;
            } else {

                $da1 = str_replace( array("#", "'", "%"), '', $prices[$i-1]->ytd_return);
                $da2 = str_replace( array("#", "'", "%"), '', $prices[$i]->ytd_return);
                $prices[$i]->quarterly_return2 = $da2 - $da1;
            }
        }

        //return $prices;

        foreach ($prices as $key => $element) {
            $result[$element->year][] = $element;
        }

        $cumulative_data = $result;
    
        $priceHistorys = [];
        $years = [];

        foreach ($cumulative_data as $key => $value) {
          for ($i=0; $i < count($cumulative_data[$key]); $i++) { 

                if ($key == 2019) {
                   $cumulative_data[$key][$i]->quartor = "Q4";
                   array_push($years, $key);

                } else {

                    $cumulative_data[$key][$i]->quartor = "Q". ($i+1);
                    array_push($years, $key);
                }
                
                array_push($priceHistorys, $cumulative_data[$key][$i]);
            }
        }

        $ytd_returns=[]; // Cumulative returns
        $quarterly_returns=[]; // Cumulative returns
        $ytd_latest_price = []; // latest price
        $periods=[];             // periods
        $ytd_cumulative_returns=[]; //cumulative returns
        $ytd_cumulative_values=[]; //cumulative returns 2

        for ($i=0; $i < count($priceHistorys); $i++) { 

            if ($priceHistorys[$i]->ytd_return == 0) {
                // code...
            } else {

                $ytd_returns[] .= str_replace( array("#", "'", "%"), '', $priceHistorys[$i]->ytd_return);
                $quarterly_returns[] .= str_replace( array("#", "'", "%"), '', $priceHistorys[$i]->quarterly_return);
                $ytd_latest_price[] .=  $priceHistorys[$i]->latest_price;
                $periods[] .=  $priceHistorys[$i]->quartor . ' ' . substr($priceHistorys[$i]->year, -2);
            }  
        }

        for ($i=0; $i < count($ytd_returns); $i++) { 

            if ($i == 0) {
                $ytd_cumulative_returns[] .= $ytd_returns[$i];
            } else {
                $ytd_cumulative_returns[] .= $ytd_returns[$i] - $ytd_returns[$i-1];
            }
        }


        $cumulative_return = [];
        $quarterly_return = [];
        for ($i=0; $i < count($ytd_returns); $i++) { 
            
            if ($ytd_returns[$i] != 0) {
                $cumulative_return[] .= $ytd_returns[$i];
            }

            if ($quarterly_returns[$i] != 0) {
                $quarterly_return[] .= $quarterly_returns[$i];
            }
        }

        $years = array_unique($years);
        $periods3 = (array_reverse($periods));
        $ytd_returns2 = (array_reverse($ytd_returns));

        $periods2 = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($periods), ENT_NOQUOTES));
        $ytd_cumulative_returns2 = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($cumulative_return), ENT_NOQUOTES));
        $ytd_cumulative_values = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($ytd_cumulative_values), ENT_NOQUOTES));
        $ytd_quarterly_returns = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($quarterly_return), ENT_NOQUOTES));
        $ytd_latest_price = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($ytd_latest_price), ENT_NOQUOTES));

        //return $cumulative_data;

        return view("site.methdology", compact('periods2', 'periods3', 'ytd_cumulative_returns2', 'ytd_cumulative_values', 'ytd_cumulative_returns', 'ytd_returns2', 'ytd_latest_price', 'ytd_quarterly_returns', 'years', 'cumulative_data'));
        
        // $prices = DB::table("prices AS price")
        //     ->where('price.id', '!=', 1)
        //     ->select("price.*", DB::raw("DATE_FORMAT(price.dealing_date, '%Y') as year"))
        //     ->get();

        // $result =[];

        // for ($i=0; $i < count($prices); $i++) { 
            
        //     if ($i == 0) {
        //         $prices[$i]->quarterly_return = $prices[$i]->ytd_return;
        //     } else {

        //         $da1 = str_replace( array("#", "'", "%"), '', $prices[$i-1]->ytd_return);
        //         $da2 = str_replace( array("#", "'", "%"), '', $prices[$i]->ytd_return);
        //         $prices[$i]->quarterly_return = $da2 - $da1;
        //     }
        // }

        // //return $prices;

        // foreach ($prices as $key => $element) {
        //     $result[$element->year][] = $element;
        // }

        // $cumulative_data = $result;
    
        // $priceHistorys = [];
        // $years = [];

        // foreach ($cumulative_data as $key => $value) {
        //   for ($i=0; $i < count($cumulative_data[$key]); $i++) { 

        //         if ($key == 2019) {
        //            $cumulative_data[$key][$i]->quartor = "Q4";
        //            array_push($years, $key);

        //         } else {

        //             $cumulative_data[$key][$i]->quartor = "Q". ($i+1);
        //             array_push($years, $key);
        //         }
                
        //         array_push($priceHistorys, $cumulative_data[$key][$i]);
        //     }
        // }

        // $ytd_returns=[]; // Quarterly Returns
        // $ytd_latest_price = []; // latest price
        // $periods=[];             // periods
        // $ytd_cumulative_returns=[]; //cumulative returns
        // $ytd_cumulative_values=[]; //cumulative returns 2

        // for ($i=0; $i < count($priceHistorys); $i++) { 

        //     if ($priceHistorys[$i]->ytd_return == 0) {
        //         // code...
        //     } else {

        //         $ytd_returns[] .= str_replace( array("#", "'", "%"), '', $priceHistorys[$i]->ytd_return);
        //         $ytd_latest_price[] .=  $priceHistorys[$i]->latest_price;
        //         $periods[] .=  $priceHistorys[$i]->quartor . ' ' . substr($priceHistorys[$i]->year, -2);
        //     }
            
            
        // }

        // for ($i=0; $i < count($ytd_returns); $i++) { 

        //     if ($i == 0) {
        //         $ytd_cumulative_returns[] .= $ytd_returns[$i];
        //     } else {
        //         $ytd_cumulative_returns[] .= $ytd_returns[$i] - $ytd_returns[$i-1];
        //     }
        // }


        // $cumulative_return = [];
        // $quarterly_return = [];
        // for ($i=0; $i < count($ytd_returns); $i++) { 
            
        //     if ($ytd_returns[$i] != 0) {
        //         $cumulative_return[] .= $ytd_returns[$i];
        //     }

        //     if ($ytd_cumulative_returns[$i] != 0) {
        //         $quarterly_return[] .= $ytd_cumulative_returns[$i];
        //     }
        // }

        // $years = array_unique($years);
        // $periods3 = (array_reverse($periods));
        // $ytd_returns2 = (array_reverse($ytd_returns));

        // $periods2 = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($periods), ENT_NOQUOTES));
        // $ytd_cumulative_returns2 = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($cumulative_return), ENT_NOQUOTES));
        // $ytd_cumulative_values = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($ytd_cumulative_values), ENT_NOQUOTES));
        // $ytd_quarterly_returns = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($quarterly_return), ENT_NOQUOTES));
        // $ytd_latest_price = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($ytd_latest_price), ENT_NOQUOTES));

        // //return $cumulative_data;

        // return view("site.methdology", compact('periods2', 'periods3', 'ytd_cumulative_returns2', 'ytd_cumulative_values', 'ytd_cumulative_returns', 'ytd_returns2', 'ytd_latest_price', 'ytd_quarterly_returns', 'years', 'cumulative_data'));
    }


    public function newsletter(Request $request){
        
        $search =  $request->input('q');
        if($search!=""){

            $news = Newsletter::where(function ($query) use ($search){
                $query->where('active', '=', 1)
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('detail', 'like', '%'.$search.'%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
            $news->appends(['q' => $search]);

        } else {

            $news = Newsletter::where('active', '=', 1)
                ->orderBy('updated_at', 'desc')
                ->paginate(6);
        }

        return view('site.newsletter',compact('news'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function newsletterDetails(Request $request, $id){
        
        $news = Newsletter::where('id',$id)->first();
        if(!$news){
           return redirect('/newsletters')->with('error', 'requested page not found');
        }

        $recentNews = Newsletter::where([
                ['id', '!=' , $id],
                ['active', '=', 1],
            ])->orderBy('updated_at', 'desc')->limit(3)->get();


        return view("site.newsletterDetails", compact('news', 'recentNews'));
    }

    public function whoWeAre(Request $request){
        
        $myEmail = 'vasansrini8206@gmail.com';
        $details = [
            'title' => 'Mail Test from Nicesnippets.com',
            'url' => 'https://www.nicesnippets.com'
        ];

        //Mail::to($myEmail)->send(new TestMail($details));
        return view("site.whoWeAre");
    }

    public function contactUs(Request $request)
    {
        // return $request->all();

        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $mobile_prefix = $request->get('mobile_prefix');
        $mobile_no = $request->get('mobile_no');
        $user_email = $request->get('user_email');
        $message = $request->get('message');

        $usrData = new \stdClass();
        $usrData->firstname = $firstname;
        $usrData->lastname = $lastname;
        $usrData->mobile_prefix = $mobile_prefix;
        $usrData->mobile_no = $mobile_no;
        $usrData->user_email = $user_email;
        $usrData->message = $message;

        $to_email = config('settings.contact_enquiry_email');

        Mail::to($to_email)->send(new ContactUsMail($usrData));

        return response()->json(['data' => "success"], 201);  
    }

    public function privacyPolicy(Request $request){
        return view("site.privacyPolicy");
    }

    public function ppm(Request $request){
        return view("site.privatePlacementMemorandum");
    }
}
