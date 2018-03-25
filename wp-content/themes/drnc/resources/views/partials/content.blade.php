<article @php(post_class('excerpt')) itemscope itemtype="http://schema.org/Article">
  <header>
    <h2 class="h3 entry-title" itemprop="name"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
    @include('partials/entry-meta')
  </header>
  <p class="entry-summary" itemprop="description">
    @if (has_post_thumbnail())
      <div class="row">
        <div class="col m3">
          @php
            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
            $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
          @endphp
          {!! get_the_post_thumbnail( get_the_ID(), 'thumbnail', ['alt' => $alt] ) !!}
        </div>
        <div class="col m9">
          @endif
          @php(the_excerpt())
          @if (has_post_thumbnail())
        </div>
      </div>
    @endif
  </p>
</article>
