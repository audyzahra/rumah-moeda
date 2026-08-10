@component('mail::message')
<div style="text-align: center;">

# Verifikasi Alamat Email

Halo,

Terima kasih telah mendaftarkan akun di **Rumah Moeda**.

Untuk mengaktifkan akun kamu, silakan tekan tombol di bawah untuk memverifikasi alamat email.

@component('mail::button', ['url' => $actionUrl])
Verifikasi Email
@endcomponent

Jika tombol di atas tidak dapat digunakan, kamu dapat menyalin dan membuka alamat berikut di browser:

{{ $displayableActionUrl }}

Jika kamu tidak merasa membuat akun di Rumah Moeda, kamu dapat mengabaikan email ini.

Terima kasih,

**Rumah Moeda**

</div>
@endcomponent
