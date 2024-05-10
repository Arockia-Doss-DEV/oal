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
		padding: 10px 25px;
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
        border-bottom: 2px dashed #000;
        text-decoration: none; 
        width: 100%;
        display: block;
    }
    span.help{
        font-size: 11px;
        color:#999;
    }
    span.highlight {
    	background-color: #FFFF00;
    }
    .mr-1{
		padding: 10px 25px;
	}
</style>
<body>

	<div class="new-page"></div>

	

    <table width="100%">
        <tr>
            <td rowspan="5" width="20%" align="center">
            	<img src="data:image/png;base64, <?php echo e(base64_encode(@file_get_contents(public_path('logo.png')))); ?>" width="140px;" height="95px">
            	<td style="float: left;"></td><br>
            	<td style="float: left; font-size:21px; padding-top: 15px;">Redemption Request Form </td>

            	<?php if($subscription->investment_class_type == '1'): ?>
				<td style="float: left; font-size: 23px; font-style: italic;">Class A Participating Shares</td>
				<?php elseif($subscription->investment_class_type == '2'): ?>
				<td style="float: left; font-size: 23px; font-style: italic;">Class B Participating Shares</td>
				<?php else: ?>
				<td style="float: left; font-size: 23px; font-style: italic;">Participating Shares</td>
				<?php endif; ?>
            </td>
            <td align="center">

            </td>
        </tr>
    </table>
    <hr><hr>

    

    <table width="100%" class="mr-1">
        <tr>
            <td><h4> Olympus Asset Ltd</h4></td>
        </tr>
        <tr>
            <td>Office 2, Level 4,</td>
        </tr>
        <tr>
            <td>ICONEBENE, Lot B441,</td>
        </tr>
        <tr>    
            <td>Rue de l’Institut, Ebene 72201 Mauritius <br><br></td>
        </tr>

	    <tr>
	    	<td>Telephone Number: + (230) 466 6100 / 63</td>
	    </tr>
	    <tr>    
            <td>Fax Number:  + (230) 468 1221</td>
        </tr>
        <tr>    
            <?php if($subscription->investment_class_type == '1'): ?>
			<td>Email id: <a href="mailto:kiran.seechurn@mauriexperta.com">kiran.seechurn@mauriexperta.com; </a>
				<a href="mailto:deepa.badal@mauriexperta.com;">deepa.badal@mauriexperta.com; </a>
				<a href="mailto:fundadmin@mauriexperta.com">fundadmin@mauriexperta.com; </a>

			</td>
			<?php elseif($subscription->investment_class_type == '2'): ?>
			<td>Email id: <a href="mailto:kiran.seechurn@mauriexperta.com">kiran.seechurn@mauriexperta.com; </a></td>
			<?php else: ?>
			<td>Email id: <a href="mailto:kiran.seechurn@mauriexperta.com">kiran.seechurn@mauriexperta.com; </a></td>
			<?php endif; ?>
        </tr>
	    <tr><td></td></tr>       
    </table>

	<!-- <h2 class="pagenumber"><p style="font-size: 25px; font-style: italic;">Class A Participating Shares</p></h2> -->
	<table width="100%" class="number-table">
		<tbody>

			<?php if($subscription->investment_class_type == '1'): ?>

		    <tr>
		        <td class="font-15">Dear Sir / Madam </td>
			</tr>
			<tr>
		        <td class="font-15">We refer to the Private Placement Memorandum (PPM) dated 27 March 2023. Terms defined in the PPM shall bear the same meaning herein and shall be deemed to have been set out in full in this redemption request form and shall be read and construed together with this document.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We the undersigned, hereby request you to kindly redeem all or a portion of my Participating Shares as per the below details. l/We understand that the instructions given below will be adequate for Olympus Asset Ltd (the “Fund”) to process the redemption request.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We will not hold the Fund liable in any manner whatsoever if the redemption proceeds are delayed or are not effected at all, for reasons of incomplete/incorrect information submitted by me/us.</td>
			</tr>
			<tr>
		        <td class="font-15">The signed redemption form must be sent to the Administrator either by email or by fax and the originals to be couriered at the Administrator’s address mentioned above, 10 business days before the valuation day which is the redemption notice period.</td>
			</tr>
			<tr>
		        <td class="font-15">The minimum redemption for each shareholder shall be $1,000 or in equivalent currency.</td>
			</tr>
			<tr>
		        <td class="font-15">There will be a redemption charge of 10 percent on all initial investment amount subscribed, if the redemption is made within one year of the initial subscription. There will be no redemption charge after the first-year lock-in.</td>
			</tr>
			<tr>
		        <td class="font-15">The payment of the redemption proceeds will be made no later than 2 months of the relevant redemption dealing day, or such earlier date as the directors may decide in their absolute discretion.</td>
			</tr>
			<tr>
		        <td class="font-15">Redemption proceeds will be paid into the bank account of the shareholder from which the subscription monies were received, and which was disclosed in the initial subscription agreement. No payments will be made to third parties bank account.</td>
			</tr>

			<?php elseif($subscription->investment_class_type == '2'): ?>

			<tr>
		        <td class="font-15">Dear Sir / Madam </td>
			</tr>
			<tr>
		        <td class="font-15">We refer to the Private Placement Memorandum (PPM) dated 27 March 2023. Terms defined in the Prospectus shall bear the same meaning herein and shall be deemed to have been set out in full in this redemption request form and shall be read and construed together with this document.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We the undersigned, hereby request you to kindly redeem all or a portion of my Participating Shares as per the below details. l/We understand that the instructions given below will be adequate for Olympus Asset Ltd (the “Fund”) to process the redemption request.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We will not hold the Fund liable in any manner whatsoever if the redemption proceeds are delayed or are not effected at all, for reasons of incomplete/incorrect information submitted by me/us.</td>
			</tr>
			<tr>
		        

		        <td class="font-15">The signed redemption form must be sent to the Administrator either by email or by fax and the originals to be couriered at the Administrator’s address mentioned above, 10 business days before the valuation day which is the redemption notice period.</td>

			</tr>
			<tr>
		        <td class="font-15">The minimum redemption for each shareholder shall be $1,000 or in equivalent currency.</td>
			</tr>
			<tr>
		        <td class="font-15">There will be a redemption charge of 10 percent on all initial investment amount subscribed, if the redemption is made within one year of the initial subscription. There will be no redemption charge after the first-year lock-in.</td>
			</tr>
			<tr>
		        <td class="font-15">The payment of the redemption proceeds will be made no later than 2 months of the relevant redemption dealing day, or such earlier date as the directors may decide in their absolute discretion.</td>
			</tr>
			<tr>
		        <td class="font-15">Redemption proceeds will be paid into the bank account of the shareholder from which the subscription monies were received, and which was disclosed in the initial subscription agreement. No payments will be made to third parties bank account.</td>
			</tr>

			<?php else: ?>

			<tr>
		        <td class="font-15">Dear Sir / Madam </td>
			</tr>
			<tr>
		        <td class="font-15">We refer to the Private Placement Memorandum (PPM) dated 27 March 2023. Terms defined in the PPM shall bear the same meaning herein and shall be deemed to have been set out in full in this redemption request form and shall be read and construed together with this document.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We the undersigned, hereby request you to kindly redeem all or a portion of my Participating Shares as per the below details. l/We understand that the instructions given below will be adequate for Olympus Asset Ltd (the “Fund”) to process the redemption request.</td>
			</tr>
			<tr>
		        <td class="font-15">l/We will not hold the Fund liable in any manner whatsoever if the redemption proceeds are delayed or are not effected at all, for reasons of incomplete/incorrect information submitted by me/us.</td>
			</tr>
			<tr>
		        <td class="font-15">The signed redemption form must be sent to the Administrator either by email or by fax and the originals to be couriered at the Administrator’s address mentioned above, 10 business days before the valuation day which is the redemption notice period.</td>
			</tr>
			<tr>
		        <td class="font-15">The minimum redemption for each shareholder shall be $1,000 or in equivalent currency.</td>
			</tr>
			<tr>
		        <td class="font-15">There will be a redemption charge of 10 percent on all initial investment amount subscribed, if the redemption is made within one year of the initial subscription. There will be no redemption charge after the first-year lock-in.</td>
			</tr>
			<tr>
		        <td class="font-15">The payment of the redemption proceeds will be made no later than 2 months of the relevant redemption dealing day, or such earlier date as the directors may decide in their absolute discretion.</td>
			</tr>
			<tr>
		        <td class="font-15">Redemption proceeds will be paid into the bank account of the shareholder from which the subscription monies were received, and which was disclosed in the initial subscription agreement. No payments will be made to third parties bank account.</td>
			</tr>

			<?php endif; ?>


		</tbody>
	</table>

	<div class="new-page"></div>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7" width="15%">NAME OF SHAREHOLDER:</td>
				<td class="font-15 "> <u class="dotted"><?php echo e($subscription->salutation); ?> <?php echo e($subscription->name); ?></u>
				    
				</td>
			</tr>
			<tr>
				<td class="f-w-7" width="15%" >ADDRESS:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->address_line1); ?>, <?php echo e($subscription->address_line2); ?>, <?php echo e($subscription->city); ?>, <?php echo e($subscription->post_code); ?>, <?php echo e($subscription['SubscriptionStateAs']['name']); ?>, <?php echo e($subscription['SubscriptionCountryAs']['name']); ?>. </u>
					
				    
				</td>
			</tr>
			
	    </tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>

			<tr>
				<td class="f-w-7" width="15%" >Redemption Amount / Shares:</td>
				<td class="font-15 "><u class="dotted">USD$ </u>
					<span class="help">Please provide the amount / shares which the shareholder is redeeming in figures</span> <br><br>
					
					<u class="dotted"></u>
					<span class="help">Please provide the amount / shares which the shareholder is redeeming in words</span>

				</td>
			</tr>

		</tbody>
	</table>

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
		    <tr>
		        <td class="font-15 f-w-7">BANK ACCOUNT DETAILS OF SHAREHOLDER:</td>
			</tr>
		</tbody>
	</table>

	
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 font-15" width="35%" >Bank Name:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->bank_name); ?></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15" >Bank Address:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->bank_address); ?></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15" >Account Name:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->account_name); ?></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15">Account Number:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->account_number); ?></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15">Swift Address:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->swift_address); ?></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15">Bank IBAN#:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->bank_inan); ?></u>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15">Reference:</td>
				<td class="font-15 "><u class="dotted"><?php echo e($subscription->reference); ?></u>
				</td>
			</tr>
		</tbody>
	</table>

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
			<tr>
		        <td class="font-15">I / We hereby confirm that I / We are in complete agreement with the terms and conditions of the Fund and that we are the Authorised signatories and rightful beneficiary of the redemption proceeds; and all information furnished herein is true and correct.</td>
			</tr>
		</tbody>
	</table>

	
	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
			<tr>
				<td width="55%" class=" font-15">This Redemption request form has been executed this  _________day of_____________________________</td>
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
			<td> <?php echo e($subscription->salutation); ?> <?php echo e($subscription->name); ?> </td>
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
</html><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/pdf/redemptionPdf.blade.php ENDPATH**/ ?>