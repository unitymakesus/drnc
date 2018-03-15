<div class="flex-grid m2x s1x">
  @php ($work = get_field('featured_work'))
  @foreach ($work as $w)
    <div class="flex-item" style="background-image: url('{{ $w['thumbnail']['sizes']['medium'] }}')">
      <a href="{{ $w['link'] }}">
        <span class="text-overlay">{{ $w['title'] }}</span>
      </a>
    </div>
  @endforeach
</div>
