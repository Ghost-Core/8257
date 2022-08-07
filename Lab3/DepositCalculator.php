<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $prinAmount = $_POST['prinAmount'];
       $inteRate = $_POST['inteRate'];
       $depoYears = $_POST['depoYears'];
       $name = $_POST['name'];
       $postal = $_POST['postal'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $contact_method = $_POST['contact_method'];
       $morning = $_POST['morning'];
       $afternoon = $_POST['afternoon'];
       $evening = $_POST['evening'];

   }

$errors=[];
    function validatePrincipal($amount){
            if ($amount <= 0) {
            return "Principal Amount must be greater than zero.";}
        }
        

    function validateRate($amount){
        if (is_numeric($amount)) {
                if ($amount <= 0) {
                    return "Interest Rate must be greater than zero.";
                }
        } else {
                return "Interest Rate must be numeric.";
            }
        }
    

    function validateYears($years) {
        if (is_numeric($years)) {
                if ($years <= 0 || $years > 20) {
                    return "Years to Deposit must be between 1 and 20.";
                }
            } else {
                return "Years to Deposit must be numeric.";
            }
        }
    

    function validateName($name) {

    }

    function validatePostalCode($postal) {
        return (preg_match("/\b[a-zA-Z][0-9][a-zA-Z]\s*[0-9][a-zA-Z][0-9]\b/", $postal)) ? "" : "Please insert a valid postal code.";
    }

    function validatePhone($phone) {
        return (preg_match("/\b[2-9][0-9]{2}-[2-9][0-9]{2}-[0-9]{4}\b/", $phone)) ? "" : "Please insert a valid phone number.";
    }

    function validateEmail($email) {
        return (preg_match("/\b[a-zA-Z0-9._%+-]+@(([a-zA-Z0-9-]+)\.)+[a-zA-Z]{2,4}\b/", $email)) ? "" : "Please insert a valid email.";
}



if (isset($_POST) && $_POST) {
    if (isset($_POST['prinAmount']) && $_POST['prinAmount']) {
        $errors['prinAmount'] = validatePrincipal($_POST['prinAmount']);
    } else {
        $errors['prinAmount'] = "Principal Amount must not be blank.";
    }
    if (isset($_POST['inteRate']) && $_POST['inteRate']) {
        $errors['inteRate'] = validateRate($_POST['inteRate']);
    } else {
        $errors['inteRate'] = "Interest Rate must not be blank.";
    }
    if (isset($_POST['depoYears']) && $_POST['depoYears']) {
        $errors['depoYears'] = validateYears($_POST['depoYears']);
    } else {
        $errors['depoYears'] = "Years to Deposit must not be blank.";
    }
    if (!isset($_POST['name']) || !$_POST['name']) {
        $errors['name'] = "Name is required.";
    }
    if (isset($_POST['postal']) && $_POST['postal']) {
        $errors['postal'] = validatePostalCode($_POST['postal']);
    } else {
        $errors['postal'] = "Postal code must not be blank.";
    }
    if (isset($_POST['phone']) && $_POST['phone']) {
        $errors['phone'] = validatePhone($_POST['phone']);
    } else {
        $errors['phone'] = "Phone Number must not be blank.";
    }
    if (isset($_POST['email']) && $_POST['email']) {
        $errors['email'] = validateEmail($_POST['email']);
    } else {
        $errors['email'] = "Email must not be blank.";
    }
        if (isset($_POST['contact_method']) && $_POST['contact_method']) {
            if ($_POST['contact_method'] == "email") {
                $strcontact = "Our customer service will contact you at $_POST[email].";
            } else {
                $timeDay = '';
                if (isset($_POST['morning'])) {
                    $timeDay = 'morning';
                }
                if (isset($_POST['afternoon'])) {
                    if ($timeDay) $timeDay = ' or ';
                    $timeDay = 'afternoon';
                }
                if (isset($_POST['evening'])) {
                    if ($timeDay) $timeDay = ' or ';
                    $timeDay = 'evening';
                }
                if ($timeDay) {
                    $strcontact = "Our customer service will call you tomorrow $timeDay at " . $_POST['phone'] .".";
                } else {
                    $errors['timeDay'] = "When preffered contact method is phone, you have to select contact time";
                }
            }
        } else {
        $errors['contact_method'] = "You must select a contact method.";
    }
}

$valid=false;

foreach ($errors as $e) {
    if ($e) {
        $valid = false;
    }else{
        $valid=true;
}
}

?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Deposit Calculator</title>
    <style>
        label {font-weight: bold;}
        input+label {font-weight: normal;}
    </style>
<?php
  
if ($valid==false) {
    ?>
    
    <div class="container">
        <form action="DepositCalculator.php" method="post">
            <br/>
            <div class="row">
                <div class="col-md-6 text-center">
                    <h1>Deposit Calculator</h1>
                </div>
            </div>
            <br/>
            <br/>
            <div class="row">
                <div class="col-md-2">
                    <label for="prinAmount">Principal Amount ($)</label>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="number" step="0.01" value="<?php echo "$prinAmount"; ?>" name="prinAmount" id="prinAmount">
                </div>
        <div class="col-xs-4 text-danger">
            <?=isset($errors['prinAmount']) ? $errors['prinAmount'] : "" ?>
        </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="inteRate">Interest Rate (%)</label>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="number" step="0.01" value="<?php echo "$inteRate"; ?>" name="inteRate" id="inteRate">
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['inteRate']) ? $errors['inteRate'] : "" ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="depoYears">Years To Deposit:</label>
                </div>
                <div class="col-md-3 offset-1">
                    <select class="custom-select" name="depoYears" id="depoYears">
                        <option disabled selected value="0" class="text-center">--Select One of The Options--</option>
                        <option value="1" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '1') ? 'selected':''; ?>>1</option>
                        <option value="2" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '2') ? 'selected':''; ?>>2</option>
                        <option value="3" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '3') ? 'selected':''; ?>>3</option>
                        <option value="4" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '4') ? 'selected':''; ?>>4</option>
                        <option value="5" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '5') ? 'selected':''; ?>>5</option>
                        <option value="6" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '6') ? 'selected':''; ?>>6</option>
                        <option value="7" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '7') ? 'selected':''; ?>>7</option>
                        <option value="8" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '8') ? 'selected':''; ?>>8</option>
                        <option value="9" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '9') ? 'selected':''; ?>>9</option>
                        <option value="10" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '10') ? 'selected':''; ?>>10</option>
                        <option value="11" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '11') ? 'selected':''; ?>>11</option>
                        <option value="12" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '12') ? 'selected':''; ?>>12</option>
                        <option value="13" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '13') ? 'selected':''; ?>>13</option>
                        <option value="14" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '14') ? 'selected':''; ?>>14</option>
                        <option value="15" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '15') ? 'selected':''; ?>>15</option>
                        <option value="16" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '16') ? 'selected':''; ?>>16</option>
                        <option value="17" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '17') ? 'selected':''; ?>>17</option>
                        <option value="18" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '18') ? 'selected':''; ?>>18</option>
                        <option value="19" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '19') ? 'selected':''; ?>>19</option>
                        <option value="20" <?php echo (isset($_POST['depoYears']) && $_POST['depoYears'] == '20') ? 'selected':''; ?>>20</option>
                    </select>
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['depoYears']) ? $errors['depoYears'] : "" ?>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-2">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="text" value="<?php echo "$name"; ?>" name="name" id="name">
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['name']) ? $errors['name'] : "" ?>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="postal">Postal Code</label>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="text" value="<?php echo "$postal"; ?>" name="postal" id="postal">
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['postal']) ? $errors['postal'] : "" ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="phone">Phone Number:</label>
                    <p>(nnn-nnn-nnnn)</p>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="text" value="<?php echo "$phone"; ?>" name="phone" id="phone">
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['phone']) ? $errors['phone'] : "" ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="email">Email Address:</label>
                </div>
                <div class="col-md-3 offset-1">
                    <input class="form-control" type="text" value="<?php echo "$email"; ?>" name="email" id="email">
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['email']) ? $errors['email'] : "" ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>
                        Preferred Contact Method:
                    </label>
                </div>
                <div class="col-md-2">
                    <input type="radio" name="contact_method" value="phone" id="phone-method" <?php if(isset($contact_method) && $contact_method =='phone' ){echo "checked";}?>>
                    <label for="phone-method">Phone</label>
                    &nbsp;
                    <input type="radio" name="contact_method" value="email" id="email-method" <?php if(isset($contact_method) && $contact_method =='email' ){echo "checked";}?>>
                    <label for="email-method">Email</label>
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['contact_method']) ? $errors['contact_method'] : "" ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label>
                        If phone is selected, when can we contact you?
                        <br>
                        (check all applicable)
                    </label>
                    <br>
                    <input type="checkbox" name="morning" id="morning" <?php if(isset($morning)) echo "checked='checked'"; ?>>
                    <label for="morning">Morning</label>
                    &nbsp;
                    <input type="checkbox" name="afternoon" id="afternoon" <?php if(isset($afternoon)) echo "checked='checked'"; ?>>
                    <label for="afternoon">Afternoon</label>
                    &nbsp;
                    <input type="checkbox" name="evening" id="evening" <?php if(isset($evening)) echo "checked='checked'"; ?>>
                    <label for="evening">Evening</label>
                </div>
                <div class="col-xs-4 text-danger">
                    <?=isset($errors['timeDay']) ? $errors['timeDay'] : "" ?>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-5 text-center">
                <button type="submit" class="btn btn-primary">Calculate</button>
                <a href="" class="btn btn-primary clear-btn">Clear</a>
                </div>
            </div>
        </form>
    </div>
    <?php
        }
else {
    ?>
    <div class="container">
        <br/>
        <h1>Thank you <?= $name ?> for using our deposit calculator!</h1>
        <br/>
            <h5>
                <?= $strcontact ?>
            </h5>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Year</th>
                        <th>Principal at Year Start</th>
                        <th>Interest for the Year</th>
                    </tr>
                    <?php
                        $interest = $_POST['inteRate'];
                        $amount = $_POST['prinAmount'];

                        for ($i = 1; $i <= $_POST['depoYears']; $i++) {
                            ?>
                        <tr>
                            <td>
                                <?= $i ?>
                            </td>
                            <td>
                                $ <?= number_format($amount, 2) ?>
                            </td>
                            <td>
                                $ <?= number_format($amount * $interest / 100, 2) ?>
                            </td>
                        </tr>
                    <?php

                            $amount += $amount * $interest / 100;
                        }
                        ?>
                </table>
            </div>
    </div>
        <?php
        }
        ?>
   

    