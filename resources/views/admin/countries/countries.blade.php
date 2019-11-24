@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Countries</div>

                <div class="card-body">

                    <form action="{{ route('countries') }}" method="post" class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="country_name">Country Name </label>
                            <input type="text" class="form-control" id="country_name" name="country_name"
                                   placeholder="Country Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="capital_name">Capital Name </label>
                            <input type="text" class="form-control" id="capital_name" name="capital_name"
                                   placeholder="Capital Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save New Country</button>
                        </div>

                    </form>

                    <div class="row">
                        @foreach($countries as $country)
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">
                                <span class="buttons-span">
                                 <span><a class="edit-unit"
                                          data-countryname="{{ $country->name }}"
                                          data-capitalname="{{ $country->capital }}"
                                          data-countryid="{{ $country->id }}"><i class="fas fa-edit"></i></a></span>
                                <span><a class="delete-unit"
                                         data-countryname="{{ $country->name }}"
                                         data-capitalname="{{ $country->capital }}"
                                         data-countryid="{{ $country->id }}"><i class="fas fa-trash-alt"></i></a></span>
                                </span>
                                <p>{{$country->name}}</p>
                                <p>Currency: {{$country->currency}}</p>
                                <p>Capital: {{$country->capital}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ ( ! is_null($showLinks) && $showLinks) ? $countries->links() : '' }}

                    <form action="{{ route('search-countries') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="country_search" name="country_search"
                                       placeholder="Search Country" required>
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
    <form action="{{ route('countries') }}" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Countries</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="edit_country_name">Country Name </label>
                        <input type="text" class="form-control"
                               id="edit_country_name" name="country_name" placeholder="Country Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="edit_capital_name">Capital Name </label>
                        <input type="text" class="form-control"
                               id="edit_capital_name" name="capital_name" placeholder="Capital Name" required>
                    </div>

                    <input type="hidden" name="country_id" id="edit_country_id">
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
                <h5 class="modal-title">Delete Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('countries') }}" method="post">
                <div class="modal-body">
                    <p id="delete-message"></p>
                    @csrf
                    <input type="hidden" name="_method" value="delete"/>
                    <input type="hidden" name="country_id" value="" id="country_id">
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
        <strong class="mr-auto">Country</strong>
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
        var $countryID = $('#country_id');
        var $deleteMessage = $('#delete-message');


        $deleteUnit.on('click', function (element) {
            element.preventDefault();
            var country_id = $(this).data('countryid');
            $countryID.val(country_id);
            $deleteMessage.text(' Are you sure you want to delete this country');
            $deleteWindow.modal('show');

        });


        var $editCountry = $('.edit-unit');
        var $editWindow = $(' #edit-window');

        var $edit_country_name = $('#edit_country_name');
        var $edit_capital_name = $('#edit_capital_namw');
        var $edit_country_id = $('#edit_country_id');


        $editCountry.on('click', function (element) {
            element.preventDefault();

            var countryName = $(this).data('countryname');
            var capitalName = $(this).data('capitalname');
            var country_id = $(this).data('countryid');

            $edit_country_name.val(countryName);
            $edit_capital_name.val(capitalName);
            $edit_country_id.val(country_id);

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



