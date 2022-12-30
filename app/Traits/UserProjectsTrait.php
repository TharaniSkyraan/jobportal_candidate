<?php



namespace App\Traits;



use File;

use ImgUploader;

use Auth;

use DB;

use Input;

use Carbon\Carbon;

use Redirect;

use App\Model\User;

use App\Model\UserProject;

use App\Http\Requests;

use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\User\UserProjectFormRequest;

use App\Http\Requests\User\UserProjectImageFormRequest;

use Illuminate\Support\Str;

use App\Helpers\DataArrayHelper;



trait UserProjectsTrait

{

    public function showFrontUserProjects(Request $request, $user_id=null)
    {
        $user = Auth::user();
        $html = '';
        if (isset($user) && count($user->userProjects)){
            $html = view('user.project.projectslist')->render();
        
            echo $html;exit();
        }
        echo $html;

    }


    public function getFrontUserProjectForm(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $session_id = session()->getId();

        session()->forget($session_id . 'temp.project_images');
        $countries = DataArrayHelper::CountriesArray();
        
        $experience_companies = DataArrayHelper::userExperiencedCompaniesArray($user_id);

        $user = User::find($user_id);

        $returnHTML = view('user.project.add')->with(['user' => $user,'countries'=>$countries,'experience_companies'=>$experience_companies])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));

    }
    
    public function storeFrontUserProject(UserProjectFormRequest $request, $user_id=null)
    {


        $user_id = empty($user_id)?Auth::user()->id:$user_id;

        $userProject = new UserProject();

        $userProject = $this->assignProjectValues($userProject, $request, $user_id);

        $userProject->save();

        return response()->json(array('success' => true, 'status' => 200), 200);

    }

    private function assignProjectValues($userProject, $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userProject->user_id = $user_id;

        $userProject->name = $request->input('name');

        $userProject->user_experience_id = $request->input('user_experience_id');

        $userProject->url = $request->input('url');

        $userProject->date_start = $request->input('date_start');

        $userProject->date_end = $request->input('date_end');

        $userProject->is_on_going = $request->input('is_on_going');

        $userProject->noof_team_member = $request->input('noof_team_member');

        $userProject->work_as_team = $request->input('work_as_team');

        $userProject->project_location = $request->input('project_location');

        $userProject->country_id = $request->input('country_id_dd');

        $userProject->state_id = $request->input('state_id_dd');

        $userProject->city_id = $request->input('city_id_dd');

        $userProject->role_on_project = $request->input('role_on_project');

        $userProject->description = $request->input('description');
        
        $userProject->used_tools = $request->input('used_tools');

        return $userProject;

    }


    public function getFrontUserProjectEditForm(Request $request, $user_id=null)
    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $session_id = session()->getId();

        session()->forget($session_id . 'temp.project_images');

        $project_id = $request->input('project_id');

        $userProject = UserProject::find($project_id);

        $user = User::find($user_id);

        $countries = DataArrayHelper::CountriesArray();
        
        $experience_companies = DataArrayHelper::userExperiencedCompaniesArray($user_id);

        $user = User::find($user_id);

        $returnHTML = view('user.project.edit')

                ->with('user', $user)

                ->with('userProject', $userProject)

                ->with('countries', $countries)

                ->with('experience_companies', $experience_companies)

                ->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));

    }




    public function updateFrontUserProject(UserProjectFormRequest $request, $project_id, $user_id=null)

    {


        $user_id = empty($user_id)?Auth::user()->id:$user_id;

        $userProject = UserProject::find($project_id);

        $userProject = $this->assignProjectValues($userProject, $request, $user_id);

        $userProject->update();



        // $this->addUserProjectImage($request, $userProject);



        // $returnHTML = view('user.forms.project.project_edit_thanks')->render();

        return response()->json(array('success' => true, 'status' => 200, 'html' => ''), 200);

    }




    public function deleteAllUserProjects($user_id=null)

    {

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $userProjects = UserProject::where('user_id', '=', $user_id)->get();

        foreach ($userProjects as $userProject) {

            echo $this->removeUserProject($userProject->id);

        }

    }

    public function deleteUserProject(Request $request)
    {
        $id = $request->input('id');
        try {
                UserProject::find($id)->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function undoUserProject(Request $request)
    {
        $id = $request->input('id');
        try {
                UserProject::withTrashed()->find($id)->restore();
            return 'ok';

        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }



    private function removeUserProject($id)

    {

        try {

            // $this->deleteUserProjectImage($id);

            $userProject = UserProject::findOrFail($id);

            $userProject->delete();

            return 'ok';

        } catch (ModelNotFoundException $e) {

            return 'notok';

        }

    }



}

