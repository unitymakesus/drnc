<div class="flex-grid m2x s1x">
  @php ($work = get_field('featured_work'))
  @foreach ($work as $w)
    <div class="flex-item">
      <div class="work-tile" style="background-image: url('{{ $w['thumbnail']['sizes']['medium'] }}')">
        <a href="{{ $w['link'] }}">
          <span>{{ $w['title'] }}</span>
        </a>
      </div>
    </div>
  @endforeach
</div>
