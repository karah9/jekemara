<?php

namespace App\Models;

use Egulias\EmailValidator\Parser\CommentStrategy\LocalComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Alimentation extends Model

{
    use BelongsToThrough;
    use HasFactory;
    protected $guarded = [];

    public function pdc(){
        return $this->belongsTo(Pdc::class);
    }
    public function aliment(){
        return $this->belongsTo(Pdc::class);
    }
}
