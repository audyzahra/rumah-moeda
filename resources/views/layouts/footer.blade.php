<footer class="footer">
    <div class="footer-container">

        <!-- Logo & Deskripsi -->
        <div class="footer-item">
            <img src="{{ asset('assets/logorumahmoeda.png') }}"
                 alt="Rumah Moeda"
                 class="footer-logo">

            <h3>Rumah Moeda</h3>

            <p>
                Bersama membangun generasi muda yang observatif, enerjik,
                dinamis, dan aktif melalui pendidikan, pemberdayaan,
                serta inovasi sosial.
            </p>
        </div>

        <!-- Kontak -->
        <div class="footer-item">
            <h3>Kontak Kami</h3>

            <div class="footer-info">
                <i class="fas fa-phone"></i>
                <span>+62 812-3456-7890</span>
            </div>

            <div class="footer-info">
                <i class="fas fa-envelope"></i>
                <span>info@rumahmoeda.id</span>
            </div>

            <div class="footer-info">
                <i class="fas fa-map-marker-alt"></i>
                <span>
                    Jl. Contoh No.123,<br>
                    Purwakarta, Jawa Barat
                </span>
            </div>
        </div>

        <!-- Maps -->
        <div class="footer-item">
            <h3>Lokasi Kami</h3>

            <iframe
                src="https://www.google.com/maps?q=Purwakarta&output=embed"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>

    <div class="footer-bottom">
        &copy; {{ date('Y') }} Rumah Moeda. All Rights Reserved.
    </div>
</footer>
