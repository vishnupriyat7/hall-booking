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

		//	window.print();
		//	window.opener.location.href = window.opener.location.href;
			//opener.location.reload();
			//window.close();
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

			setTimeout(function () { window.print(); }, 500);
        //window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
            window.addEventListener("afterprint", () => self.close);

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
					<td colspan='4'   style='font-size:14px;'>ഗ്യാലറി പാസ്/GALLERY PASS</td>
				</tr>

				<tr rowspan='2'>
				<td colspan='3' align='right' style='font-size:10px;' class='barcodecell'>
				{!! DNS1D::getBarcodeHTML(strval($galleryPass->id), 'C128') !!}
				{{$galleryPass->id}}
			</td>

				</tr>

				<tr>
  					<td colspan='2'  style='font-size:16px;'>Tok No:{{$galleryPass->number}}<label class='printed'></label></td>
				</tr>
                <tr>
  					<td style='font-size:16px;'>Accompanying :{{$galleryPass->num_persons}}<label class='printed'></label></td>
				</tr>

				<tr>
					<td colspan='3' style='font-size:16px;'>Date:{{ $issued_on}}, {{  $issued_at }}</td>
				</tr>

				<tr >

				<td colspan='3' >--------------------------------------------</td>
				</tr>

				<tr>
				<td colspan='3' style='font-size:12px;'>
					Visitor's Name: {{ $galleryPass->name }}
				</td>
				</tr>

				<tr>
				<td colspan='3' style='font-size:12px;'>
						Address: {{ $galleryPass->address }}
				</td>
				</tr>
				<tr>

				<td colspan='3' >--------------------------------------------</td>
				</tr>

				<tr>
					<td colspan='3'align='center' style='font-size:10px;'>Issued By </td>
				</tr>

				</table>


</body>
</html>
