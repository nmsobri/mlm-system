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
        <p>Heir Name:{{$user->heir_name}}</p>
        <p>Heir Contact Number:{{$user->heir_contact_num}}</p>
        <p>Bank Account:{{$user->bank_account}}</p>
        <p>Account Number:{{$user->account_num}}</p>
        <p>Upline Username:{{$user->upline_username}}</p>
        <p>Upline Full Name:{{$user->upline_fullname}}</p>
        <hr/>

    @endforeach

@else

    No users

@endif