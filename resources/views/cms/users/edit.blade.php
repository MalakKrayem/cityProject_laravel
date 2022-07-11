@extends("cms.parent")
@section("title",__("cms.users"))
@section("subTitle",__("cms.update"))

@section("content")
<form >
   
    <div class="card-body">
        <div class="form-group">
            <label for="name">{{__('cms.name')}}</label>
            <input type="text" class="form-control" id="name" placeholder="{{__('cms.enter_name')}}" name="name" value="{{$user->name}}" >
        </div>
        <div class="form-group">
            <label for="email">{{__('cms.email')}}</label>
            <input type="email" class="form-control" id="email" placeholder="{{__('cms.enter_email')}}"
                name="email" value="{{$user->email}}" >
        </div>
        <div class="form-group">
            <label>{{__('cms.city_name')}}</label>
            <select class="custom-select" name="city_id" id="city_id" >
                @foreach ($cities as $city )
                <option value="{{$city->id}}" @if ($user->city_id == $city->id) selected @endif>{{$city->name_en}}</option>
                @endforeach
        
            </select>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="button" onclick="performeUpdate()" class="btn btn-primary">{{__('cms.update')}}</button>
    </div>
</form>
@endsection
@section("scripts")

<script>
    function performeUpdate(){
        axios.put('/cms/admin/users/{{$user->id}}', {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        city_id:document.getElementById("city_id").value,
        })
        .then(function (response) {
            toastr.success(response.data.message);
            window.location.href="/cms/admin/users";
        })
        .catch(function (error) {
            toastr.error(error.response.data.message)
        console.log(error.response.data.message);
        });
    }
</script>
@endsection