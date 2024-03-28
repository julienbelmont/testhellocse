<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Statut;

class Profil extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'image',
        'statut',
    ];


    /**
     * The symbole chimie for this analyse chimique.
     */
    public function statut(): HasOne
    {
        return $this->hasOne(Statut::class, 'statut', 'statut');
    }

    public function getStatutAttribute()
    {
        return $this->attributes['statut'] = Statut::where('statut', '=', $this->attributes['statut'])->first()->libelle;
    }
}
