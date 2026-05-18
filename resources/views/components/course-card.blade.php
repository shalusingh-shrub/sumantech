@props(['course'])

<div class="st-card h-100">
    <div style="height:150px;background:linear-gradient(135deg,{{ $course->homepage_color }},rgba(0,0,0,.3) 150%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">
        @if($course->image_url)
            <img src="{{ $course->image_url }}" alt="{{ $course->name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.28;">
        @endif
        <i class="fas {{ $course->homepage_icon }}" style="font-size:2.5rem;color:rgba(255,255,255,.25);position:relative;z-index:1;"></i>
        @if($course->homepage_badge)
        <span class="position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill" style="background:var(--gold);color:var(--navy);font-size:.68rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;z-index:2;">{{ $course->homepage_badge }}</span>
        @endif
    </div>
    <div class="p-3">
        <h5 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:8px;">{{ $course->name }}</h5>
        <p style="font-size:.85rem;color:var(--muted);line-height:1.65;margin-bottom:14px;">{{ \Illuminate\Support\Str::limit($course->description ?: 'Professional course designed to make you industry ready.', 120) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:.78rem;color:var(--muted);"><i class="far fa-clock me-1"></i>{{ $course->duration }}</span>
            <a href="{{ $course->slug ? route('course.show', $course->slug) : route('course.legacy-show', $course->id) }}" style="font-size:.82rem;font-weight:700;color:var(--blue);text-decoration:none;">View Details &rarr;</a>
        </div>
    </div>
</div>
