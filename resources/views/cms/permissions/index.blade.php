@extends("cms.parent")
@section("title",__("cms.permissions"))
@section("subTitle",__("cms.index"))
@section("styles")
@endsection
@section("content")
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped table-hover text-nowrap">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>{{__('cms.name')}}</th>
                  <th>{{__("cms.guard_name")}}</th>
                  <th>{{__("cms.created_at")}}</th>
                  <th>{{__("cms.updated_at")}}</th>
                  <th style="width: 40px">Setting</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($permissions as $permission )
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$permission->name}}</td>
                  <td>{{$permission->guard_name}}</td>
                  <td>{{$permission->created_at}}</td>
                  <td>{{$permission->updated_at}}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{route("permissions.edit",$permission->id)}}" class="btn btn-info">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="#" onclick="confirmDelete('{{$permission->id}}',this)" type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
          </div>
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
      >
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section("scripts")
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  function confirmDelete(id,reference){
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
      performeDelete(id,reference);
      let timerInterval;
      Swal.fire({
      icon:"success",
      title: 'Deleted Successfuly!',
      html: '',
      timer: 1000,
      willClose: () => {
      clearInterval(timerInterval)
      },
      }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
      console.log('I was closed by the timer')
      }
      })
    }
    });
  }
  function performeDelete(id,reference){
        axios.delete('/cms/admin/permissions/'+id)
        .then(function (response) {
            toastr.success(response.data.message);
            reference.closest("tr").remove();
        })
        .catch(function (error) {
            //toastr.error(error.response.data.message)
        console.log(error.response.data.message);
        });
    }
</script>
@endsection