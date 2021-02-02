<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
    <style>
        .user-table {
            width: 100%;
        }

        .user-table th {
            font-weight: 500;
        }
    </style>
</head>
<body class="gray">
<div id="wrapper">
    @include('partials.admin-header')
    <div class="clearfix"></div>
    <div class="dashboard-container">
        @include('partials.admin-sidebar')
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">
                <!-- start content -->
                <div class="dashboard-headline">
                    <h3>Users Management</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Users</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboard-box">
                            <div class="headline d-flex justify-content-between">
                                <h3><i class="icon-line-awesome-users"></i>Users</h3>
                                <div class="headline-actions" style="min-width: 250px;">
                                    <form>
                                        <select class="selectpicker" name="role" id="select-role">
                                            <option value="">All Users</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" @if($role->name == $query_role) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                            <option value="trashed">Deleted Users</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="content" style="padding: 20px 30px">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>City</th>
                                            <th>Status</th>
                                            <th>Roles</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone_number }}</td>
                                                <td>@foreach($user->cities as $user_city) {{ $user_city->name }} @endforeach</td>
                                                <td>
                                                    @if($user->hasVerifiedEmail())
                                                        <span class="badge badge-success">Email Verified</span>
                                                    @else
                                                        <span class="badge badge-danger">Unverified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach($user->roles as $user_role)
                                                        @if($user_role->slug == 'admin')
                                                            <span class="badge badge-info">{{ $user_role->name }}</span>
                                                        @elseif($user_role->slug == 'customer')
                                                            <span class="badge badge-primary">{{ $user_role->name }}</span>
                                                        @elseif($user_role->slug == 'driver')
                                                            <span class="badge badge-secondary">{{ $user_role->name }}</span>
                                                        @elseif($user_role->slug == 'unverified')
                                                            <span class="badge badge-danger">{{ $user_role->name }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $user_role->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $user->created_at->format('Y.m.d') }}
                                                </td>
                                                <td>
                                                    {{ $user->updated_at->format('Y.m.d') }}
                                                </td>
                                                <td nowrap="">
                                                    @if($user->trashed())
                                                        <a href="{{ route('deleted-users.show', ['deleted_user' => $user->id]) }}" class="btn btn-outline-secondary">
                                                            <i class="icon-line-awesome-eye"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-outline-secondary">
                                                            <i class="icon-line-awesome-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#delete-modal"><i class="icon-line-awesome-train"></i></button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end content -->
                <div class="dashboard-footer-spacer"></div>
                @include('partials.admin-footer')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Delete User</h3>
            </div>
            <div class="modal-body">
                Are you sure to delete this user?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="confirm-delete">Delete</button>
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.4.1/js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    $('#select-role').change(function () {
        $(this).closest('form').submit();
    });
    $('#delete-modal').on('show.bs.modal', function (e) {
        let form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm-delete').data('form', form);
    });
    $('#delete-modal').find('.modal-footer #confirm-delete').on('click', function(){
        $(this).data('form').submit();
    });
</script>
@include('scripts.pusher-notification')
<script>
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function() {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',
            backgroundColor: '#383838'
        });
    });
</script>
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
@if(session('success'))
    <script>
        $('document').ready(function () {
            Snackbar.show({
                text: '{{ session('success') }}',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        });
    </script>
@endif
</body>
</html>
