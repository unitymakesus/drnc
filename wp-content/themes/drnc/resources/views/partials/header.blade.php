@if (App\display_sidebar())
  <a href="#aside" class="screen-reader-text">Skip to section navigation</a>
@endif
<a href="#main" class="screen-reader-text">Skip to content</a>
<header class="banner" role="banner">
  <div class="hide-on-med-and-up">
    <div class="a11y-tools-trigger-wrapper">
      <input type="checkbox" name="a11y-tools-trigger" id="a11y-tools-trigger" value="true" />
      <label for="a11y-tools-trigger"><i class="material-icons" aria-label="Show accessibility tools">accessibility_new</i></a>
    </div>
  </div>

  <div class="a11y-tools z-depth-2" role="toolbar" aria-label="Accessibility Tools">
    <div class="container flex flex-end">
      <fieldset id="text-size" class="text-size" tabindex="-1">
        <legend>Change Text Size:</legend>
        @php
          $cookie_size = $_COOKIE['data_text_size'];
          $text_sizes = [
            [
              'name' => 'default',
              'label' => 'Default Text Size'
            ],[
              'name' => 'medium',
              'label' => 'Medium Text Size'
            ],[
              'name' => 'large',
              'label' => 'Large Text Size'
            ]
          ];
        @endphp
        @foreach ($text_sizes as $size)
          <div class="{{ $size['name'] }}-size">
            <input type="radio" name="text-size" id="{{ $size['name'] }}-size" value="{{ $size['name'] }}" <?php if($cookie_size == $size['name']) {echo 'checked';} ?>>
            <label for="{{ $size['name'] }}-size">{{ $size['label'] }}</label>
          </div>
        @endforeach
      </fieldset>
      <fieldset id="toggle-contrast" class="toggle-contrast" tabindex="-1">
        <legend>Toggle Contrast:</legend>
        @php
          $cookie_contrast = $_COOKIE['data_contrast'];
        @endphp
        <div>
          <input type="checkbox" name="contrast" id="contrast" value="true" <?php if($cookie_contrast == 'true') {echo 'checked';} ?> />
          <label for="contrast">High Contrast Mode</label>
        </div>
      </fieldset>
      {!! get_search_form(false) !!}
    </div>
  </div>

  <nav role="navigation">
    <div class="container">
      <div class="row flex space-between">
        <a class="logo left" href="{{ home_url('/') }}" rel="home">
          @if (has_custom_logo())
            @php
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo = wp_get_attachment_image_src( $custom_logo_id , 'ncecf-logo' );
              $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'ncecf-logo-2x' );
            @endphp
            <img src="{{ $logo[0] }}"
                 srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
                 alt="Link to {{ get_bloginfo('name', 'display') }} Homepage"
                 width="{{ $logo[1] }}" height="{{ $logo[2] }}" />
          @else
            {{ get_bloginfo('name', 'display') }}
          @endif
        </a>

        <div class="utility right">
          <div class="hide-on-med-and-up">
            <div class="menu-trigger-wrapper">
              <input type="checkbox" name="menu-trigger" id="menu-trigger" value="true" />
              <label for="menu-trigger"><i class="material-icons" aria-label="Show navigation menu">menu</i></a>
            </div>
          </div>

          <div class="hide-on-small-only">
            @if (has_nav_menu('social_links'))
              {!! wp_nav_menu(['theme_location' => 'social_links', 'menu_class' => 'social-icons right-align', 'menu_id' => 'header-social']) !!}
            @endif
            <div class="right-align support-btn"><a href="/donate/" class="btn">Donate Now</a></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row navbar">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-menu flex flex-center space-between container collapsible']) !!}
      @endif
    </div>
  </nav>
</header>
