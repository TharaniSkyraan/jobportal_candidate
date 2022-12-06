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

        $user_id = empty($user_id)?Auth::user()->id:$user_id;
        $user = User::find($user_id);
        
        $html = '';

        if (isset($user) && count($user->userProjects)):

            $projectCounter = 0;

            foreach ($user->userProjects as $project):

                $date = '';
                
                
                if ($project->is_on_going == 1){

                    $date = $project->date_start != null ? Carbon::parse($project->date_start)->Format('M Y').' - Currently ongoing' : "Currently ongoing";

                }else{
                    $start_date = $project->date_start != null ? Carbon::parse($project->date_start)->Format('M Y')  : "";
                    $end_date = $project->date_end != null ? " - ".Carbon::parse($project->date_end)->Format('M Y')  : "";
                    $date = $start_date . $end_date;
                }

                // $image = ImgUploader::get_image("project_images/thumb/$project->image");

                $html .= '<!--Project Start-->
                         <div class="card page-inner mb-4 project_div project_edited_div_'.$project->id.'">
					        <div class="row">
                                <div class="col-md-8">
                                    <h4 class="text-green-color fw-bold">' . $project->name . '</h4>
                                </div>

                                <div class="col-md-3 d-flex justify-content-around">
                                    <div class="edit_project_'.$project->id.'"><a href="javascript:void(0);"><i class="fa-solid fa-pen-to-square text-green-color openForm" data-form="edit" data-id="'.$project->id.'"></i></a></div>';
                                    if(count($user->userProjects)>1){ 
                                        $html .= '<div class="delete_project delete_project_'.$project->id.'"><a href="javascript:void(0);"  onclick="delete_user_project(' . $project->id . ');"><i class="fa-solid fa-trash-can text-danger"></i></a></div>
                                        <div class="undo_project_'.$project->id.'" onclick="undo_user_project(' . $project->id . ');" style="display:none;"><a href="javascript:void(0);"><i class="fa-solid fa-arrow-rotate-left text-green-color border-0 rounded p-2" style="background-color:#6CD038;" ></i></a></div>'; 
                                    }
                                $html .= '</div>
                            </div>

                            <p>' . $project->getCompany('company') . '</p>
                            <p>' . ucwords($project->project_location) . ' Project </p>
                            <p>' . $project->getCity('city') . '</p>
                            <p>' . $date . '</p>

                            <div class="more-details-show-hide collapse" id="collapseproject'.$project->id.'">
                                <div class="mb-3">
                                    <label class="pb-2">Job Description</label><br>
                                    <text> '. $project->description .' </text>
                                </div>
                                <div class="mb-3">
                                    <label class="pb-2">Your role on the project </label><br>
                                    <text> '. $project->role_on_project .' </text>
                                </div>';
                                
                            if($project->used_tools!=null){
                                $html .='<div class="mb-3">
                                    <label class="pb-2">Tools / Software used</label><br>';
                                    foreach(array_filter(explode(',',$project->used_tools)) as $usedtools){$html .='<text class="tag">' . $usedtools . '</text>';}
                                $html .='</div>';
                            }
                            $html .='</div>

                            <div class="text-center mt-2 more-details-proj more-details-proj'.$project->id.'" onclick="collapsedProj('.$project->id.')">
                                <a class="text-green-color" id="more-details-button-proj" data-bs-toggle="collapse" href="#collapseproject'.$project->id.'" role="button" aria-expanded="false" aria-controls="collapseproject">More details 
                                <i class="fa-solid fa-chevron-down collapse-down-arrow-proj"></i> 
                                <i class="fa-solid fa-chevron-up collapse-up-arrow-proj" style="display:none;"></i></a>
                            </div>

                        </div>';

               
            endforeach;

        endif;



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



        $this->addUserProjectImage($request, $userProject);



        $returnHTML = view('admin.user.forms.project.project_thanks')->render();

        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);

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



        $this->addUserProjectImage($request, $userProject);



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

