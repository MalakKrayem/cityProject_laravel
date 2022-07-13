@extends("cms.parent")
@section("title",__("cms.roles"))
@section("subTitle",__("cms.create"))
@section("styles")
@endsection
@section("content")
<form id="create_form">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="name">{{__('cms.name')}}</label>
            <input type="text" class="form-control" id="name" placeholder="{{__('cms.enter_name')}}" name="name" >
        </div>
        <div class="form-group">
            <label>{{__('cms.guard_name')}}</label>
            <select class="custom-select" name="guard_name" id="guard_name">
                <option value="web">Web</option>
                <option value="admin">Admin</option>
                
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
        axios.post('/cms/admin/roles', {
        name: document.getElementById("name").value,
        guard_name:document.getElementById("guard_name").value,
        })
        .then(function (response) {
            toastr.success(response.data.message);
            window.location.href="/cms/admin/roles";
        })
        .catch(function (error) {
            toastr.error(error.response.data.message)
        console.log(error.response.data.message);
        });
    }
</script>
@endsection