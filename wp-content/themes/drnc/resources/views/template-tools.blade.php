{{--
  Template Name: Tools/Resources Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    @include('partials.content-page')
  @endwhile

  <section class="border-top" role="region" aria-label="Resources List">

    <div class="row flex">
      <div class="col m6 s12">
        {!! do_shortcode('[facetwp sort="true"]') !!}
      </div>
      <div class="col m6 s12 right-align flex flex-bottom">
        {!! do_shortcode('[facetwp counts="true"]') !!}
      </div>
    </div>

    <div class="facetwp-template">
      @php
        $resources = new WP_Query([
          'post_type' => 'drnc-resource',
          'posts_per_page' => 10,
          'facetwp' => true,
          'orderby' => 'menu_order',
          'order' => 'ASC'
        ]);
      @endphp

      @if ($resources->have_posts())

        @while ($resources->have_posts())
          @php
            $resources->the_post();
            $link = (get_field('uploaded_file') == 1) ? get_the_permalink() : get_field('link');
            $topic_list = wp_get_post_terms(get_the_id(), 'resource-topic', array('fields' => 'names'));
            $type_list = wp_get_post_terms(get_the_id(), 'resource-type', array('fields' => 'names'));
            $source_list = wp_get_post_terms(get_the_id(), 'resource-source', array('fields' => 'names'));
          @endphp

          <div class="resource" itemscope itemtype="http://schema.org/CreativeWork">
            <h2 class="h3" itemprop="name"><a href="{{ $link }}" target="_blank" rel="noopener" itemprop="url">{{ the_title() }}</a></h2>

            @if (!empty($topic_list))
              @php
                foreach ($topic_list as &$topic) :
                  $topic = '<span itemprop="about">' . $topic . '</span>';
                endforeach;
              @endphp
              <div class="meta"><span class="label">Topic:</span>
                {!! implode(', ', $topic_list) !!}
              </div>
            @endif

            @if (!empty($type_list))
              @php
                foreach ($type_list as &$type) :
                  $type = '<span itemprop="learningResourceType">' . $type . '</span>';
                endforeach;
              @endphp
              <div class="meta"><span class="label">Type:</span>
                {!! implode(', ', $type_list) !!}
              </div>
            @endif

            @if (!empty($source_list))
              @php
                foreach ($source_list as &$source) :
                  $source = '<span itemprop="creator">' . $source . '</span>';
                endforeach;
              @endphp
              <div class="meta"><span class="label">Source:</span>
                {!! implode(', ', $source_list) !!}
              </div>
            @endif

            <div class="content" itemprop="description">{!! get_field('description') !!}</div>
          </div>
        @endwhile

        <nav class="pagination" role="navigation" aria-label="Results Pagination">
          {!! do_shortcode('[facetwp pager="true"]') !!}
        </nav>
      @else
        <p><?php _e( 'Sorry, no resources matched your criteria.' ); ?></p>
      @endif
      @php (wp_reset_postdata())
    </div>
  </section>
@endsection
