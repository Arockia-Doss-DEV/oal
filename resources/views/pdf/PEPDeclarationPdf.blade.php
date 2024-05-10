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
		font-size: 16px; 
		padding: 0px; 
		margin: 0px;
	}
    @media print {
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
        font-size: 16px;margin: 0px
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
		font-size: 17px
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
		font-size: 25px
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

    td.mr-1{
		vertical-align: top;
		padding-top: 12px;
	}

	.shrink-table td{
		padding: 1px 25px;
	}

	.shrink-table2 td{
		padding: 7px 25px;
	}

	.company-name {
		/*float: left;*/
		font-size: 30px !important;
		font-style: bold;
	}

	span.highlight {
    	background-color: #996633;
    	color: white;
    }

    span.color-text {
    	color: #996633;
    	/*font-size: larger;*/
    }

    .number-table td {
	 	padding: 7px 24px;
	}

</style>
<body>

	<!-- page 1 -->
    <table>
        <tbody align="center">
        	<tr><td style="padding-bottom:20px;"></td></tr>
            <tr>
            	<td>
            		<img src="data:image/png;base64, {{ base64_encode(@file_get_contents(public_path('mauri-logo.png'))) }}" width="150px;" height="90px">
            	</td>
            </tr>
            <tr><td style="padding-top:40px;"></td></tr>
        </tbody>
    </table>
	
	<table width="100%" class="number-table">
		<tbody>
		    <tr>
		        <td class="font-18 f-w-7"><span class="highlight">DECLARATION OF POLITICALLY EXPOSED PERSON STATUS FORM</span></td>
			</tr>
			<tr>
		        <td class="font-16"><span class="color-text">Please answer the questions/state the information requested below with regards to Politically Exposed Person (“PEP”). This is to enable the Company to comply with its obligations pursuant to the Financial Intelligence and Anti-Money Laundering Act 2002 relating to measures to combat money laundering and the financing of terrorism.</span></td>
			</tr>
		</tbody>
	</table>

	<!-- Page 12 -->
	{{-- <div class="new-page"></div> --}}

	<table width="100%" class="number-table">
		<tbody>
		<tr>
			<td width="55%" class="font-15">1. Do you currently hold or have you been entrusted in the past with a prominent public function (1), or are you an immediate family member (2), or close associate (3) of such a PEP?</td>
		</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="5%" class="font-15"><input type="checkbox" {{ ($subscription->peb_declaration_status == 1) ? "checked" : ''}} /></td>
				<td  class=" font-15">No  </td>
			</tr>
			<tr>
				<td width="5%" class="font-15"><input type="checkbox" {{ ($subscription->peb_declaration_status == 2) ? "checked" : ''}} /></td>
				<td class=" font-15">Yes </td>
			</tr>
		</tbody>
	</table>

	{{-- <?php if($subscription->peb_declaration_status == 2){ ?> 

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="75%" class="font-15"> If yes, please specify (functions held, when and for how long, etc...)</td>
			</tr>
			<tr>
				<td class="f-w-7"><u class="dotted"> {{ $subscription->peb_declaration_other }} </u></td>
			</tr>
		</tbody>
	</table>

	<?php } ?> --}}

	@if ($subscription->peb_declaration_status == 1)

		<table width="100%" class="number-table">
			<tbody>
			<tr>
				<td width="55%" class="font-15">Origin of the funds/ wealth</td>
			</tr>
			<tr>
				<td width="55%" class="font-15">2.	If you have answered yes to the question above, the origin of any current, and the expected origin of any future funds/ wealth, must be provided</td>
			</tr>
			</tbody>
		</table>

		<table width="100%" class="number-table">
			<tbody>
				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Business operations</td>
				</tr>

				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Returns on investments </td>
				</tr>

				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Loans </td>
				</tr>

				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Salaries</td>
				</tr>

				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Inheritance</td>
				</tr>

				<tr>
					<td width="5%" class="mr-1"><input type="checkbox" /></td>
					<td  class="font-15">Other Please specify</td>
				</tr>
			</tbody>
		</table><br>

		<table width="100%" class="number-table">
			<tbody>
				<tr>
					<td class="f-w-7"><u class="dotted"> </u></td>
				</tr>
			</tbody>
		</table>

	@elseif ($subscription->peb_declaration_status == 2)

		<table width="100%" class="number-table">
			<tbody>
			<tr>
				<td width="55%" class="font-15">Origin of the funds/ wealth</td>
			</tr>
			<tr>
				<td width="55%" class="font-15">2.	If you have answered yes to the question above, the origin of any current, and the expected origin of any future funds/ wealth, must be provided</td>
			</tr>
			</tbody>
		</table>

		<?php
	        $principal_origin_fund_wealth = explode(', ', $subscription->origin_fund_wealth);
	    ?>

		<table width="100%" class="number-table">
			<tbody>

				@foreach ($principal_origin_fund_wealth as $key => $origin_fund_wealth)
					
					<tr>
						<td width="5%" class="mr-1"><input type="checkbox" checked /></td>
						<td  class="font-15">{{ $origin_fund_wealth }}</td>
					</tr>

				@endforeach

				{{-- <tr>
					<td width="5%" class="mr-1"><input type="checkbox" {{ (is_array($ofw_option) and in_array('Inheritance', $ofw_option)) ? 'checked' : '' }} /></td>
					<td  class="font-15"> Inheritance</td>
				</tr> --}}

			</tbody>
		</table>

		<?php if( !empty($subscription->origin_fund_wealth_other) &&  in_array('Other', $principal_origin_fund_wealth) ){ ?> 

		<br>
		<table width="100%" class="number-table">
			<tbody>
				<tr>
					<td class="font-15"><u class="dotted"> {{ $subscription->origin_fund_wealth_other }} </u></td>
				</tr>
			</tbody>
		</table>

		<?php } ?>

	@endif

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="55%" class="font-15">I/We hereby confirm that the above-stated information is correct and complete. /We undertake to promptly inform you in writing if there is any change in the status as declared above.
				</td>
			</tr>
			<tr><td style="padding-top:10px;"></td></tr>
		</tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="30%" class="font-15">Signature: </td>
				<td><u class="dotted"></u></td>
			</tr>
			<tr>
				<td width="30%" class="font-15">Client’s/ Principal’s name: </td>
				<td><u class="dotted"></u></td>
			</tr>
			<tr>
				<td width="30%" class="font-15">For and on behalf of  </td>
				<td></td>
			</tr>

			<tr>
				<td width="30%" class="font-15">Date: </td>
				<td></td>
			</tr>
			<tr><td style="padding-top:20px;"></td></tr>
		</tbody>
	</table>
	
	<!-- Page 14 -->
	{{-- <div class="new-page"></div> --}}

	<table width="100%" class="number-table">
		<tbody>
		    <tr>
		        <td class="font-18">Definitions relating to the term “Politically Exposed Person”:</td>
			</tr>
			<tr>
				<td class="font-18">1) Prominent public function1 is:</td>
			</tr>
		</tbody>
	</table>

	<table width="100%" class="number-table">
		<tbody>
		<tr>
			<td width="5%" class="mr-1">a.</td>
			<td class="font-15">Head of State or of Government,</td>
		</tr>
		<tr>
			<td width="5%" class="mr-1">b.</td>
			<td class="font-15">senior politicians,</td>
		</tr>
		<tr>
			<td width="5%" class="mr-1">c.</td>
			<td class="font-15">senior government/judicial/military officers,</td>
		</tr>
		<tr>
			<td width="5%" class="mr-1">d.</td>
			<td class="font-15" >senior executives of state-owned-corporations,</td>
		</tr>
		<tr>
			<td width="5%" class="mr-1">e.</td>
			<td class="font-15">important political party officials.</td>
		</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="font-18">2) Immediate family member2 is:</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="5%" class="mr-1">a.</td>
				<td class="font-15">Spouse or a partner,</td>
			</tr>
			<tr>
				<td width="5%" class="mr-1">b.</td>
				<td class="font-15">children,</td>
			</tr>
			<tr>
				<td width="5%" class="mr-1">c.</td>
				<td class="font-15">spouse or partner of the children,</td>
			</tr>
			<tr>
				<td width="5%" class="mr-1">d.</td>
				<td class="font-15">or close parent.</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="font-18">3) Close associate2 is a natural person who is known to :</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td width="5%" class="mr-1">a.</td>
				<td class="font-15">be a jointly beneficial owner of a legal entity or legal arrangement (trust) with a person mentioned above in item 1 or 2,</td>
			</tr>
			<tr>
				<td width="5%" class="mr-1">b.</td>
				<td class="font-15">have close business associations with a person mentioned above in item 1 or 2,</td>
			</tr>
			<tr>
				<td width="5%" class="mr-1">c.</td>
				<td class="font-15">be the beneficial owner of a legal entity or legal arrangement (trust) set up.
				</td>
			</tr>
			<tr><td style="padding-top:50px;"></td></tr>
		</tbody>
	</table>
	<hr>

	<table width="100%" class="number-table">
		<tbody>
			<tr>
				<td class="font-15">1. Definition provided by Paragraph 5.3.1 of Code On The Prevention of Money Laundering & Terrorist Financing of May 2017 (Issued under Section 7(1)(a) of the Financial Services Act 2007 and Section 18(1)(a) of the Financial Intelligence and Anti-Money Laundering Act 2002) and FIAML Regulations 2018.
					</td>
			</tr>
			
			<tr>
				<td class="font-15">2. Source: FATF Guidance relating to Politically Exposed Persons (recommendations 12 and 22). For more information, please refer to www.fatf-gafi.org
				</td>
			</tr>
			<tr><td style="padding-top:60px;"></td></tr>
		</tbody>
	</table>
	
</body>
</html>