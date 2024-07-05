<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['Name']);
    $phone = htmlspecialchars($_POST['Phone']);
    $email = htmlspecialchars($_POST['Email']);
    $subject = htmlspecialchars($_POST['Subject']);
    $message = htmlspecialchars($_POST['Message']);

    $url = 'https://script.google.com/macros/s/AKfycbxEVNRl2-coQL_R33is8q4kRprcWNrlzgyzWekxngi-RkqAFUsxPrHZsY6mEMSmyuonag/exec';

    $data = [
        'Name' => $name,
        'Phone' => $phone,
        'Email' => $email,
        'Subject' => $subject,
        'Message' => $message,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        $msg = 'There was an error submitting the form.';
    } else {
        $msg = 'Message sent successfully';
    }
} else {
    $msg = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        .form-item { margin-bottom: 15px; }
        .form-group { margin-bottom: 10px; }
        .btn { padding: 10px 20px; background-color: #007bff; color: #fff; border: none; cursor: pointer; }
        #msg { color: red; }
    </style>
</head>
<body>
    <!--===== Contact Form =====-->
    <div class="row">
        <div class="contact-form padd-15">
            <form id="contact-form" method="post">
                <div class="row">
                    <div class="form-item col-6 padd-15">
                        <div class="form-group">
                            <input type="text" name="Name" class="form-control" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="form-item col-7 padd-15">
                        <div class="form-group">
                            <select id="countryCodeSelect" class="form-control" name="CountryCode">
                                <option value="91">+91 (India)</option>
                                <!-- Add other countries as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="form-item col-8 padd-15">
                        <div class="form-group">
                            <input type="text" name="Phone" class="form-control" placeholder="Phone" pattern="[0-9]+" required>
                        </div>
                    </div>
                    <div class="form-item col-12 padd-15">
                        <div class="form-group">
                            <input type="email" name="Email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-item col-12 padd-15">
                        <div class="form-group">
                            <input type="text" name="Subject" class="form-control" placeholder="Subject" required>
                        </div>
                    </div>
                    <div class="form-item col-12 padd-15">
                        <div class="form-group">
                            <textarea name="Message" class="form-control" placeholder="Message" required></textarea>
                        </div>
                    </div>
                    <div class="form-item col-12 padd-15">
                        <button type="submit" class="btn">Send Message</button>
                    </div>
                </div>
            </form>
            <span id="msg"><?= $msg ?></span>
        </div>
    </div>

    <script>
        const countryCodeSelect = document.getElementById("countryCodeSelect");
        const phoneInput = document.querySelector('input[name="Phone"]');
        const countryCodeLimits = {
            "91": 10,
            "1": 10,
            "44": 10,
            "61": 10,
            "81": 10,
            "86": 11,
            "49": 10,
            "33": 10,
            "55": 11,
        };

        countryCodeSelect.addEventListener("change", () => {
            const selectedCountryCode = countryCodeSelect.value;
            if (countryCodeLimits[selectedCountryCode]) {
                phoneInput.maxLength = countryCodeLimits[selectedCountryCode];
            } else {
                phoneInput.maxLength = 15;
            }
            showErrorIfExceedsLimit();
        });

        phoneInput.addEventListener('input', () => {
            const selectedCountryCode = countryCodeSelect.value;
            const enteredPhone = phoneInput.value.replace(/\D/g, '');
            const limit = countryCodeLimits[selectedCountryCode];

            if (limit) {
                if (enteredPhone.length > limit) {
                    phoneInput.value = enteredPhone.substring(0, limit);
                }
            }
        });
    </script>
</body>
</html>
