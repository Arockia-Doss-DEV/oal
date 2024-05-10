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
		font-size: 18px; 
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
    	background-color: #996633;
    	color: white;
    }
    .mr-1{
		padding: 10px 25px;
	}
</style>
<body>

	

    <table width="100%">
        <tr>
            <td rowspan="5" width="20%" align="center">
				<td style="font-size: 23px; font-weight: bold;"><span class="highlight">DECLARATION OF SOURCE OF FUNDS/WEALTH</span></td>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%" class="mr-1">

        <tr>
            <td class="font-15">Date: <br><br></td>
        </tr>

        <tr>
            <td class="font-15">The Directors</td>
        </tr>
        <tr>
            <td class="font-15">Mauri Experta Ltd</td>
        </tr>
        <tr>
            <td class="font-15">Office 2, Level 4, ICONEBENE,</td>
        </tr>
        <tr>
            <td class="font-15">Lot B441, Rue de l'lnstitut, Ebene,</td>
        </tr>
        <tr>    
            <td class="font-15">Mauritius <br></td>
        </tr>

	    <tr><td></td></tr>       
    </table>

	<!-- <h2 class="pagenumber"><p style="font-size: 25px; font-style: italic;">Class A Participating Shares</p></h2> -->
	<table width="100%" class="number-table">
		<tbody>

			<tr>
		        <td class="font-15">Dear Sirs, </td>
			</tr>
		</tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>
		    <tr>
		        <td class="f-w-7 font-15" width="22%">Subject: Mr./Mrs </td>
		        <td class="font-15"><u class="dotted"> <?php echo e($subscription->name); ?> </u></td>

			</tr>
		</tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
		        <td class="font-15">I am pleased to confirm that I have built my wealth by:	</td>
			</tr>
		</tbody>
	</table>

	<?php
        $principal_source_of_wealth = explode(', ', $subscription->source_of_wealth);
    ?>

	<table width="100%" class="number-table">
		<tbody>
			<?php $__currentLoopData = $principal_source_of_wealth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $source_of_wealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" checked /></td>
					<td  class="font-15"><?php echo e($source_of_wealth); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>

	

	<?php if( !empty($subscription->source_of_wealth_other) &&  in_array('Other', $principal_source_of_wealth) ){ ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
		        <td class="font-15"><u class="dotted"> <?php echo e($subscription->source_of_wealth_other); ?> </u></td>
			</tr>
		</tbody>
	</table>

	<?php } ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
		        <td class="font-15">No monies have been derived from any criminal activities of any nature whatsoever.</td>
			</tr>
			<tr>
		        <td class="font-15">I further confirm that my source of funds come from: </td>
			</tr>
		</tbody>
	</table>

	<?php
        $principal_source_of_wealth_funds_comes = explode(', ', $subscription->source_of_wealth_funds_comes);
    ?>

	<table width="100%" class="number-table">
		<tbody>
			<?php $__currentLoopData = $principal_source_of_wealth_funds_comes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $source_of_wealth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" checked /></td>
					<td  class="font-15"><?php echo e($source_of_wealth); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>

	<?php if( !empty($subscription->source_of_wealth_funds_comes_other) &&  in_array('Other', $principal_source_of_wealth_funds_comes) ){ ?>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
		        <td class="font-15"><u class="dotted"> <?php echo e($subscription->source_of_wealth_funds_comes_other); ?> </u></td>
			</tr>
		</tbody>
	</table>

	<?php } ?>

	<table width="100%" class="number-table">
		<tbody>

			<tr>
		        <td class="font-15">I confirm that:</td>
			</tr>
			<tr>
		        <td class="font-15">I am acting in my own name and not in any nominee capacity or as nominee beneficial owner and the funds have been adequately disclosed and taxed in the jurisdiction where the funds emanate from.</td>
			</tr>
			<tr>
		        <td class="font-15">The declaration made above is true, complete and accurate in all respects and I undertake to immediately notify Mauri Experta Ltd of any act or thing that would render the declaration untrue, incomplete or inaccurate.</td>
			</tr>
			<tr>
		        <td class="font-15">Thanking you.</td>
			</tr>
			<tr>
		        <td class="font-15">Yours faithfully,</td>
			</tr>
			<tr><td style="padding-top:60px;"></td></tr>
		</tbody>
	</table>

	<table width="100%" class="number-table" style="padding-top: 20px;">
		<tbody>
		<tr>
			<td width="55%" class="font-15">__________________________</td>

			<?php if($subscription->UserAs->role_id == 6): ?>
				<td width="55%" class="font-15">__________________________</td>
			<?php endif; ?>
			
		</tr>
		<tr>
			
			<td>Name: </td>

			<?php if($subscription->UserAs->role_id == 6): ?>
				<td>Name: </td>
			<?php endif; ?>
			
		</tr>
		</tbody>
	</table>
	
</body>
</html><?php /**PATH /var/www/html/olympus-asset.com/public_html/resources/views/pdf/sourceOfFundPdf.blade.php ENDPATH**/ ?>