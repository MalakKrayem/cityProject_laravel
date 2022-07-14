@extends("cms.parent")
@section("title",__("cms.admins"))
@section("subTitle",__("cms.create"))
@section("styles")
@endsection
@section("content")
<form id="create_form">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="name">{{__('cms.name')}}</label>
            <input type="text" class="form-control" id="name" placeholder="{{__('cms.enter_name')}}" name="name">
        </div>
        <div class="form-group">
            <label for="email">{{__('cms.email')}}</label>
            <input type="email" class="form-control" id="email" placeholder="{{__('cms.enter_email')}}" name="email">
        </div>
        <div class="form-group">
            <label for="password">{{__('cms.password')}}</label>
            <input type="password" class="form-control" id="password" placeholder="{{__('cms.enter_password')}}"
                name="password">
        </div>
        <div class="form-group">
            <label>{{__('cms.role')}}</label>
            <select class="custom-select" name="role_id" id="role_id">
                @foreach ($roles as $role )
                <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
        
            </select>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="button" onclick="performeStore()" class="btn btn-primary">{{__('cms.save')}}</button>
    </div>
</form>
@endsection

@section("scripts")

<script>
    function performeStore(){
        axios.post('/cms/admin/admins', {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        password:document.getElementById("password").value,
        role_id:document.getElementById("role_id").value,
        })
        .then(function (response) {
            toastr.success(response.data.message);
            document.getElementById("create_form").reset();
        })
        .catch(function (error) {
            toastr.error(error.response.data.message)
        console.log(error.response.data.message);
        });
    }
</script>
@endsection