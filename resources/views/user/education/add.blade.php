{!! Form::open(array('method' => 'post', 'route' => array('store.education.form', $user->id), 'class' => 'form', 'id' => 'add_edit_user_education', 'onSubmit' => 'return validateAccountForm()')) !!}
@include('user.education.form') 
{!! Form::close() !!}