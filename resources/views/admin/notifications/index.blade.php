@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-bell me-2"></i>Notifications
      </h4>
    </div>
    <form method="POST" action="{{ route('admin.notifications.readAll') }}">
      @csrf
      <button class="btn btn-sm btn-outline-primary">
        <i class="fas fa-check-double me-1"></i>Mark All Read
      </button>
    </form>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      @forelse($notifications as $n)
      <div class="d-flex align-items-center gap-3 p-3 border-bottom {{ !$n->is_read ? 'bg-light' : '' }}">
        <div style="width:42px;height:42px;border-radius:50%;background:{{ $n->color }}22;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="{{ $n->icon }}" style="color:{{ $n->color }};font-size:1.1rem;"></i>
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold" style="font-size:.9rem;">{{ $n->title }}</div>
          <div class="text-muted" style="font-size:.82rem;">{{ $n->message }}</div>
          <div style="font-size:.75rem;color:#aaa;">{{ $n->created_at->diffForHumans() }}</div>
        </div>
        <div class="d-flex gap-2">
          @if($n->url)
          <a href="{{ $n->url }}" class="btn btn-sm btn-outline-primary" style="padding:3px 8px;font-size:.75rem;">
            View
          </a>
          @endif
          <form method="POST" action="{{ route('admin.notifications.destroy', $n) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger" style="padding:3px 8px;">
              <i class="fas fa-trash" style="font-size:.7rem;"></i>
            </button>
          </form>
        </div>
      </div>
      @empty
      <div class="text-center py-5 text-muted">
        <i class="fas fa-bell-slash fa-3x mb-3 d-block" style="opacity:.2;"></i>
        Koi notification nahi!
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection



