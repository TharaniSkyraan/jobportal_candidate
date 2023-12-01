{!! Form::open(array('method' => 'post', 'route' => array('store.job-alert', $user->id),  'id' => 'add_edit_user_job_alert',)) !!}
@include('user.job_alert.form') 
{!! Form::close() !!}