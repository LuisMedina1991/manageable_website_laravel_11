<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'UrWebsite') }}</title>
</head>
<body style="margin: 0;">
    <table class="wrapper" width="100%" style="background-color: #e1e5e8; padding: 30px 0;">
        <tr>
            <td>
                <table class="main" width="100%" style="border-spacing: 0; max-width: 600px; color: #44413d;" align="center">
                        <tr>
                            <td style="padding: 0; background-color: #fff; border-radius: 20px; font-family: 'Monserrat', Arial, Helvetica, sans-serif;">
                                <table width="100%" style="border-spacing: 0; padding: 0 30px;">
                                    <tr>
                                        <td style="text-align: center; padding: 0;">
                                            <h1>{{ __('Sender Information') }}</h1>
                                            <hr style="height: 2px; background-color: #303840;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 0;">
                                            <p><strong>{{ __('Name') }}: </strong>{{ $dataForEmail['remitent_name'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 0;">
                                            <p><strong>{{ __('Email') }}: </strong>{{ $dataForEmail['remitent_email'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 0;">
                                            <p><strong>{{ __('Phone Number') }}: </strong>{{ $dataForEmail['remitent_phone'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding: 0;">
                                            <p><strong>{{ __('Message') }}: </strong>{{ $dataForEmail['remitent_message'] }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>