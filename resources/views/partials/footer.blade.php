<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="logo logo--footer" href="{{ route('home') }}">
                    <img src="{{ asset('images/artsdiva-logo.png') }}" alt="ArtsDiva" width="140" height="26">
                </a>
                <span class="newsletter-label">Join our newsletter</span>
                <form class="newsletter" action="#" method="post" onsubmit="event.preventDefault(); this.querySelector('input').value=''; alert('Thank you — newsletter signup will connect when live.');">
                    <input type="email" name="email" placeholder="Your email..." aria-label="Email for newsletter" required>
                    <button type="submit" aria-label="Subscribe">→</button>
                </form>
            </div>

            <div class="footer-col">
                <h4>Explore</h4>
                <a href="{{ route('catalogue.index') }}">Catalogue</a>
                <a href="{{ route('artists') }}">Artists</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('services') }}">Services</a>
            </div>

            <div class="footer-col">
                <h4>Collect</h4>
                <a href="{{ route('inquiry.create') }}">Annual Leasing</a>
                <a href="{{ route('services') }}">Acquisition</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <p><a href="mailto:hello@artsdiva.art">hello@artsdiva.art</a></p>
                <p>Sales: <a href="tel:+919987821640">+91 99878 21640</a></p>
                <p>Acquisitions: <a href="tel:+917700916880">+91 77009 16880</a></p>
                <p>Admin office: <a href="tel:+912262584594">+91 22-6258 4594</a></p>
                <a href="{{ route('contact') }}">Get in touch</a>
            </div>
        </div>

        <div class="footer-bottom">
            © {{ date('Y') }} ArtsDiva. All rights reserved. Fine art acquisition &amp; annual leasing.
        </div>
    </div>
</footer>
