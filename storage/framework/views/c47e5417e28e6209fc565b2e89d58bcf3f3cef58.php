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
		font-family: 'Poppins';
		font-size: 14px; 
		padding: 0px; 
		margin: 0px;
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
    th, td { 
        border-width: 0px; 
        padding: 0em; 
        position: relative;
        border-radius: 0em; border-style: solid;
        border-color: #BBB;
        font-size: 13px;margin: 0px
    }  
    p{padding: 8px;margin: 0px;}
    h4 {font-size: 18px; font-weight: bold; padding: 0px; margin: 0px;}

	.double {
		background-image: linear-gradient(to bottom, red 33%, transparent 33%, transparent 66%, red 66%, red);
		background-position: 0 1.03em;
		background-repeat: repeat-x;
	  	background-size: 2px 6px;
	}
	.underline {
		border-bottom: 2px solid currentColor;
		display: inline-block;
		line-height: 0.85;
		text-shadow:2px 2px white,2px -2px white,-2px 2px white,-2px -2px white;
	}
	.font-12{
		font-size: 12px
	}
	.font-13{
		font-size: 13px
	}
	.font-14{
		font-size: 14px
	}
	.font-15{
		font-size: 15px
	}
	.font-16{
		font-size: 16px
	}
	.font-18{
		font-size: 18px
	}
	.font-19{
		font-size: 19px
	}
	.font-20{
		font-size: 20px
	}
	.font-21{
		font-size: 21px
	}
	.font-22{
		font-size: 22px
	}
	.f-w-4{
		font-weight: 400;
	}
	.f-w-6{
		font-weight: 600;
	}
	.f-w-7{
		font-weight: 700;
	}
	.f-w-1{
		font-weight: 100;
	}
	.cl-35{
		    width: 35%;
    background: #d8dfde;
	}
	.cl-30{
		   width: 30%;
    background: #d8dfde;
	}
	.cl-40{
		   width: 45%;
    background: #d8dfde;
	}
	.l-s{
		letter-spacing: 1px
	}
	.fo-rm td{
		padding: 17px 40px;
	}
	.fo-rm-index td{
		padding: 7px 30px;
	}
	.fo-rm-index .page-no{
		padding-left: 150px;
	}
	.fo-rm-index{
		padding: 17px 60px;
	}
	.fo-rm-page3 td{
		padding: 10px 25px;
	}
	.number-table td{
		padding: 5px 25px;
		/*padding: 10px 25px;*/
		/*padding: 0 4px 0 0;*/
	}
	.t-c{
		text-align: center;
	}
	.pos-rel{
	    position:relative;
	}
	.pt-1{
		padding-top: 10px;
	}
	.page2-address{
		padding-top: 10px;
		padding-left: 30px;
	}
	.pagenumber{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	u.dotted{
        /*border-bottom: 2px dashed #000;*/
        border-bottom: 1px solid #000;
        text-decoration: none; 
        width: 100%;
        display: block;
    }
    span.help{
        font-size: 11px;
        color:#999;
    }
    td.mr-1{
		vertical-align: top;
		padding-top: 12px;
	}
</style>
<body>
	<div class="new-page"></div>
	<table>
        <tbody align="center">
            <tr><td style="padding-top:10px;"></td></tr>
            <tr><td><img src="data:image/png;base64, <?php echo e(base64_encode(@file_get_contents(public_path('logo.png')))); ?>" width="150px;" height="100px"></td></tr>
        </tbody>
    </table>

    <table>
    	<tbody align="center">
    		<tr>
    			<td>
    				<?php if($subscription->investment_class_type == '1'): ?>
					<h2 class="pagenumber">Additional Subscription Form <br> Class A Participating Shares</h2>
					<?php elseif($subscription->investment_class_type == '2'): ?>
					<h2 class="pagenumber">Additional Subscription Form <br> Class B Participating Shares</h2>
					<?php else: ?>
					<h2 class="pagenumber">Additional Subscription Participating Shares</h2>
					<?php endif; ?>
    			</td>
    		</tr>
    		
    	</tbody>
    </table>

    

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<?php 
					if ($subscription->UserAs->role_id == 3) {
						$salutation = $subscription->salutation ? $subscription->salutation : '';
					} else {
						$salutation = '';
					}
				?>

				
				<td width="30%" class="font-15 f-w-7 mr-1">NAME OF SUBSCRIBER:</td>
				<td class="font-15 "> <u class="dotted"><?= $subscription->name ?></u>
					
				    
				</td>
			</tr>
			<tr>
				<td width="30%" class="font-15 f-w-7 mr-1">ADDRESS:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->address_line1); ?>, <?php echo e($subscription->address_line2); ?>, <?php echo e($subscription->city); ?>, <?php echo e($subscription->post_code); ?>, <?php echo e($subscription['SubscriptionStateAs']['name']); ?>, <?php echo e($subscription['SubscriptionCountryAs']['name']); ?>. </u>

				    

				</td>
			</tr>
			
	    </tbody>
	</table>

	

	<table width="100%" class="number-table">
		<tbody>

			<tr>
				
				<td width="30%" class="font-15 f-w-7 mr-1">SUBSCRIPTION AMOUNT:</td>
				<td class="font-15 "><u class="dotted">USD$ <?php echo e($subscription->amount); ?></u>
					<br>
					
					
					<u class="dotted"><?php echo e(strtoupper($currency_word)); ?> USD</u>

					

				</td>
			</tr>

		</tbody>
	</table>

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
		    <tr>
		        <td class="font-15 f-w-7">BANK ACCOUNT DETAILS OF THE FUND:</td>
			</tr>
			<tr>
		        <td class="font-15">The Subscriber shall pay the full subscription amount, free of any and all charges (including but not limited to bank charges), for the subscribed Shares directly to the bank account of the Fund as set out below:</td>
			</tr>
		</tbody>
	</table>

	<?php if($subscription->investment_class_type == '1'): ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 font-15" width="45%" >Bank Name:</td>
				<td class="font-15">AfrAsia Bank Ltd</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Bank Address:</td>
				<td class="font-15 ">Bowen Square, 10, Dr Ferriere Street, Port Louis, Mauritius</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Account Name:</td>
				<td class="font-15 ">OLYMPUS ASSET LTD</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Account Number:</td>
				<td class="font-15 ">080890000000027</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Swift Address:</td>
				<td class="font-15 ">AFBLMUMU</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Bank IBAN#:</td>
				<td class="font-15 ">MU12AFBL2501080890000000027USD</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Name:</td>
				<td class="font-15 ">Citibank NA</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Address:</td>
				<td class="font-15 ">388, Greenwich Street, New York, NY 10013, USA</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent	Bank Account Number:</td>
				<td class="font-15 ">36889497</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">SWIFT Code:</td>
				<td class="font-15 ">CITIUS33</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Reference:</td>
				<td class="font-15 ">Subscription of shares</td>
			</tr>
		</tbody>
	</table>

	<?php elseif($subscription->investment_class_type == '2'): ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 font-15" width="45%" >Bank Name:</td>
				<td class="font-15 ">AfrAsia Bank Ltd</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Bank Address:</td>
				<td class="font-15 ">Bowen Square, 10, Dr Ferriere Street, Port Louis, Mauritius</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Account Name:</td>
				<td class="font-15 ">OLYMPUS ASSET LTD</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Account Number:</td>
				<td class="font-15 ">080890000000038</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Swift Address:</td>
				<td class="font-15 ">AFBLMUMU</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Bank IBAN#:</td>
				<td class="font-15 ">MU44AFBL2501080890000000038USD</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Name:</td>
				<td class="font-15 ">Citibank NA</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Address:</td>
				<td class="font-15 ">388, Greenwich Street, New York, NY 10013, USA</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent	Bank Account Number:</td>
				<td class="font-15 ">36889497</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">SWIFT Code:</td>
				<td class="font-15 ">CITIUS33</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Reference:</td>
				<td class="font-15 ">Subscription of shares</td>
			</tr>
		</tbody>
	</table>

	<?php else: ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 font-15" width="45%" >Bank Name:</td>
				<td class="font-15 "><u class="dotted">AfrAsia Bank Ltd</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Bank Address:</td>
				<td class="font-15 "><u class="dotted">Bowen Square, 10, Dr Ferriere Street, Port Louis, Mauritius</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15" >Account Name:</td>
				<td class="font-15 "><u class="dotted">OLYMPUS ASSET LTD</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Account Number:</td>
				<td class="font-15 "><u class="dotted">080890000000027</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Swift Address:</td>
				<td class="font-15 "><u class="dotted">AFBLMUMU</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Bank IBAN#:</td>
				<td class="font-15 "><u class="dotted">MU12AFBL2501080890000000027USD</u>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Name:</td>
				<td class="font-15 "><u class="dotted">Citibank NA</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent Bank Address:</td>
				<td class="font-15 "><u class="dotted">388, Greenwich Street, New York, NY 10013, USA</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Correspondent	Bank Account Number:</td>
				<td class="font-15 "><u class="dotted">36889497</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">SWIFT Code:</td>
				<td class="font-15 "><u class="dotted">CITIUS33</u>
				</td>
			</tr>
			<tr>
				<td width="45%" class="f-w-7 font-15">Reference:</td>
				<td class="font-15 "><u class="dotted">Subscription of shares</u>
				</td>
			</tr>
		</tbody>
	</table>

	<?php endif; ?>

	

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
			<tr>
				<td width="55%" class=" font-15">This Subscription Agreement has been executed this _________day of_____________________________</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
		<tr>
			<td width="55%" class="f-w-7 font-15">SIGNED by [NAME]
				</td>
			<td></td>
		</tr>
		<tr>
			<td width="55%" class="f-w-7 font-15">duly authorised
				</td>
			<td></td>
		</tr>
		<tr>
			<td width="55%" class="f-w-7 font-15">Name</td>
			<td><?= $subscription->name ?></td>
		</tr>
		<tr>
			<td width="55%" class="f-w-7 font-15 ">Date
			<td></td>
		</tr>
		<tr>
			<td width="55%" class="f-w-7 font-15">Place
			<td></td>
		</tr>
		</tbody>
	</table>
	
</body>
</html><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/pdf/additionalSingedPdf.blade.php ENDPATH**/ ?>