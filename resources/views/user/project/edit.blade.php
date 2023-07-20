{!! Form::model($userProject, array('method' => 'put', 'route' => array('update.project', [$userProject->id,$user->id]),  'id' => 'add_edit_user_project')) !!}
{!! Form::hidden('id', $userProject->id) !!}            
@include('user.project.form') 
{!! Form::close() !!} 