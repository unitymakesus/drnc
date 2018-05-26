@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{  __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <div class="facetwp-template">
    @while (have_posts()) @php(the_post())
      @php ($post_type = get_post_type())
      @if ($post_type == 'drnc-resource')
        @include('partials.content-single-resource')
      @elseif ($post_type == 'mc-events')
        @include('partials.content-search-mc-events')
      @else
        @include('partials.content-search')
      @endif
    @endwhile

    @php(wp_reset_postdata())

    <nav class="pagination" role="navigation" aria-label="Results Pagination">
      {!! do_shortcode('[facetwp pager="true"]') !!}
    </nav>
  </div>
@endsection
