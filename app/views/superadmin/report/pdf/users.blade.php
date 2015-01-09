@if( count( $users ) > 0 )

    @foreach( $users as $user )

        <p>Username:{{$user->username}}</p>
        <p>Status:{{$user->status}}</p>
        <p>Group:{{$user->groups}}</p>
        <p>Last Login:{{$user->last_login}}</p>
        <p>Full Name:{{$user->full_name}}</p>
        <p>Ic Number:{{$user->ic_num}}</p>
        <p>Gender:{{$user->gender}}</p>
        <p>Contact Number:{{$user->contact_num}}</p>
        <p>Picture:{{$user->picture}}</p>
        <p>Appointed Date:{{$user->contact_num}}</p>

        @if( !is_null( $user->super_admin_username ) )

            <p>Superadmin Username:{{$user->super_admin_username}}</p>
            <p>Superadmin Full Name:{{$user->super_admin_fullname}}</p>

        @endif

        <hr/>

    @endforeach

@else

    No users

@endif