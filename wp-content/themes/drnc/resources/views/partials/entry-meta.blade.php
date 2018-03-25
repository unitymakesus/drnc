@php ($topic_list = wp_get_post_terms(get_the_id(), 'category', array('fields' => 'names')))
<div class="meta">
  <div><span class="label">Posted:</span> <time class="date updated published" datetime="{{ get_post_time('c', true) }}" itemprop="datePublished">{{ get_the_date('F j, Y') }}</time></div>
  @if (!empty($topic_list))
    @php
      foreach ($topic_list as &$topic) :
        $topic = '<span itemprop="about">' . $topic . '</span>';
      endforeach;
    @endphp
    <div><span class="label">Tags:</span>
      {!! implode(', ', $topic_list) !!}
    </div>
  @endif
</div>
