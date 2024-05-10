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
        border-bottom: 1px solid #000;
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

	td.mr-1{
		vertical-align: top;
		padding-top: 12px;
	}
</style>
<body>

	<div class="new-page"></div>

    <table width="100%">
        <tr>
        	<td rowspan="5" width="20%" align="center">
            	<img src="data:image/png;base64, <?php echo e(base64_encode(@file_get_contents(public_path('logo.png')))); ?>" width="140px;" height="95px">
            	<td style="float: left;"></td><br>
            	<td style="float: left; font-size:19px; padding-top: 15px;">Bank Details Update Request Form </td>

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

    

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 mr-1" width="20%">NAME OF SUBSCRIBER:</td>
				<td class="font-15"> <u class="dotted"><?php echo e($subscription->salutation); ?> <?php echo e($subscription->name); ?></u>
				    
				</td>
			</tr>
			<tr>
				<td class="f-w-7 mr-1" width="20%">ADDRESS:</td>
				<td class="font-15"><u class="dotted"><?php echo e($subscription->address_line1); ?>, <?php echo e($subscription->address_line2); ?>, </u>
					<br>
					
					<u class="dotted"><?php echo e($subscription->city); ?>, <?php echo e($subscription->post_code); ?>,</u><br>
					<u class="dotted"><?php echo e($subscription['SubscriptionStateAs']['name']); ?>, <?php echo e($subscription['SubscriptionCountryAs']['name']); ?></u>

					
				</td>
			</tr>
			
	    </tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>

			<tr>
				<td class="f-w-7 mr-1" width="20%" >Subscription Amount:</td>
				<td class="font-15"><u class="dotted"></u></td>
			</tr>

			<tr>
				<td class="f-w-7 mr-1" width="20%" ></td>
				<td class="font-15"><u class="dotted"></u></td>
			</tr>

		</tbody>
	</table>

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
		    <tr>
		        <td class="font-15 f-w-7">BANK ACCOUNT DETAILS OF SUBSCRIBER:</td>
			</tr>
			<tr>
		        <td class="font-15">I would like to change my bank account details for which distributions will be sent. I confirm that all distributions payable to me will be sent to this new bank account, subject to the Constitution's provision or as otherwise required by law. I understand and be responsible for informing the Fund of any amendments to any details provided below. </td>
			</tr>
		</tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="f-w-7 font-15 mr-1" width="35%" >Bank Name:</td>
				<td class="font-15"><u class="dotted"></u></td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Bank Address:</td>
				<td class="font-15"><u class="dotted"></u></td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Account Name:</td>
				<td class="font-15 "><u class="dotted"></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Account Number:</td>
				<td class="font-15 "><u class="dotted"></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Swift Address:</td>
				<td class="font-15 "><u class="dotted"></u>
				</td>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Bank IBAN#:</td>
				<td class="font-15 "><u class="dotted"></u>
			</tr>
			<tr>
				<td width="35%" class="f-w-7 font-15 mr-1">Reference:</td>
				<td class="font-15 "><u class="dotted"></u>
				</td>
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
</html><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/pdf/bankDetailsPdf.blade.php ENDPATH**/ ?>