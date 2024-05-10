<table id="example" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>SALUTATION</th>
            <th>NAME (PLUS) JOINT APPLICANT</th>
            <th>INVESTMENT TYPE</th>
            <th>PRINCIPAL INVESTMENT (USD)</th>
            <th>INVESTMENT ID</th>
            <th>INVESTMENT CLASS</th>
            <th>INVESTMENT STATUS</th>

            <th>NO OF SHARES</th>
            <th>CURRENT SHARE VALUE</th>
            <th>LATEST NAV</th>

            <th>COMMENCEMENT DATE</th>
            <th>BANK</th>
            <th>ACCOUNT NAME</th>
            <th>BANK ACCOUNT</th>
            <th>SWIFT CODE</th>
            <th>ORIGINAL INVESTMENT ID</th>
        </tr>
    </thead>
    <tbody>

    @if ($subscriptions->count() > 0)

        @php
            $col2 = 1;
            $row2 = 2;
            $i =1;
            $invest_total = 0;
        @endphp

        @foreach ($subscriptions as $key => $subscription)

            <?php 
                $user_id = $subscription->user_id;
                if(!empty($user_id)){

                    $user = \App\User::with('countryAs','stateAs')->findOrFail($user_id);

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

               /* if ($subscription->PayoutAs->count() > 0) {
                    $divident_percentage = 0;
                    $divident_amount = 0;
                    $total_divident_amount = 0;

                    foreach ($subscription->PayoutAs as $key => $payment) {
                       $total_divident_amount += $payment['amount'];
                    }

                } else {
                    $divident_percentage = 0;
                    $divident_amount = 0;
                    $total_divident_amount = 0;
                } */

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
            ?>
        <tr>

            <td>{{ $i }}</td>
            <td>{{ $salutation }}</td>
            <td>{{ $name }}</td>
            <td>{{ $investment_type }}</td>
            <td>{{ $subscription['amount'] }}</td>
            <td>{{ $investment_no }}</td>
            <td>{{ $investment_class }}</td>
            <td>{{ $investment_status }}</td>

            <td>{{ $no_of_share }}</td>
            <td>{{ $latest_price }}</td>
            <td>{{ $current_nav_value }}</td>
            
            <td>{{ $commence_date }}</td>
            <td>{{ $bank_name }}</td>
            <td>{{ $account_name }}</td>
            <td>{{ $account_number }}</td>
            <td>{{ $swift_code }}</td>
            <td>{{ $original_investment_no }}</td>
           
            <?php $i++; ?>

        </tr>

        @endforeach
    @else
      <tr><td colspan=12 align="center">No Records Available..</td></tr>
    @endif

    </tbody>
</table>

<br>

{!! $subscriptions->links('pagination::bootstrap-4') !!} 