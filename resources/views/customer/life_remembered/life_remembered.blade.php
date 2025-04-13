@extends('layouts.master')

@section('content')
<style>
  .ck-editor__editable_inline {
    min-height: 300px;
  }
</style>

<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Life Remembered</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <form action="{{ route('customer.life_remembered.update') }}" method="POST">
                    @csrf
                    <textarea name="content" id="editor">{{ old('content', $lifeRemembered->content ?? '') }}</textarea>
                    @error('content')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-4" style="float:left;">Update Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include CKEditor 5 -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
  -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@36.0.1/build/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#editor'), {
      toolbar: {
        items: [
          'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
          'insertTable', 'mediaEmbed', 'imageUpload', 'undo', 'redo'
        ]
      },
      ckfinder: {
        uploadUrl: '{{ route("customer.life_remembered.upload") }}?_token={{ csrf_token() }}'
      },
      mediaEmbed: {
        previewsInData: true
      }
    })
    .catch(error => {
      console.error(error);
    });
</script>

@endsection