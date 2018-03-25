<footer class="content-info page-footer" role="contentinfo">
  <div class="background-teal background-point-left">
    <div class="line left-1 bottom vertical teal-light length-90"></div>
    <div class="line bottom-1 horizontal teal-light length-30"></div>
    <div class="row">
      <div class="col m7 s12">
        <div class="row">
          <div class="col l4 m5 s12">
            @if (has_nav_menu('primary_navigation'))
              <h3>Menu</h3>
              {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'footer-menu']) !!}
            @endif
          </div>
          <div class="col l8 m7 s12">
            @php(dynamic_sidebar('sidebar-footer'))
          </div>
        </div>
      </div>
      <div class="col m5 s12">
        <p><a href="/donate/" class="btn btn-lg btn-green">Support Our Work</a></p>
        <h3>Stay Informed</h3>
        <p>Sign up for our free email newsletter. We send out monthly emails with news and updates. We will not share your contact information and do not send spam.</p>
        [FORM]
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
