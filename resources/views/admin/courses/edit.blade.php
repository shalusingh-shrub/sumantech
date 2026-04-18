@extends('layouts.admin')
@section('title', 'Edit Course')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-edit me-2"></i>Edit Course
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
      <span class="fw-bold"><i class="fas fa-book me-2"></i>{{ $course->name }}</span>
    </div>
    <div class="card-body p-4">
      <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Course Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Duration *</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}" placeholder="e.g. 2 Month" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Fee (₹) *</label>
            <input type="number" name="fee" class="form-control" value="{{ old('fee', $course->fee) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Course Image</label>
            <input type="file" name="image" class="form-control" accept="image/*"
                   onchange="document.getElementById('preview').src=URL.createObjectURL(this.files[0]);document.getElementById('preview').style.display='block'">
            @if($course->image)
            <div class="mt-2">
              <img id="preview" src="{{ asset('storage/'.$course->image) }}"
                   style="height:80px;border-radius:8px;object-fit:cover;">
              <small class="text-success d-block mt-1"><i class="fas fa-check-circle me-1"></i>Image uploaded</small>
            </div>
            @else
            <img id="preview" src="" style="height:80px;border-radius:8px;object-fit:cover;display:none;" class="mt-2">
            @endif
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $course->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$course->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Course Level</label>
            <select name="course_level" class="form-select">
              <option value="">Select Level</option>
              <option value="Beginner"     {{ $course->course_level=='Beginner'     ?'selected':'' }}>Beginner</option>
              <option value="Intermediate" {{ $course->course_level=='Intermediate' ?'selected':'' }}>Intermediate</option>
              <option value="Advanced"     {{ $course->course_level=='Advanced'     ?'selected':'' }}>Advanced</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Eligibility</label>
            <input type="text" name="eligibility" class="form-control"
                   value="{{ old('eligibility', $course->eligibility) }}"
                   placeholder="e.g. 10th Pass, Any Graduate">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Course ke baare mein likhо...">{{ old('description', $course->description) }}</textarea>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Course Highlights</label>
            <textarea name="highlights" class="form-control" rows="4"
                      placeholder="Har line mein ek highlight likhо...">{{ old('highlights', $course->highlights) }}</textarea>
            <small class="text-muted">Har line mein ek point likho</small>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Career Opportunities</label>
            <textarea name="career_opportunities" class="form-control" rows="3"
                      placeholder="e.g. Web Developer, Freelancer, Data Entry Operator">{{ old('career_opportunities', $course->career_opportunities) }}</textarea>
          </div>

          {{-- SYLLABUS BUILDER --}}
          <div class="col-12">
            <label class="form-label fw-semibold">
              <i class="fas fa-book-open me-1" style="color:#F0A500;"></i>
              Course Syllabus (Section-wise)
            </label>
            <small class="text-muted d-block mb-2">
              Example: Section = "HTML" → Topics = "Introduction", "Tags", "Forms"
            </small>

            <div id="syllabusBuilder">
              @php $syllabus = is_array($course->syllabus) ? $course->syllabus : json_decode($course->syllabus, true) ?? []; @endphp
                @if(count($syllabus) > 0)
                @foreach($syllabus as $si => $section)
                <div class="syllabus-section border rounded p-3 mb-3" style="background:#f8f9fa;">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" name="syllabus[{{ $si }}][section]"
                           class="form-control fw-bold" style="max-width:350px;"
                           placeholder="Section Name e.g. HTML, MS Word"
                           value="{{ $section['section'] }}">
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                            onclick="this.closest('.syllabus-section').remove()">
                      <i class="fas fa-trash"></i> Remove
                    </button>
                  </div>
                  <div class="topics-list">
                    @foreach($section['topics'] as $topic)
                    @php if(!trim($topic)) continue; @endphp
                    <div class="input-group mb-2">
                      <span class="input-group-text bg-white">
                        <i class="fas fa-dot-circle" style="font-size:.7rem;color:#1a2a6c;"></i>
                      </span>
                      <input type="text" name="syllabus[{{ $si }}][topics][]"
                             class="form-control" placeholder="Topic name"
                             value="{{ $topic }}">
                      <button type="button" class="btn btn-outline-danger"
                              onclick="this.closest('.input-group').remove()">×</button>
                    </div>
                    @endforeach
                  </div>
                  <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                          onclick="addTopic(this)">
                    <i class="fas fa-plus me-1"></i>Add Topic
                  </button>
                </div>
                @endforeach
              @endif
            </div>

            <button type="button" class="btn btn-outline-success btn-sm"
                    onclick="addSection()">
              <i class="fas fa-plus me-1"></i>Add New Section
            </button>
          </div>

        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Update Course
          </button>
          <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
let sectionCount = {{ count($syllabus) }};

function addSection() {
    const si = sectionCount++;
    const html = `
    <div class="syllabus-section border rounded p-3 mb-3" style="background:#f8f9fa;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <input type="text" name="syllabus[${si}][section]"
               class="form-control fw-bold" style="max-width:350px;"
               placeholder="Section Name e.g. HTML, MS Word">
        <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                onclick="this.closest('.syllabus-section').remove()">
          <i class="fas fa-trash"></i> Remove
        </button>
      </div>
      <div class="topics-list">
        <div class="input-group mb-2">
          <span class="input-group-text bg-white">
            <i class="fas fa-dot-circle" style="font-size:.7rem;color:#1a2a6c;"></i>
          </span>
          <input type="text" name="syllabus[${si}][topics][]"
                 class="form-control" placeholder="Topic name e.g. Introduction">
          <button type="button" class="btn btn-outline-danger"
                  onclick="this.closest('.input-group').remove()">×</button>
        </div>
      </div>
      <button type="button" class="btn btn-sm btn-outline-primary mt-1"
              onclick="addTopic(this)">
        <i class="fas fa-plus me-1"></i>Add Topic
      </button>
    </div>`;
    document.getElementById('syllabusBuilder').insertAdjacentHTML('beforeend', html);
}

function addTopic(btn) {
    const section = btn.closest('.syllabus-section');
    const nameAttr = section.querySelector('input[name*="[section]"]').getAttribute('name');
    const si = nameAttr.match(/\[(\d+)\]/)[1];
    const html = `
    <div class="input-group mb-2">
      <span class="input-group-text bg-white">
        <i class="fas fa-dot-circle" style="font-size:.7rem;color:#1a2a6c;"></i>
      </span>
      <input type="text" name="syllabus[${si}][topics][]"
             class="form-control" placeholder="Topic name">
      <button type="button" class="btn btn-outline-danger"
              onclick="this.closest('.input-group').remove()">×</button>
    </div>`;
    section.querySelector('.topics-list').insertAdjacentHTML('beforeend', html);
}
</script>
@endsection