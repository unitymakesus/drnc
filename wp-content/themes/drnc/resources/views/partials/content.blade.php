<article @php(post_class('excerpt')) itemscope itemtype="http://schema.org/Article">
  @if (has_post_thumbnail())
    <div class="row">
      <div class="col xs12 s6 m3">
        @php
          $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
          $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
        @endphp
        {!! get_the_post_thumbnail( get_the_ID(), 'thumbnail', ['alt' => $alt] ) !!}
      </div>
      <div class="col xs12 s6 m9">
        @endif
        <header>
          <h3 class="h3 entry-title" itemprop="name"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>
          @include('partials/entry-meta')
        </header>
        @if (has_post_thumbnail())
      </div>
    </div>
  @endif
  <p class="entry-summary" itemprop="description">
    @php(the_advanced_excerpt())
  </p>
</article>
