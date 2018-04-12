<?php
$con=mysqli_connect("localhost","adCrc","P0rcodioLamadonna2!","email");

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email;

$captcha;

if(isset($_POST['email'])){
    $email=$_POST['email'];
}if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
	echo ("<script>
		if(!alert('Please check the Captcha form.')){
			window.location.href = \"../\";
		 } 
	      </script>");    

exit;
}
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfKu1EUAAAAAITXx2IK2rczOm21AuXRrLqQwF5M&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
if($response.success==true)
{

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $con ->prepare("INSERT INTO anagrafica (email) VALUES ('$email')");
        $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        echo("<script>
			if(!alert('$email is not a valid email address,')){
				window.location.href = \"../\";
			}
	     </script>");
    }
    echo ("<script>
			if(!alert('Thanks for sending email.')){
				window.location.href = \"../\";
			}
           </script>");
}
mysqli_close($con);

?>
