<footer class="footer">
    <div class="footer-container">

        <!-- Logo & Deskripsi -->
        <div class="footer-item">
            <img src="{{ asset($setting->website_logo) }}" alt="{{ $setting->website_name }}"  class="footer-logo">

            <h3>{{ $setting->website_name }}</h3>

            <p>
                {{ $setting->website_description }}
            </p>
        </div>

        <!-- Kontak -->
        <div class="footer-item">
            <h3>Kontak Kami</h3>

            <div class="footer-info">
                <i class="fas fa-phone"></i>
                {{ $setting->phone_number }}
            </div>

            <div class="footer-info">
                <i class="fas fa-envelope"></i>
                {{ $setting->email }}
            </div>

            <div class="footer-info">
                <i class="fas fa-map-marker-alt"></i>
                {{ $setting->address }}
            </div>
        </div>

        <!-- Maps -->
        <div class="footer-item">
            <h3>Lokasi Kami</h3>

            <iframe src="https://www.google.com/maps?q=Purwakarta&output=embed" allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} {{ $setting->website_name }}. All Rights Reserved.
    </div>
</footer>
