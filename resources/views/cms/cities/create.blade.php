@extends("cms.parent")
@section("title",__("cms.cities"))
@section("subTitle",__("cms.create"))

@section("content")
<form method="POST" action="{{route("cities.store")}}">
    @csrf
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Errors!</h5>
            <ul>
                @foreach ($errors->all() as $error )
                <li>{{$error}}</li> 
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-group">
            <label for="name_en">{{__('cms.name_en')}}</label>
            <input type="text" class="form-control" id="name_en" placeholder="{{__('cms.enter_name_en')}}" name="name_en" value="{{old("name_en")}}">
        </div>
        <div class="form-group">
            <label for="name_ar">{{__('cms.name_ar')}}</label>
            <input type="text" class="form-control" id="name_en" placeholder="{{__('cms.enter_name_ar')}}" name="name_ar"value="{{old("name_ar")}}">
        </div>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" value="{{old("active")}}">
                <label class="custom-control-label" for="customSwitch1">{{__('cms.active')}}</label>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{__('cms.save')}}</button>
    </div>
</form>
@endsection