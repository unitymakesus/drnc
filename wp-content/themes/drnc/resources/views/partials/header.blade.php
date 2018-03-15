<a href="#content" class="screen-reader-text">Skip to content</a>
<header class="banner" role="banner">
  <div class="a11y-tools" role="toolbar" aria-label="Accessibility Tools">
    <fieldset id="text-size" class="text-size" tabindex="-1">
      <legend>Change Text Size:</legend>
      <div>
        <input type="radio" name="text-size" id="default-size" value="default" checked>
        <label for="default-size">Default</label>
      </div>
      <div>
        <input type="radio" name="text-size" id="medium-size" value="medium">
        <label for="medium-size">Medium</label>
      </div>
      <div>
        <input type="radio" name="text-size" id="large-size" value="large">
        <label for="large-size">Large</label>
      </div>
    </fieldset>
    <fieldset id="toggle-contrast" class="toggle-contrast" tabindex="-1">
      <legend>Toggle Contrast:</legend>
      <div>
        <input type="checkbox" name="contrast" id="contrast" value="true" />
        <label for="contrast">High Contrast Mode</label>
      </div>
    </fieldset>
    {!! get_search_form(false) !!}
  </div>

  <nav role="navigation">
    <div class="container">
      <a class="logo left" href="{{ home_url('/') }}" rel="home">
        @if (has_custom_logo())
          @php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'ncecf-logo' );
            $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'ncecf-logo-2x' );
          @endphp
          <img src="{{ $logo[0] }}"
               srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
               alt="{{ get_bloginfo('name', 'display') }}"
               width="{{ $logo[1] }}" height="{{ $logo[2] }}" />
        @else
          {{ get_bloginfo('name', 'display') }}
        @endif
      </a>

      <div class="utility right">
        @if (has_nav_menu('social_links'))
          {!! wp_nav_menu(['theme_location' => 'social_links', 'menu_class' => 'social-icons right-align', 'menu_id' => 'header-social']) !!}
        @endif
        <div class="right-align"><a href="#" class="btn btn-blue">Support Our Work</a></div>
      </div>
    </div>

    <div class="navbar">
      @if (has_nav_menu('primary_navigation'))
        <a href="#" class="right menu-trigger show-on-medium-and-down"><i class="material-icons">menu</i></a>
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-menu flex flex-center space-between container', 'menu_id' => 'sidenav']) !!}
        <div class="sidenav-overlay"></div>
      @endif
    </div>
  </nav>
</header>
