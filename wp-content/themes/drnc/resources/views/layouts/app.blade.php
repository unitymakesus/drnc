<!doctype html>
@php
  $text_size = $_COOKIE['data_text_size'];
  $contrast = $_COOKIE['data_contrast'];
@endphp
<html @php(language_attributes()) data-text-size="{{ $text_size }}" data-contrast="{{ $contrast }}">
  @include('partials.head')
  <body @php(body_class())>
    @if (!is_user_logged_in())
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZPJJVP"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    @endif
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=202582597183930&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!--[if IE]>
      <div class="alert alert-warning">
        {!! __('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage') !!}
      </div>
    <![endif]-->
    @php(do_action('get_header'))
    @include('partials.header')
    <div id="content" class="content" role="document">
      <div class="wrap">
        @if (App\display_sidebar())
          <aside id="aside" class="sidebar" role="complementary">
            @include('partials.sidebar')
          </aside>
        @endif
        <main id="main" class="main" role="main">
          @yield('content')
        </main>
      </div>
    </div>
    @php(do_action('get_footer'))
    @include('partials.footer')
    @php(wp_footer())
  </body>
</html>
