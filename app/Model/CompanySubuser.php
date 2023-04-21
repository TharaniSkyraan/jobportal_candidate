<?php



namespace App\Model;

use App;

use App\Traits\Active;

use Illuminate\Database\Eloquent\Model;

class CompanySubuser extends Model
{

    use Active;

    protected $table = 'company_subusers';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'date_of_birth'];
   
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employer_role()
    {
        return $this->belongsTo(EmployerRole::class, 'recruiting_role', 'employer_role_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getEmployerRole($field = '')
    {
        if (null !== $employer_role = $this->employer_role()->first()) {
            if (!empty($field)) {
                return $employer_role->$field;
            } else {
                return $employer_role;
            }
        }
    }
    
}
