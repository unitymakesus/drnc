{{--
  Template Name: Home Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <section class="background-purple background-point-left" role="region" aria-label="Overview">
      <div class="line left-1 vertical purple-light length-60"></div>
      <div class="line left-2 vertical purple-light length-50"></div>
      <div class="line top-1 horizontal purple-light length-60"></div>
      <div class="line bottom-3 horizontal purple-light length-30"></div>
      <div class="row">
        <div class="col m8 s12">
          <h1>{{ get_field('main_text') }}</h1>
        </div>
        <div class="col m4 s12">
          <h2>{{ get_field('cta_title') }}</h2>
          <p>{{ get_field('cta_excerpt') }}</p>
          <div><a href="{{ get_field('cta_button_link') }}" class="btn btn-teal">{{ get_field('cta_button_text') }}</a></div>
        </div>
      </div>
    </section>

    <section class="sa-tools" role="region" aria-labelled-by="sa-tools-title">
      <div class="container">
        <div class="row">
          <div class="col l8 m10 s12 push-l2 push-m1 center-align">
            <h2 id="sa-tools-title">Self-Advocacy Tools</h2>
            <p>Search our extensive database by topic or keyword.</p>
            <form action="/getting-help/self-advocacy-tools/" method="GET">
              <select name="_resource_topic" aria-label="Topic" class="default">
                <option value="" selected>Topic</option>
                @php ($topics = get_terms(['taxonomy' => 'resource-topic', 'hide_empty' => TRUE]))
                @foreach ($topics as $t)
                  <option value="{{ $t->slug }}">{{ $t->name }} ({{ $t->count }})</option>
                @endforeach
              </select>
              <input type="text" class="facetwp-search" name="_search" placeholder="Keyword" aria-label="Keyword" />
              <input class="btn btn-teal" type="submit" value="Search" />
            </form>
          </div>
        </div>
      </div>
    </section>

    <section class="background-green background-point-right" role="region" aria-labelled-by="work-title">
      <div class="line left-1 vertical green-light length-80"></div>
      <div class="line top-1 horizontal green-light length-20"></div>
      <div class="row">
        <div class="col m4 s12">
          <h2 id="work-title">Our Work</h2>
          <p>{{ get_field('our_work_text') }}</p>
        </div>

        <div class="col m8 s12">
          @include ('partials.loop-work-home')
        </div>
      </div>
    </section>

    <div class="container">
      <div class="row">
        <section class="col m6 s12" role="region" aria-labelled-by="news-title">
          <h2 id="news-title">Latest News &amp; Announcements</h2>
          @php ($news = new WP_Query(['posts_per_page' => '3']))
          @if ($news->have_posts()) @while ($news->have_posts()) @php($news->the_post())
            @include('partials.content-'.get_post_type())
          @endwhile @endif @php(wp_reset_postdata())
        </section>

        <section class="col m6 s12" role="region" aria-labelled-by="social-title">
          <h2 id="social-title">Social Media &amp; Events</h2>
          <p>For our most recent updates, <a href="https://www.facebook.com/DisabilityRightsNC">follow us on Facebook</a>.</p>
          <div class="fb-page" data-href="https://www.facebook.com/DisabilityRightsNC" data-width="500px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/DisabilityRightsNC" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/DisabilityRightsNC">Disability Rights North Carolina on Facebook</a></blockquote></div>
          <p>You can also find us on:</p>
          <ul class="social-names">
            <li class="icon-twitter"><a href="https://twitter.com/disabilityrtsnc">Twitter</a></li>
            <li class="icon-linkedin"><a href="https://www.linkedin.com/company/251907/">LinkedIn</a></li>
          </ul>

          <div class="events-list">
            {!! do_shortcode('[my_calendar_upcoming category="4" template=\'<div class="featured-event"><time>{date format=\"M\"} <span>{date format=\"j\"}</span> {date format=\"Y\"}</time> <h3>{linking_title}</h3><p class=\"strong\">{location after="<br />"}{timerange}</p></div>\' before="0" show_today="yes" type="event" order="asc"]') !!}
            {!! do_shortcode('[my_calendar_upcoming category="1,2,3" template=\'<time>{date format=\"M\"} <span>{date format=\"j\"}</span> {date format=\"Y\"}</time> <h3>{link_title}</h3><p class=\"strong\">{location after="<br />"}{timerange}</p>\' before="0" after="2" show_today="yes" type="event" order="asc"]') !!}
          </div>
        </section>
      </div>
    </div>
  @endwhile
@endsection
