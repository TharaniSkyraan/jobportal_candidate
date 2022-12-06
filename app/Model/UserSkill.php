<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSkill extends Model
{

    use SoftDeletes;
    
    protected $table = 'user_skills';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getUser($field = '')
    {
        if (null !== $user = $this->user()->first()) {
            if (empty($field))
                return $user;
            else
                return $user->$field;
        } else {
            return '';
        }
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }

    public function getSkill($field = '')
    {
        $skill = $this->skill()->lang()->first();
        if (null === $skill) {
            $skill = $this->skill()->first();
        }
        if (null !== $skill) {
            if (empty($field))
                return $skill;
            else
                return $skill->$field;
        } else {
            return '';
        }
    }

    public function level()
    {
        return $this->belongsTo(LanguageLevel::class, 'level_id', 'language_level_id');
    }

    public function getLevel($field = '')
    {
        $level = $this->level()->lang()->first();
        if (null === $level) {
            $level = $this->level()->first();
        }
        if (null !== $level) {
            if (empty($field))
                return $level;
            else
                return $level->$field;
        } else {
            return '';
        }
    }

    // public function experience()
    // {
    //     return $this->belongsTo(Experience::class, 'experience_id', 'experience_id');
    // }

    // public function getExperience($field = '')
    // {
    //     $experience = $this->experience()->lang()->first();
    //     if (null === $experience) {
    //         $experience = $this->experience()->first();
    //     }
    //     if (null !== $experience) {
    //         if (empty($field))
    //             return $experience;
    //         else
    //             return $experience->$field;
    //     } else {
    //         return '';
    //     }
    // }

}
