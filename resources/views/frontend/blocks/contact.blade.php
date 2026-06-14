<div class="cmsb">
    <section class="cmsb-contact">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            <div class="grid">
                <div>
                    @if(!empty($m['address']))
                        <div class="info-item"><div class="ic"><i class="fas fa-location-dot"></i></div><div><h4>Address</h4><p>{{ $m['address'] }}</p></div></div>
                    @endif
                    @if(!empty($m['phone']))
                        <div class="info-item"><div class="ic"><i class="fas fa-phone"></i></div><div><h4>Phone</h4><p><a href="tel:{{ $m['phone'] }}">{{ $m['phone'] }}</a></p></div></div>
                    @endif
                    @if(!empty($m['email']))
                        <div class="info-item"><div class="ic"><i class="fas fa-envelope"></i></div><div><h4>Email</h4><p><a href="mailto:{{ $m['email'] }}">{{ $m['email'] }}</a></p></div></div>
                    @endif
                </div>
                @if(($m['show_form'] ?? '1') == '1')
                    <div>
                        <form>
                            <input type="text" placeholder="Your Name">
                            <input type="email" placeholder="Your Email">
                            <textarea rows="4" placeholder="Message"></textarea>
                            <button type="button" class="b-btn">Send Message <i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
