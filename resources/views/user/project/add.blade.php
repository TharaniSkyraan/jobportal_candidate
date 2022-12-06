{!! Form::open(array('method' => 'post', 'route' => array('store.project', $user->id), 'class' => 'form', 'id' => 'add_edit_user_project')) !!}
@include('user.project.form') 
{!! Form::close() !!}