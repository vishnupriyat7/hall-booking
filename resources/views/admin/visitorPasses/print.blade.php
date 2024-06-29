<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Pass Print</title>

	<style>

			/* .tabless
			{
				border-collapse: collapse;
				width: 100%;
			} */
/*
			.barcodecell
			{
				text-align:center;
				font-size:10px;
			} */
			.body
			{
				font-size: 10px;
				font-family: Arial, sans-serif;
			}

			.printed
			{
					color:black;
			}
			@page {
   				 size: 80mm 110mm; /* landscape */
   					 /* you can also specify margins here: */
    			margin: 0mm;
   			    margin-right: 0mm; /* for compatibility with both A4 and Letter */
  				}
			@media print {
  				@page {
   				 size: 80mm 110mm; /* landscape */
   					 /* you can also specify margins here: */
    			margin: 0mm;
   			    margin-right: 0mm; /* for compatibility with both A4 and Letter */
  				}
			}


		</style>


		<script>

		function bPrint()
		{
            var css = '@page { size: 80mm 110mm; }',
                head = document.head || document.getElementsByTagName('head')[0],
                style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet){
            style.styleSheet.cssText = css;
            } else {
            style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);


		//	window.print();
		//	window.opener.location.href = window.opener.location.href;
			//opener.location.reload();
			//window.close();

			setTimeout(function () { window.print(); }, 500);
        window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
		}
		</script>
</head>

<body onLoad="bPrint();">
				<table border='0'  width="270"  style='color:black;' class="tabless">


				<tr>

			<td  colspan='3'   style='font-size:8px;'><b>Not-Transferable</b></td>
				</tr>
				<tr>
				<td  colspan='3' align='center' style='font-size:18;'>കേരള നിയമസഭ</td>
				</tr>

				<tr>
					<td colspan='3'  align='center' style='font-size:15px;'>Kerala Legislative Assembly</td>
				</tr>


				<tr>
					<td colspan='4'   style='font-size:14px;'>സന്ദ൪ശക പാസ്/VISITOR'S PASS</td>
				</tr>

				<tr rowspan='2'>
				<td style='font-size:10px;' class='barcodecell'>
				{!! DNS1D::getBarcodeHTML(strval($visitorPass->id), 'C128', 3,33) !!}

				{{$visitorPass->id}}
			</td>

				</tr>




				<tr>
  					<td colspan='2'  style='font-size:16px;'>Tok No:{{$visitorPass->number}}<label class='printed'></label></td>
				</tr>
				<tr>
					<td colspan='3' style='font-size:16px;'>Date:{{ $issued_on}}, {{  $issued_at }}</td>
				</tr>

				<tr >

				<td colspan='3' >--------------------------------------------</td>
				</tr>

				<tr>
				<td colspan='3' style='font-size:12px;'>
					Visitor's Name: {{ $visitorPass->name }}
				</td>
				</tr>

				<tr>
				<td colspan='3' style='font-size:12px;'>
						Address: {{ $visitorPass->address }}
				</td>
				</tr>
				<tr>

				<td colspan='3' >--------------------------------------------</td>
				</tr>
				<tr>
				<td colspan='3' style='font-size:15px;'>
					 To Visit : {{ $visitorPass->visiting_office}}
				</td>
				</tr>

	@if($visitorPass->recommending_office)<tr>
				<td colspan='3' style='font-size:15px;'>
					 Recommended By: {{ $visitorPass->recommending_office}}
				</td>
				</tr>
	@endif

				<tr>
					<td colspan='3'align='center' style='font-size:10px;'>Issued By </td>
				</tr>

				</table>
     <p style="page-break-after: always;">&nbsp;</p>
</body>
</html>
