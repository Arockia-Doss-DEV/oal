<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<style type="text/css">
    body {
        font-family: 'Poppins';font-size: 14px; padding: 0px; margin: 0px;
    }
    @media  print {
      .new-page {
        page-break-before: always;
      }
    }
    .new-page {
        page-break-before: always;
    }
    table { 
        font-size: 75%; 
        table-layout: 
        fixed; width: 100%;
        border-collapse: separate; 
        border-spacing: 0px; 
    }
    t
    th, td { 
        border-width: 0px; 
        padding: 0em; 
        position: relative;
        border-radius: 0em; border-style: solid;
        border-color: #BBB;
        font-size: 13px;margin: 0px
    }
    table.bankdetails{ 
        font-size: 14px; 
        width: 100%;
        border-collapse: collapse; 
        padding: 0px;
        border: 1px solid #000;
        border-spacing: 0;
    }
    table.bankdetails tbody tr td { 
        border-width: 1px; 
        border: 1px solid black;
        font-size: 14px;margin: 1px;
        padding-left: 10px;
        padding-top: 1px; 
        border-spacing: 0;
    }
    p{padding: 8px;margin: 0px;}
    h4 {font-size: 14px; font-weight: bold; padding: 0px; margin: 0px;}
    h1 {font-size: 18px; font-weight: bold; padding: 0px; margin: 0px;}
    small{padding: 0px;font-weight: 400;}
</style>
<body>
    <div class="main_div">
        
        <table width="100%">
            <tr>
                <td rowspan="5" width="20%" align="left"><img src="data:image/png;base64, <?php echo e(base64_encode(@file_get_contents(public_path('logo.png')))); ?>" width="150px;" height="100px"></td>
                <td align="left">
                	<h1><strong>OLYMPUS ASSET LIMITED </strong></h1>
                    <h4>Office 2, Level 4, ICONEBENE, Lot B441, Rue de l’Institut,</h4>
                    <h4>Ebene 72201 Mauritius.</h4>

            		

            		<h4><strong>Email: </strong><a href="mailto:admin@olympus-asset.com"><strong>admin@olympus-asset.com</strong></a></h4>
                </td>
            </tr>
        </table>
        <img src="data:image/png;base64, <?php echo e(base64_encode(@file_get_contents(public_path('images/media/hr.png')))); ?>" width="100%" height="15px">
                
        <table  width="100%">
            <tr>
                <td width="10%"></td>
                <td align="right"></td> 
                <td align="right"></td>
                <td align="right">
                    <?php
                        if (!empty($subscription->investment_name)) {
                            if (($subscription->status == 3) || ($subscription->status == 6)) {
                                $investment_no = $subscription->investment_name.$subscription->investment_no;
                            } else {
                                $investment_no = $subscription->investment_name.$subscription->investment_no;
                            }
                        }else{
                            $investment_no = $subscription->investment_no;
                        }
                    ?>
                    
                </td>
            </tr>
            <tr>
                <td><h4>NAME: </h4></td> <td colspan="3"><h4> <?= $subscription->name ?>
                </h4></td>
            </tr>
            <tr>
                <td><h4>Address: </h4></td>
                <td  colspan="3"><?= $subscription->address_line1 ?>, 
                        <?= $subscription->address_line2 ?>, 
                        <?= $subscription->city ?>, <?= $subscription->post_code ?>, 
                        <?= $subscription->state ? $subscription['SubscriptionStateAs']['name'] : '' ?>,
                        <?= $subscription->country ? $subscription['SubscriptionCountryAs']['name'] : '' ?>.
                </td>
            </tr>
            <tr>
                <td><h4>Date: </h4></td>
                <td  colspan="3">
                <?php 
                    if(!empty($subscription->bank_instruction_date)){ 
                        echo date('d-F-Y', strtotime($subscription->bank_instruction_date));
                    }else{ 
                        echo date('d-F-Y', strtotime($subscription->created_at));
                    } 
                ?>
                </td>
            </tr>
            <tr><td colspan="4"></td></tr>
        </table>

        <br>

        <?php

            $salutation = '';

            if ( $subscription->salutation == "Mr." ) {
                $salutation = "Sir";
            } elseif ( $subscription->salutation == "Mrs." ) {
                $salutation = "Madam";
            } else {
                $salutation = $subscription->salutation;
            }

         ?>

         

        <h4>Dear <?= !empty($subscription->salutation) ? $subscription->salutation : '' ?> <?= $subscription->name ?></h4>
        <br>
        <h1><u><strong>RE: BANKING DETAILS</strong></u></h1>
        <br>
        <table width="100%" class="bankdetails" cellspacing="0" cellpadding="0">
                
            <tr>
                <td width="40%"><p>Name of Recipient :</p></td>
                <td width="60%"><p><?php echo e(config('settings.recipient_name')); ?></p></td>
            </tr>
            <tr>
                <td><p>Recipient&rsquo;s Account Number :</p></td>
                <td><p><?php echo e(config('settings.recipient_account_no')); ?></p></td>
            </tr>
            <tr>
                <td><p>Recipient&rsquo;s Contact No :</p></td>
                <td><p><?php echo e(config('settings.recipient_contact_no')); ?></p></td>
            </tr>
            <tr>
                <td><p>Recipient&rsquo;s Address :</p></td>
                <td><p><?php echo e(config('settings.recipient_address')); ?></p>
                </td>
            </tr>

            <tr>
                <td><p>Beneficiary Bank :</p></td>
                <td><p><?php echo e(config('settings.beneficiary_bank')); ?></p></td>
            </tr>
            <tr>
                <td><p>Beneficiary Bank&rsquo;s SWIFT Code :</p></td>
                <td><p><?php echo e(config('settings.beneficiary_swift_code')); ?></p></td>
            </tr>
            <tr>
                <td><p>Bank Code :</p></td>
                <td><p><?php echo e(config('settings.bank_code')); ?></p></td>
            </tr>
            <tr>
                <td><p>Branch Code :</p></td>
                <td><p><?php echo e(config('settings.branch_code')); ?></p></td>
            </tr>
            <tr>
                <td><p>Beneficiary Bank&rsquo;s Address :</p></td>
                <td><p><?php echo e(config('settings.beneficiary_bank_address')); ?></p></td>
            </tr>
            <tr>
            	<?php if($subscription->is_first == 1){ ?>
                	<td><p>Initial Investment (USD) : </p></td>
	            <?php }else if($subscription->is_first == 0){ ?>
	                <td><p>Additional Investment (USD) : </p></td>
	            <?php } ?>
                
                <td><p> <?= number_format($subscription->amount) ?></p></td>
                </td>
            </tr>

            <?php

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

            	//$amount = $subscription->amount;
	    		//$subscription_fee =  $subscription->service_charge;
	    		//$percent = ($amount * $subscription_fee)/100;
	    		//$total = $amount + $percent + $escrow_charge;
            ?>

            <tr>
                <td><p><?= $subscription_fee; ?>% Sales Charge (USD) :</p></td>
                <td><p><?= number_format($percent) ?></p></td>
            </tr>
            <tr>
                <td><p> Escrow Service Fee (USD) :</p></td>
                <td><p><?= number_format($escrow_charge) ?></p></td>
            </tr>
            <tr>
                <td><p>Total of Wire Transfer (USD): </p></td>
                <td><p><?= number_format($total) ?> </p></td> 
            </tr>
            <tr>
                <td><p>Charges :</p></td>
                <td><p>All bank charges to be borne by Investors</p></td>
            </tr>
        </table>
        <p>**Kindly upload the wire transfer slip to the CRM as proof of funding.</p>
        <p><strong>Kindly be informed that Zetland Consultants Pte Ltd is the appointed escrow agent</strong></p>
        <p></p>
        <p>Thank you.</p>
        <p>Olympus Asset Limited</p>
        <p></p>
	    <br><br>
	    <p class="font-12" style="text-align:center;"><b>"This is a computer-generated document. No signature is required"</b></p>
    </div>
</body>
</html><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/pdf/bankPdf.blade.php ENDPATH**/ ?>