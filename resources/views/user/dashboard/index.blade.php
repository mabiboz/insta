@extends("layouts.user.user")
@section("bottom_js")
    <script>

        $('#accept').click(function () {
            $("#btnAccept").toggle();
        });

    </script>

    <style>
        .panel{
            background-color: #595B5D;
        }
    </style>
@endsection

@section("top_js")
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

@endsection

@section("content")


    @if(checkUserStatus())
        @if(checkUserVerifiedAndAcceptRule())
            @include("user.dashboard.sections.dashboardContent")
        @elseif(checkUserVerifiedAndNotAcceptRule())
            @include("user.dashboard.sections.acceptRule")
        @else
            @include("user.dashboard.sections.activationCard")

        @endif
    @else
        <p class="alert alert-danger">پنل کاربری شما در حالت معلق قرار دارد !</p>
    @endif


@endsection

