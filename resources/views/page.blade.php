@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-10 offset-md-1">
        <div class="card">
          <h5 class="card-header">Page {{ $pageId }}</h5>
          <div class="card-body">
            <p class="card-text">This is an example page</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="comments col-md-8 mx-auto">
        <h3 class="mb-4">Comments</h3>

        <comments comment-url="{{ $pageId }}"></comments>

      </div>
    </div>
  </div>
@endsection
