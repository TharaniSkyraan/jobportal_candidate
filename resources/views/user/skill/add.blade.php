{!! Form::open(array('method' => 'post', 'route' => array('store.skill', $user->id),  'id' => 'add_edit_user_skill')) !!}
@include('user.skill.form') 
{!! Form::close() !!}