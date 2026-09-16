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
                <div class="socials">
                    <a href="#" aria-label="Facebook">Fb</a>
                    <a href="#" aria-label="Instagram">Ig</a>
                    <a href="#" aria-label="LinkedIn">In</a>
                    <a href="#" aria-label="Pinterest">Pi</a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Company</h4>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('artists') }}">Artists</a>
                <a href="{{ route('events') }}">Events</a>
                <a href="{{ route('contact') }}">Careers</a>
            </div>

            <div class="footer-col">
                <h4>Information</h4>
                <a href="{{ route('services') }}">Acquisition</a>
                <a href="{{ route('inquiry.create') }}">Annual Leasing</a>
                <a href="{{ route('catalogue.index') }}">Catalogue</a>
                <a href="{{ route('contact') }}">Privacy</a>
            </div>

            <div class="footer-col">
                <h4>Resources</h4>
                <a href="{{ route('publications') }}">Publications</a>
                <a href="{{ route('news') }}">News</a>
                <a href="{{ route('contact') }}">FAQ</a>
                <a href="{{ route('inquiry.create') }}">Request Lease</a>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <p><a href="mailto:hello@artsdiva.art">hello@artsdiva.art</a></p>
                <a href="{{ route('contact') }}">Get in touch</a>
            </div>
        </div>

        <div class="footer-bottom">
            © {{ date('Y') }} ArtsDiva. All rights reserved. Fine art acquisition &amp; annual leasing.
        </div>
    </div>
</footer>
