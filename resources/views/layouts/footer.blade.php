<footer class="footer">
    <div class="footer-container">

        <!-- Logo & Deskripsi -->
        <div class="footer-item">
            @if (!empty($setting->website_logo))
                <img src="{{ Storage::url($setting->website_logo) }}" alt="{{ $setting->website_name }}"
                    class="footer-logo">
            @else
                <img src="{{ asset('assets/logo-default.png') }}" alt="Logo" class="footer-logo">
            @endif

            <h3>{{ $setting->website_name }}</h3>

            <div class="website-description">
                {!! $setting->website_description !!}
            </div>
        </div>

        <!-- Kontak -->
        <div class="footer-item">
            <h3>Kontak Kami</h3>

            <div class="footer-contact-grid">

                <!-- Kolom Kiri -->
                <div>

                    <div class="footer-info">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/6285720283515" target="_blank">
                            0857-2028-3515
                        </a>
                    </div>

                    <div class="footer-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:rumahmoedaofficial@gmail.com">
                            rumahmoedaofficial@gmail.com
                        </a>
                    </div>

                    <div class="footer-info">
                        <i class="fab fa-facebook"></i>
                        <a href="https://www.facebook.com/share/1EMzZFvHEb/" target="_blank">
                            Rumah Moeda
                        </a>
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div>

                    <div class="footer-info">
                        <i class="fab fa-instagram"></i>
                        <a href="https://www.instagram.com/rumahmoedaofficial?igsh=MXA0ZjdzZWNvNWFrOQ=="
                            target="_blank">
                            @rumahmoedaofficial
                        </a>
                    </div>

                    <div class="footer-info">
                        <i class="fab fa-tiktok"></i>
                        <a href="https://www.tiktok.com/@rumah.moeda?_r=1&_t=ZS-97gl1ocbXO8" target="_blank">
                            Rumah Moeda
                        </a>
                    </div>

                    <div class="footer-info">
                        <i class="fab fa-youtube"></i>
                        <a href="https://youtube.com/@rumahmoedaofficial?si=3mPGBmuFxR2YEp7O" target="_blank">
                            Rumah Moeda Official
                        </a>
                    </div>

                </div>

            </div>
        </div>

        <div class="footer-item">

            <h3>Lokasi Kami</h3>

            <p class="footer-location">
                Purwakarta, Jawa Barat, Indonesia
            </p>

            <iframe src="https://www.google.com/maps?q=Purwakarta,Jawa+Barat,Indonesia&output=embed" allowfullscreen
                loading="lazy">
            </iframe>
        </div>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} {{ $setting->website_name }}. All Rights Reserved.
    </div>

</footer>
