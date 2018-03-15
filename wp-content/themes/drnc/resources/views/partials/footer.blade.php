<footer class="content-info page-footer" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col l2 m3 s12">
        @if (has_nav_menu('primary_navigation'))
          <h3>Menu</h3>
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'footer-menu']) !!}
        @endif
      </div>
      <div class="col l4 m4 s12 center-align">
        @php(dynamic_sidebar('sidebar-footer'))
      </div>
      <div class="col l6 m5 s12">
        <p><a href="#" class="btn btn-large btn-green">Support Our Work</a></p>
        <h3>Stay Informed</h3>
        <p>Sign up for our free email newsletter. We send out monthly emails with news and updates. We will not share your contact information and do not send spam.</p>
        [FORM]
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      <div class="flex flex-center space-between">
        <span class="copyright">&copy; @php(current_time('Y')) Disability Rights North Carolina</span>
        <a href="/privacy-policy/">Privacy Policy</a>
        <a href="/sitemap.xml">Site Map</a>
        @include('partials.unity')
      </div>
    </div>
  </div>
</footer>
