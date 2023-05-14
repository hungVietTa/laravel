<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ancestor extends Model
{
    use HasFactory;

    public function spouse(): HasOne
    {
        return $this->hasOne(Ancestor::class);
    }

    public function spouses(): hasMany
    {
        return $this->hasMany(Ancestor::class,'spouse_id');
    }

    public function childs(): hasMany
    {
        return $this->hasMany(Ancestor::class,'parent_id');
    }

    public function parents(): hasMany
    {
        return $this->hasMany(Ancestor::class,'parent_id');
    }

    public function getHierachy()
    {

        return $this;
    }

    public function getChildrens()
    {
        if ($this->childs->isEmpty()){
            return [];
            }
        else
           {
            dd( $this->childs->map(fn($a) => $a->getHierachy()));
            return  $this->childs->map(fn($a) => $a->getHierachy());
           }
    }

    // attribute :childrens
    // attribute :partners

    // belongs_to :spouse, class_name: "Ancestor", dependent: nil, inverse_of: :spouses, optional: true
    // has_many :spouses, class_name: "Ancestor", dependent: nil, foreign_key: :spouse_id, inverse_of: :spouse
    // has_many :childs, class_name: "Ancestor", dependent: nil, foreign_key: :parent_id, inverse_of: :parent

    // belongs_to :parent, class_name: "Ancestor", optional: true, inverse_of: :childs

    # def parent
    #   return super if super

    #   return spouse.parent if spouse

    #   return nil
    # end

    # def nth
    #   return nth if nth

    #   return spouse.nth if spouse

    #   return nil
    # end

    protected $appends = ['childrens'];
}
