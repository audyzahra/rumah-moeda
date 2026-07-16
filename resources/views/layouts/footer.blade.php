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

            <p>
                {{ $setting->website_description }}
            </p>
        </div>

        <!-- Kontak -->
<div class="footer-item">
    <h3>Kontak Kami</h3>

    <div class="footer-info">
        <i class="fas fa-phone"></i>
        <a href="tel:+6281234567890">
            {{ $setting->phone_number }}
        </a>
    </div>

    <div class="footer-info">
        <i class="fas fa-envelope"></i>
        <a href="mailto:{{ $setting->email }}">
            {{ $setting->email }}
        </a>
    </div>

    <div class="footer-info">
        <i class="fas fa-map-marker-alt"></i>
        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($setting->address) }}"
           target="_blank">
            {{ $setting->address }}
        </a>
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
