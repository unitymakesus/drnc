<footer class="content-info page-footer" role="contentinfo">
  <div class="background-teal background-point-left background-order-swap">
    <div class="line left-1 bottom vertical teal-light length-90"></div>
    <div class="line bottom-1 horizontal teal-light length-30"></div>
    <div class="row">
      <div class="col l5 m4 flex-order-m2 s12">
        <p><a href="/donate/" class="btn btn-lg btn-green">Support Our Work</a></p>
        <h3>Stay Informed</h3>
        <p>Sign up for our free email newsletter. We send out monthly emails with news and updates. We will not share your contact information and do not send spam.</p>
        <!-- START VerticalResponse Opt-In Form -->
        <form method="post" action="http://oi.vresp.com?fid=67bbc883d1" target="vr_optin_popup" onsubmit="window.open( 'http://www.verticalresponse.com', 'vr_optin_popup', 'scrollbars=yes,width=600,height=450' ); return true;" >
          <label for="email_address">Email Address:</label><br/>
          <input id="email_address" name="email_address" type="text" /><br/>
          <input type="submit" value="Subscribe" /><br/>
        </form>
        <!-- END VerticalResponse Opt-In Form -->
      </div>
      <div class="col l7 m8 flex-order-m1 s12">
        <div class="row">
          <div class="col l4 m5 s6 xs12">
            @if (has_nav_menu('primary_navigation'))
              <h3>Menu</h3>
              {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'footer-menu']) !!}
            @endif
          </div>
          <div class="col l8 m7 s6 xs12">
            @php(dynamic_sidebar('sidebar-footer'))
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      <div class="flex flex-center space-between">
        <span class="copyright">&copy; {{ current_time('Y') }} Disability Rights North Carolina. All rights reserved.</span>
        <a href="/privacy-policy/">Privacy Policy</a>
        <a href="/sitemap.xml">Site Map</a>
        @include('partials.unity')
      </div>
    </div>
  </div>
</footer>
