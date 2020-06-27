<table class="table table-inverse table-hover">
    <thead>
    <tr>
      <th width='10'>No</th>
      {{--  <th width='10'></th>  --}}
      <th width='30'>Name</th>
      <th width='30'>Email</th>
      <th width='20'>Roles</th>
      <th width='50'>Address</th>
      <th width='50'>Tell</th>
    </tr>
</thead>
<tbody>
    @foreach ($data as $key => $user)
     <tr>
       <td>{{ ++$i }}</td>
       {{--  <td><img src="{{URL::asset(user_photo($user->id))}}" /></td>  --}}
       <td>{{ $user->name }}</td>
       <td>{{ $user->email }}</td>
       <td>
         @if(!empty($user->getRoleNames()))
           @foreach($user->getRoleNames() as $v)
              <label class="badge badge-success">{{ $v }}</label>
           @endforeach
         @endif
       </td>
       <td>{{ $user->address }}</td>
       <td>{{ $user->tell }}</td>
     </tr>
    @endforeach
    </tbody>
   </table>
