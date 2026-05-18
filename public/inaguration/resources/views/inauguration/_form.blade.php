@php
    $selectedRoutes = old('route_names', $inauguration->route_names ?? []);
    $selectedScope = old('scope', $inauguration->scope ?? 'all');
    $selectedPosition = old('message_position', $inauguration->message_position ?? 'middle');
    $selectedAlign = old('content_align', $inauguration->content_align ?? 'center');
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $inauguration->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Optional event title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="message">Inauguration Message</label>
                    <textarea id="message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message', $inauguration->message ?? '') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="poster">Poster Image</label>
                    <input type="file" id="poster" name="poster" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('poster') is-invalid @enderror" {{ isset($inauguration) ? '' : 'required' }}>
                    <div class="form-text">Recommended portrait or square poster. Maximum file size: 4 MB.</div>
                    @error('poster')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($inauguration) && $inauguration->poster_path)
                        <div class="mt-2">
                            <small class="text-muted d-block mb-1">Current poster</small>
                            <img src="{{ $inauguration->posterUrl() }}" alt="Current inauguration poster" style="width:140px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Inauguration Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ isset($inauguration) ? '' : 'required' }} autocomplete="new-password">
                    <div class="form-text">{{ isset($inauguration) ? 'Leave blank to keep the current password.' : 'Visitors must enter this password to launch the site.' }}</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="message_position">Message Position</label>
                        <select id="message_position" name="message_position" class="form-control @error('message_position') is-invalid @enderror" required>
                            <option value="top" {{ $selectedPosition === 'top' ? 'selected' : '' }}>Top</option>
                            <option value="middle" {{ $selectedPosition === 'middle' ? 'selected' : '' }}>Middle</option>
                            <option value="bottom" {{ $selectedPosition === 'bottom' ? 'selected' : '' }}>Bottom</option>
                        </select>
                        @error('message_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="content_align">Content Align</label>
                        <select id="content_align" name="content_align" class="form-control @error('content_align') is-invalid @enderror" required>
                            <option value="left" {{ $selectedAlign === 'left' ? 'selected' : '' }}>Left</option>
                            <option value="center" {{ $selectedAlign === 'center' ? 'selected' : '' }}>Center</option>
                            <option value="right" {{ $selectedAlign === 'right' ? 'selected' : '' }}>Right</option>
                        </select>
                        @error('content_align')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>Activation Pages</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="scope">Enable For</label>
                    <select id="scope" name="scope" class="form-control @error('scope') is-invalid @enderror">
                        <option value="all" {{ $selectedScope === 'all' ? 'selected' : '' }}>Entire website</option>
                        <option value="selected" {{ $selectedScope === 'selected' ? 'selected' : '' }}>Selected routes/pages</option>
                    </select>
                    @error('scope')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="selected-route-panel" class="{{ $selectedScope === 'selected' ? '' : 'd-none' }}">
                    <div class="row">
                        @foreach($routeOptions as $option)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="route_names[]" value="{{ $option['name'] }}" id="route_{{ md5($option['name']) }}" {{ in_array($option['name'], $selectedRoutes, true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="route_{{ md5($option['name']) }}">
                                        {{ $option['label'] }}
                                        <span class="text-muted small d-block">{{ $option['uri'] }}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="paths">Additional Paths</label>
                        <textarea id="paths" name="paths" rows="5" class="form-control @error('paths') is-invalid @enderror" placeholder="/about-us&#10;/news-events/*">{{ collect(old('paths', $inauguration->paths ?? []))->implode(PHP_EOL) }}</textarea>
                        <div class="form-text">One path per line. Use a trailing * for page groups such as /news-events/*.</div>
                        @error('paths')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><strong>Publish</strong></div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_enabled" name="is_enabled" value="1" {{ old('is_enabled', $inauguration->is_enabled ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_enabled">Enable inauguration module</label>
                </div>
                <button type="submit" class="btn btn-success w-100">{{ $buttonText ?? 'Save' }}</button>
                <a href="{{ route('inauguration.index') }}" class="btn btn-secondary w-100 mt-2">Cancel</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var scope = document.getElementById('scope');
        var panel = document.getElementById('selected-route-panel');

        function syncScopePanel() {
            panel.classList.toggle('d-none', scope.value !== 'selected');
        }

        scope.addEventListener('change', syncScopePanel);
        syncScopePanel();
    });
</script>
@endpush
