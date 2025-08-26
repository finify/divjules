<!doctype html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<style>
.btn:hover {
    background-color: #212135 !important
}
</style>
<table style="width: 100%; background-color: #EFF3FF">
    <tbody>
        <tr>
            <td style="padding: 80px 0;">
                <table style="width: 60%; max-width: 550px; min-width: 420px; margin: 0 auto">
                    <tbody>
                        <tr>
                            <td style="font-family:'Neue Montreal',sans-serif; font-size: 17px; font-weight: 400; line-height: 1.5">
                                <p style="text-align:center; margin: 24px 0">
                                    <a href="https://certarigroup.com" target="_blank" style="padding: 8px">
                                        <img aria-hidden="true" src="/homeassets/img/certarilogo.webp" height="100" alt="Climb Onsight">
                                    </a>
                                </p>
                                <div class="body-card" style="background-color: #fff; padding: 30px; border-radius: 16px">
                                    
                                    <div style="padding: 12px 0">
                                        <span style="color: #000; padding-bottom: 6px; font-weight: 600; font-size: 25px; display:inline-block">
                                            Contact form submited on website
                                        </span>
                                    </div>
                                    <div style="color: rgb(34, 34, 34);">
                                        <p>
                                            <strong>Hello, Admin</strong>
                                        </p>
                                        <p>
                                            We have received the following message from {{ $firstname }} {{ $lastname }}:
                                        </p>
                                        <p>
                                            "{{ $emailmessage }}"
                                        </p>
                                        <p>
                                            The contact form was submitted using the following information:
                                        </p>
                                        <p>
                                            Phone Number: {{ $phonenumber }}
                                        </p>
                                        <p>
                                            Email: {{ $email }}
                                        </p>
                                    </div>
                                </div>
                                <div style="padding: 20px 40px 0 40px;text-align: center">
                                    <div style="font-size: 12px; color: #7A7D84">
                                        <span>You received this email because you submited a contact form on certarigroup contact form page</span>
                                        <span> For more information, contact us at <a style="color: #212121;" href="mailTo:enquiry@certarigroup.com">enquiry@certarigroup.com</a></span>
                                        <span> or visit our website <a style="color: #212121;" href="https://certarigroup.com" target="_blank">certarigroup.com</a>.</span>
                                        <br>
                                        <p>
                                            <div>© 2025 Certarigroup</div>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
