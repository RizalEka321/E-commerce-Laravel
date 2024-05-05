<footer class="footer">
    <div class="container footer-top">
        <div class="">
            <a href="{{ route('home') }}">
            </a>
        </div>
        <div class="row justify-content-between">
            <div class="col-lg-4 col-md-6 footer-logo">
                <img src="{{ asset('assets/pembeli/img/logo_footer.png') }}" alt="logo-lokal-industri">
                <div class="social-links">
                    <a href="mailto:youremail@example.com"><i class="far fa-envelope"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 footer-links">
                <h4>Key</h4>
                <ul>
                    <li><a href="#">Konveksi</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Penjualan</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 footer-links">
                <h4>Menu Cepat</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Keranjang</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 footer-lokasi">
                <h4>Lokasi</h4>
                <span>{{ $profile->alamat }}</span>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="text-center">
            <p>&copy; <?php echo date('Y'); ?> Lokal Industri All Right Reserved</p>
        </div>
    </div>
</footer>
