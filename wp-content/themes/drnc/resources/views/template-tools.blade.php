{{--
  Template Name: Tools/Resources Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    @include('partials.content-page')
  @endwhile

  @php
    $resources = new WP_Query([
      'post_type' => 'drnc-resource',
      'posts_per_page' => 10,
      'facetwp' => true,
    ]);
  @endphp

  @if ($resources->have_posts())
    @while ($resources->have_posts())
      @php
        the_post();
        $link = (get_field('uploaded_file') == 1) ? wp_get_attachment_url(get_field('file')) : get_field('link');
        $topic_list = wp_get_post_terms(get_the_id(), 'resource-topic', array('fields' => 'names'));
        $type_list = wp_get_post_terms(get_the_id(), 'resource-type', array('fields' => 'names'));
        $source_list = wp_get_post_terms(get_the_id(), 'resource-source', array('fields' => 'names'));
      @endphp

      <h3><a href="{{ $link }}" target="_blank" rel="noopener">{{ the_title() }}</a></h3>

      @if (!empty($topic_list))
        @foreach ($topic_list as $topic)
          <div class="chip"><i class="material-icons" aria-label="Type">library_books</i>{{ $term }}</div>
        @endforeach
      @endif

      @if (!empty($type_list))
        @foreach ($type_list as $type)
          <div class="chip"><i class="material-icons" aria-label="Issue">attach_file</i>{{ $issue->post_title }}</div>
        @endforeach
      @endif

      @if (!empty($source_list))
        @foreach ($source_list as $source)
          <div class="chip"><i class="material-icons" aria-label="Initiative">lightbulb_outline</i>{{ $initiative->post_title }}</div>
        @endforeach
      @endif

      <div class="chip"><i class="material-icons" aria-label="Year">date_range</i>{{ get_field('year') }}</div>
    @endwhile

    <div class="center-align">
      {!! do_shortcode('[facetwp pager="true"]') !!}
    </div>
  @else
    <p><?php _e( 'Sorry, no resources matched your criteria.' ); ?></p>
  @endif
@endsection
