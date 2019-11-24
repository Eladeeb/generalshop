@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tags</div>

                <div class="card-body">

                    <form action="{{ route('roles') }}" method="post" class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="role_name">Role Name </label>
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                   placeholder="Role Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save New Role</button>
                        </div>
                    </form>

                    <div class="row">
                        @foreach($roles as $role)
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">
                                <span class="buttons-span">
                                 <span><a class="edit-unit"
                                          data-rolename="{{ $role->role }}"
                                          data-roleid="{{ $role->id }}"><i class="fas fa-edit"></i></a></span>
                                <span><a class="delete-unit"
                                         data-rolename="{{ $role->role }}"
                                         data-roleid="{{ $role->id }}"><i class="fas fa-trash-alt"></i></a></span>
                                </span>
                                <p>{{ $role->role}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ ( ! is_null($showLinks) && $showLinks) ? $roles->links() : '' }}

                    <form action="{{ route('search-roles') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="role_search" name="role_search"
                                       placeholder="Search Role" required>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary">SEARCH</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>



<div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
    <form action="{{ route('roles') }}" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="edit_role_name">Role Name </label>
                        <input type="text" class="form-control"
                               id="edit_role_name" name="role_name" placeholder="Role Name" required>
                    </div>

                    <input type="hidden" name="role_id" id="edit_role_id">
                    <input type="hidden" name="_method" value="PUT"/>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>

            </div>
        </div>
    </form>
</div>



<div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('roles') }}" method="post">
                <div class="modal-body">
                    <p id="delete-message"></p>
                    @csrf
                    <input type="hidden" name="_method" value="delete"/>
                    <input type="hidden" name="role_id" value="" id="role_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(Session::has('message'))
<div class="toast" style="position: absolute; z-index: 99999; top:5%; right: 5%;">
    <div class="toast-header">
        <strong class="mr-auto">Role</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">

        {{ Session::get('message')    }}

    </div>
</div>


@endif

@endsection

@section('scripts')

<script>
    $(document).ready(function () {
        var $deleteUnit = $('.delete-unit');
        var $deleteWindow = $(' #delete-window');
        var $RoleID = $('#role_id');
        var $deleteMessage = $('#delete-message');


        $deleteUnit.on('click', function (element) {
            element.preventDefault();
            var role_id = $(this).data('roleid');
            $RoleID.val(role_id);
            $deleteMessage.text(' Are you sure you want to delete this Tag');
            $deleteWindow.modal('show');

        });


        var $editRole= $('.edit-unit');
        var $editWindow = $(' #edit-window');

        var $edit_role_name = $('#edit_role_name');
        var $edit_role_id = $('#edit_role_id');


        $editRole.on('click', function (element) {
            element.preventDefault();

            var roleName = $(this).data('rolename');
            var role_id = $(this).data('roleid');

            $edit_role_name.val(roleName);
            $edit_role_id.val(role_id);

            $editWindow.modal('show');


        });



    });


</script>



@if(Session::has('message'))
<script>
    $(document).ready(function () {
        var $toast = $('.toast').toast({
            autohide: false
        });
        $toast.toast('show')
    });
</script>

@endif
@endsection



