@extends('admin.layouts.master', ['page_slug' => 'product_management'])
@section('title', 'Edit product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Service') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'sm.service.index',
                        'label' => 'Back',
                        'permissions' => ['service-list', 'service-delete', 'service-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('sm.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" value="{{ $service->name }}" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feedback-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Enter description" rows="5">{{ $service->description }}</textarea>
                            <x-feedback-alert :datas="['errors' => $errors, 'field' => 'description']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="uploadImage" data-actualName="image"
                                class="form-control filepond" id="image">
                            <x-feedback-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>

                        <div class="d-flex flex-wrap">
                            <div class="flex-fill">
                                <div class="form-group">
                                    <label>{{ __('Category') }}</label>
                                    <input type="text" value="{{ $service->category }}" name="category"
                                        class="form-control">
                                    <x-feedback-alert :datas="['errors' => $errors, 'field' => 'category']" />
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="form-group">
                                    <label>{{ __('Price') }}</label>
                                    <input type="text" value="{{ $service->price }}" name="price" class="form-control">
                                    <x-feedback-alert :datas="['errors' => $errors, 'field' => 'price']" />
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="form-group">
                                    <label>{{ __('Duration') }}</label>
                                    <input type="text" value="{{ $service->duration }}" name="duration"
                                        class="form-control">
                                    <x-feedback-alert :datas="['errors' => $errors, 'field' => 'duration']" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
