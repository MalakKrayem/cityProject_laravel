@extends("cms.parent")
@section("title",__("cms.admins"))
@section("subTitle",__("cms.update"))

@section("content")
<form >
   
    <div class="card-body">
        <div class="form-group">
            <label for="name">{{__('cms.name')}}</label>
            <input type="text" class="form-control" id="name" placeholder="{{__('cms.enter_name')}}" name="name" value="{{$admin->name}}" >
        </div>
        <div class="form-group">
            <label for="email">{{__('cms.email')}}</label>
            <input type="email" class="form-control" id="email" placeholder="{{__('cms.enter_email')}}"
                name="email" value="{{$admin->email}}" >
        </div>
        <div class="form-group">
            <label>{{__('cms.role')}}</label>
            <select class="custom-select" name="role_id" id="role_id">
                @foreach ($roles as $role )
                <option value="{{$role->id}}" @if ($role->id == $adminRole->id) selected @endif>
                    {{$role->name}}</option>
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
        axios.put('/cms/admin/admins/{{$admin->id}}', {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        role_id:document.getElementById("role_id").value,
        })
        .then(function (response) {
            toastr.success(response.data.message);
            window.location.href="/cms/admin/admins";
        })
        .catch(function (error) {
            toastr.error(error.response.data.message)
        console.log(error.response.data.message);
        });
    }
</script>
@endsection