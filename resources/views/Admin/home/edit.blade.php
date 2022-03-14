@extends('admin.admin_master')
@section('admin')

<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Edit Home About</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('update/homeabout/'.$homeAbout->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">About Title</label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Enter About Title" value="{{ $homeAbout->title }}">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Short Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="short_description">{{ $homeAbout->short_description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Long Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="long_description" >{{ $homeAbout->long_description }}</textarea>
                </div>
                <div class="pt-4 pt-5 mt-4 form-footer border-top">
                    <button type="submit" class="btn btn-primary btn-default">Update</button>
                    <button type="submit" class="btn btn-secondary btn-default">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
