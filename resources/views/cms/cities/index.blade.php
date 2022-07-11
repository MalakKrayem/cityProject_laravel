@extends("cms.parent")
@section("title",__("cms.cities"))
@section("subTitle",__("cms.index"))
@section("content")
<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            @if (session()->has("success"))              
            <div class="alert alert-success alert-dismissible">
              <a href="" class="close" data-dismiss="alert" aria-hidden="true">×</a>
              <h5><i class="icon fas fa-check"></i> Sucess!</h5>
              {{session("success")}}
            </div>
            @endif
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
                      <th>{{__('cms.name_en')}}</th>
                      <th>{{__("cms.name_ar")}}</th>
                      <th>{{__("cms.active")}}</th>
                      <th>{{__("cms.created_at")}}</th>
                      <th>{{__("cms.updated_at")}}</th>
                      <th style="width: 40px">Setting</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cities as $city )
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$city->name_en}}</td>
                      <td>{{$city->name_ar}}</td>
                      <td><span class="badge @if ($city->active) bg-success @else bg-danger @endif">
                        {{$city->active_status}}</span></td>
                        <td>{{$city->created_at}}</td>
                        <td>{{$city->updated_at}}</td>
                      <td>
                        <div class="btn-group">
                          <a href="{{route("cities.edit",$city)}}" class="btn btn-info">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="{{route("cities.edit",$city)}}" class="btn btn-success">
                            <i class="fas fa-eye"></i>
                          </a>
                          <form action="{{route("cities.destroy",$city)}}" method="post">
                            @csrf
                            @method('DELETE')
                          <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                          </button>
                          </form>
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