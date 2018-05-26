<article @php(post_class('excerpt'))>
  <header>
    <h3 class="excerpt-title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h3>
    <div class="meta">
      @php
        global $wpdb;
        $event_data = get_post_meta(get_the_ID(), '_mc_event_data', true);
        $event_begin_date = ( isset( $event_data['event_begin'] ) ) ? $event_data['event_begin'] : $event_data['event_begin'] . ' ' . $event_data['event_time'];
      @endphp
      <div><span class="label">Date:</span> <time class="date" datetime="{{ date('c', strtotime($event_begin_date)) }}">{{ date('F j, Y', strtotime($event_begin_date)) }}</time></div>
      <div><span class="label">Location:</span> {{ $event_data['event_label'] }}</div>
    </div>
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
