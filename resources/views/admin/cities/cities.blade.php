@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cities</div>
                <div class="card-body">
                    <div class="row">
                        @foreach( $cities as $city )
                        <div class="col-md-3">
                            <div class="alert alert-primary" role="alert">
                                <h5> {{ $city->name  }} </h5>
                                <p> State : {{ $city->state->name }} </p>
                                <p> Country : {{ $city->country ->name }} </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $cities->links() }}
                </div>
            </div>
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



