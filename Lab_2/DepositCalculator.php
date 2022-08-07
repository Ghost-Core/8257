<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Deposit Calculator</title>
    <style>
        label {font-weight: bold;}
        input+label {font-weight: normal;}
    </style>
</head>
<body>
    <div class="container">
        <br/>
        <h1>Thank you <?= $_POST['name'] ?> for using our deposit calculator!</h1>
        <br/>
        <?php
        $errors = [];

        if (isset($_POST['prinAmount']) && $_POST['prinAmount']) {
            if ($_POST['prinAmount'] <= 0) {
                $errors[] = "Principal Amount must be greater than zero.";
            }
        } else {
            $errors[] = "Principal Amount must not be blank.";
        }
        if (isset($_POST['inteRate']) && $_POST['inteRate']) {
            if (is_numeric($_POST['inteRate'])) {
                if ($_POST['inteRate'] <= 0) {
                    $errors[] = "Interest Rate must be greater than zero.";
                }
            } else {
                $errors[] = "Interest Rate must be numeric.";
            }
        } else {
            $errors[] = "Interest Rate must not be blank.";
        }
        if (isset($_POST['depoYears']) && $_POST['depoYears']) {
            if ($_POST['depoYears'] <= 0 || $_POST['depoYears'] > 20) {
                    $errors[] = "Years to Deposit must be between 1 and 20.";
                }
        } else {
            $errors[] = "Select one of the options for Years to Deposit";
        }
        
        if (!isset($_POST['name']) || !$_POST['name']) {
            $errors[] = "Name must not be blank.";
        }
        if (!isset($_POST['postal-code']) || !$_POST['postal-code']) {
            $errors[] = "Postal Code must not be blank.";
        }
        if (!isset($_POST['phone']) || !$_POST['phone']) {
            $errors[] = "Phone Number must not be blank.";
        }
        if (!isset($_POST['email']) || !$_POST['email']) {
            $errors[] = "Email must not be blank.";
        }
        if (isset($_POST['contact-method']) && $_POST['contact-method']) {
            if ($_POST['contact-method'] == "email") {
                $contact = "Our customer service will contact you at $_POST[email].";
            } else {
                $timeDay = '';
                if (isset($_POST['morning'])) {
                    $timeDay .= 'morning';
                }
                if (isset($_POST['afternoon'])) {
                    if ($timeDay) $timeDay .= ' or ';
                    $timeDay .= 'afternoon';
                }
                if (isset($_POST['evening'])) {
                    if ($timeDay) $timeDay .= ' or ';
                    $timeDay .= 'evening';
                }
                if ($timeDay) {
                    $contact = "Our customer service will call you tomorrow $timeDay at " . $_POST['phone'] . ".";
                } else {
                    $errors[] = "You must select at least one time of the day to contact.";
                }
            }
        } else {
            $errors[] = "You must select a contact method.";
        }

        if ($errors) {
            ?>
            <h5>
                However we can not process your request because of the following input errors:
            </h5>
            <ul>
                <br/>
                <?php
                    foreach ($errors as $msg) {
                        ?>
                    <li>
                        <?= $msg ?>
                    </li>
                <?php
                    }
                    ?>
            </ul>
        <?php
        } else {
            ?>
            <h5>
                <?= $contact ?>
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

        <?php
        }
        ?>
    </div>

</body>

</html>