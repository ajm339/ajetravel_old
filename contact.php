<?php 
require 'header.php';
require 'nav_bar.php'; 

//Form Checking   
$nameCHECK = '/^[a-zA-Z\s]+$/';

if (isset($_POST['entryname']) && !empty($_POST['entryname']) && preg_match($nameCHECK, $_POST['entryname'])){
    if (isset($_POST['email']) && !empty($_POST['email']) && validEmail($_POST['email'])){
        if (isset($_POST['message']) && !empty($_POST['message'])){

            $name = $_POST['entryname'];
            $email1 = $_POST['email'];

            if(isset($_POST['phone'])){
                $phoneTEMP = $_POST['phone'];
                $phoneCHECK = '/^(\(?[0-9]{3}\)?)?[ .-]?[0-9]{3}[.-]?[0-9]{4}$/';
                if(preg_match($phoneCHECK, $phoneTEMP)){
                    $phone = $phoneTEMP;
                } else {
                    $phone = 'Invalid Phone Number';
                }
            } else {
                $phone = 'Not Provided';
            }
            
            $inputTEMP = $_POST['message'];
            $input = strip_tags($inputTEMP);
            
            $to = "hopkins5@epix.net";
            $subject = "AJ&E Travel Website Contact Page from" . $name;
            $message = "From: " . $name . ", Email: " . $email1 . ", Phone: " . $phone . " message: " . $input;
            mail($to,$subject,$message);
            
            //print("$name " .  " $email1," . " $phone, " . " $input ");
            $status = "<p>Thank you, your message has been sent.</p>";
        }
        else 
        {   
            $status = "<p>Please fill out your Name, Email, and Message before submitting. </p>";                                               
        }
    }
    else 
    {   
        $status = "<p>Please fill out your Name, Email, and Message before submitting. </p>";                   
    }               
}
else 
{   
    $status = "<p>Please fill out your Name, Email, and Message before submitting. </p>";   
}

//Validate Email
        //Credit to Douglas Lovell  http://www.linuxjournal.com/article/9585?page=0,3
        function validEmail($email)
        {
           $isValid = true;
           $atIndex = strrpos($email, "@");
           if (is_bool($atIndex) && !$atIndex)
           {
              $isValid = false;
           }
           else
           {
              $domain = substr($email, $atIndex+1);
              $local = substr($email, 0, $atIndex);
              $localLen = strlen($local);
              $domainLen = strlen($domain);
              if ($localLen < 1 || $localLen > 64)
              {
                 // local part length exceeded
                 $isValid = false;
              }
              else if ($domainLen < 1 || $domainLen > 255)
              {
                 // domain part length exceeded
                 $isValid = false;
              }
              else if ($local[0] == '.' || $local[$localLen-1] == '.')
              {
                 // local part starts or ends with '.'
                 $isValid = false;
              }
              else if (preg_match('/\\.\\./', $local))
              {
                 // local part has two consecutive dots
                 $isValid = false;
              }
              else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
              {
                 // character not valid in domain part
                 $isValid = false;
              }
              else if (preg_match('/\\.\\./', $domain))
              {
                 // domain part has two consecutive dots
                 $isValid = false;
              }
              else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                         str_replace("\\\\","",$local)))
              {
                 // character not valid in local part unless 
                 // local part is quoted
                 if (!preg_match('/^"(\\\\"|[^"])+"$/',
                     str_replace("\\\\","",$local)))
                 {
                    $isValid = false;
                 }
              }
              if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
              {
                 // domain not found in DNS
                 $isValid = false;
              }
           }
           return $isValid;
        }

?>

<div class="row">
  <div class="large-12 columns">
    <h2>Contact<h2>
        <h6>Feel free to Call, Fax or Email me using the information below.  You can also leave a message through the contact form on the page.</h6>
  </div>
</div>

<div class="row">
    
         <?php
            if(isset($_POST['submit'])){
                print("<div class='row'>");
                print("<div class='large-6 columns large-offset-3 columns'>");
                print($status);
                print("</div>");
                print("</div>");
            }
        ?>
    <div class="large-4 columns padding-top">
        <p>Phone: 877-717-6687<p>
        <p>Fax: 717-786-8045<p>
        <p>Email: Hopkins5@epix.net<p>
        <p>Address: 978 Valley Road Quarryville, PA 17566<p>
    </div>
    <div class="large-7 large-offset-1 columns padding-top" id="contact">
         <form action= "contact.php" method="post" id = "contactFORM" data-abide>
            <div class="row">
                <div class="large-12 columns">
                    <label>Name: <small>required</small>
                        <input id='inputNAME' type="text" name="entryname" required pattern="[a-zA-Z]+" />
                    </label>
                     <small class="error">Name is required and must be only letters.</small>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label>Email: <small>required</small>
                        <input id='inputEMAIL' type="email" name="email" required />
                    </label>
                    <small class="error">An email address is required.</small>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label>Phone Number:
                        <input id='inputPHONE' type="tel" name="phone" pattern="number"/>
                    </label>
                     <small class="error">Must be a valide phone number.</small>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label>Your Message:<small>required</small>
                        <textarea rows = "10" cols = "50" id="message" name="message" required></textarea>
                    </label>
                    <small class="error">You must leave a valid message.</small>
                </div>
            </div>
            <div class="row padding-top">
                <div class="large-12 columns">
                    <input class="button" type="submit" value="Submit" name="submit"/>
                    <input class="button" type="reset" value="Clear Form"/>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require 'includes.php'; ?>