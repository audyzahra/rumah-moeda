<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ config('app.name', 'Rumah Moeda') }}</title>
</head>

<body style="margin:0; padding:0; width:100%; background:#f3f5f7; font-family:Arial, Helvetica, sans-serif; color:#252525;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; background:#f3f5f7; margin:0; padding:40px 15px;">
    <tr>
        <td align="center">

            <table width="620" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:620px; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08);">

                <tr>
                    <td style="height:7px; background:#1f2937; font-size:0; line-height:0;">
                        &nbsp;
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:32px 30px 25px; background:#ffffff;">
                        <img
                            src="{{ asset('uploads/logo.png') }}"
                            alt="Rumah Moeda"
                            width="120"
                            style="display:block; width:120px; max-width:120px; height:auto; border:0;"
                        >

                        <p style="margin:15px 0 0; font-size:20px; line-height:28px; font-weight:700; color:#222222;">
                            Rumah Moeda
                        </p>

                        <p style="margin:4px 0 0; font-size:13px; line-height:20px; color:#777777;">
                            Multimedia • Perfilman • Pendidikan
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 45px;">
                        <div style="height:1px; background:#eeeeee; font-size:0; line-height:0;">
                            &nbsp;
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:40px 45px 35px; font-size:15px; line-height:25px; color:#4b5563;">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:25px 45px; background:#f8f9fa; text-align:center; border-top:1px solid #eeeeee;">
                        <p style="margin:0 0 7px; font-size:13px; line-height:20px; color:#777777;">
                            Email ini dikirim secara otomatis oleh
                        </p>

                        <p style="margin:0; font-size:14px; line-height:21px; font-weight:700; color:#222222;">
                            Rumah Moeda
                        </p>

                        <p style="margin:8px 0 0; font-size:12px; line-height:18px; color:#999999;">
                            © {{ date('Y') }} Rumah Moeda. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>

            <p style="margin:20px 0 0; text-align:center; font-size:11px; line-height:18px; color:#999999;">
                Pesan ini ditujukan untuk penerima email yang terdaftar pada Rumah Moeda.
            </p>

        </td>
    </tr>
</table>

</body>
</html>
