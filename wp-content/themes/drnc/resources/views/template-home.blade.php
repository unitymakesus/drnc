{{--
  Template Name: Home Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <section class="background-purple background-point-left" role="region" aria-label="Overview">
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
          <div class="col l8 m10 s12 l-push-2 m-push-1">
            <h2 id="sa-tools-title">Self-Advocacy Tools</h2>
            <p>Search our extensive database by topic or keyword.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="background-green background-point-right" role="region" aria-labelled-by="work-title">
      <div class="row">
        <div class="col m4 s12">
          <h2 id="work-title">Our Work</h2>
          <p>Donec facilisis tortor ut augue lacinia, at viverra est semper. Sed sapien metus, scelerisque nec pharetra id, tempor a tortor. Pellentesque non dignissim neque.</p>
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
          [NEWS POSTS]
        </section>

        <section class="col m6 s12" role="region" aria-labelled-by="social-title">
          <h2 id="social-title">Social Media &amp; Events</h2>
          <p>For our most recent updates, <a href="#">follow us on Facebook</a>.</p>
          [FACEBOOK FEED]
          <p>You can also find us on:</p>
          <ul class="inline">
            <li><a href="#" class="icon-twitter">Twitter</a></li>
            <li><a href="#" class="icon-linkedin">LinkedIn</a></li>
          </ul>

          <hr />

          [EVENTS]
        </section>
      </div>
    </div>
  @endwhile
@endsection
