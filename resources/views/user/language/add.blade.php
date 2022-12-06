{!! Form::open(array('method' => 'post', 'route' => array('store.languages', $user->id), 'class' => 'form', 'id' => 'add_edit_user_language')) !!}
@include('user.language.form') 
{!! Form::close() !!}