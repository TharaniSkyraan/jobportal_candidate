{!! Form::model($userProject, array('method' => 'put', 'route' => array('update.project', [$userProject->id,$user->id]), 'class' => 'form', 'id' => 'add_edit_user_project')) !!}
{!! Form::hidden('id', $userProject->id) !!}            
@include('user.project.form') 
{!! Form::close() !!} 