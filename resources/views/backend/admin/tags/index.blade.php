@extends('layouts.admin')

@push('css')
<link href="{{asset('contents/backend')}}/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
    rel="stylesheet">
@endpush

@section('title', 'Tags')
@section('content')

<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-primary waves-effect" href="{{route('admin.tags.create')}}">
            <i class="material-icons">add</i>
            <span>Create New Tag</span>
        </a>
    </div>
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        All Tag
                    <span class="badge badge-primary">{{$tags->count()}}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Create Time</th>
                                    <th>Update Time</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Create Time</th>
                                    <th>Update Time</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($tags as $key=>$tag)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$tag->name}}</td>
                                    <td class="text-center">{{$tag->posts->count()}}</td>
                                    <td>{{$tag->created_at->format('d M, Y | h:i:s a')}}</td>
                                    <td>{{$tag->updated_at->format('d M, Y | h:i:s a')}}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.tags.show',$tag->id)}}"
                                            class="btn-sm btn-primary waves-effect">
                                            <i class="material-icons">add</i>
                                        </a>
                                        <a href="{{route('admin.tags.edit',$tag->id)}}"
                                            class="btn-sm btn-info waves-effect">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <button class="btn-sm btn-danger waves-effect delete-action" type="button"
                                            onclick="deleteTag({{$tag->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="delete-form-{{$tag->id}}"
                                            action="{{route('admin.tags.destroy',$tag->id)}}" method="post"
                                            class="display-none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>

@endsection
@push('js')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js">
</script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="{{asset('contents/backend')}}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src="{{asset('contents/backend')}}/js/pages/tables/jquery-datatable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
    function deleteTag(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-form-' + id).submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

</script>
@endpush
