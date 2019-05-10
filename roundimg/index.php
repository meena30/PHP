<html lang="en">
<head>
  <title>PHP - jquery ajax crop image before upload using croppie plugins</title>
  <!--<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
  <script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
  <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
  <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">-->
  <script src="js/jquery.js"></script>
  <script src="js/croppie.js"></script>
  <link rel="stylesheet" href="css/bootstrap-3.min.css">
  <link rel="stylesheet" href="css/croppie.css">
</head>
<body>


<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">Image Upload</div>
	  <div class="panel-body">

<form name="imgup" method="post" action="" enctype="multipart/form-data" id="cform">
	  	<div class="row">
	  		<div class="col-md-4 text-center">
				<div id="upload-demo" style="width:350px;display:none"></div>
				
	  		</div>
	  		<div class="col-md-4" style="padding-top:30px;">
				<strong>Select Image:</strong>
				<br/>
				<input type="file" id="upload" name="upload">
				<!-- <input type="file"  id="item_image" name="item_image" onchange="readImage(this);"></input> --> 
				<input type="hidden" name="crpimg" value="" />
				<br/>
				<button type="submit" name="submit" class="btn btn-success upload-result">Upload Image</button>
				
	  		</div>
	  		<div class="col-md-4" style="">
				<div id="upload-demo-i" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:30px"></div>
	  		</div>
	  	</div>

  </form>
  <!-- <button class="btn btn-success upload-result">Upload Image</button> -->


	  </div>
	</div>
</div>
<?php 
echo"<pre>";
echo $_FILES['upload']['name'];

if(isset($_POST['submit'])){


	     $myFile = $_FILES["upload"];
	    
	     $parts = pathinfo($myFile["name"]);
	    
		echo $name = uniqid().".".$parts["extension"];


	$data = $_POST['crpimg'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	//$imageName = time().'.png';
	
	file_put_contents('upload/'.$name, $data);


}

//echo '<img src="'.$data.'" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:30px">';

?>

<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});


$('#upload').on('change', function () { 
	$("#upload-demo").css("display", "block");
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    	
    }
    reader.readAsDataURL(this.files[0]);
});

/*// create item show image   
function readImage(input1) {
    
    $("#upload-demo").css("display", "block");
    if (input1.files && input1.files[0]) {
            var reader1 = new FileReader();

            reader1.onload = function (e) {
                $('#upload-demo')
                    .attr('src', e.target.result)
                    
                    .height(230);
            };

            reader1.readAsDataURL(input1.files[0]);
        }
    }*/

$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		jQuery("[name=crpimg]").val(resp);
		console.log(resp);
		html = '<img src="' + resp + '" />';
		$("#upload-demo-i").html(html);
		
		//$( "#cform" ).submit();
		/*$.ajax({
			url: "/roundimg/ajaxpro.php",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				console.log(data);
				html = '<img src="' + resp + '" />';
				$("#upload-demo-i").html(html);
			}
		});*/
	});
});


</script>


</body>
</html>