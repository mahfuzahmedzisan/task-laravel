@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Add New Category</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('c.category.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
