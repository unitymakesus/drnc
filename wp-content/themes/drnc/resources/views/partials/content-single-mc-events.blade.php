<article @php(post_class())>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
  </header>
  <div class="entry-content">
    @if (has_post_thumbnail())
      @php
        $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
        $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
      @endphp
      {!! get_the_post_thumbnail( get_the_ID(), 'large', ['alt' => $alt] ) !!}
    @endif
    @php(the_content())
  </div>
</article>
