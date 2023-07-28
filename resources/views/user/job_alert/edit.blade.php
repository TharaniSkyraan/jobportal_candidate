{!! Form::model($jobAlert, array('method' => 'put', 'route' => array('update.job-alert', [$jobAlert->id,$user->id]),  'id' => 'add_edit_user_job_alert')) !!}
{!! Form::hidden('id', $jobAlert->id) !!}            
@include('user.job_alert.form') 
{!! Form::close() !!}