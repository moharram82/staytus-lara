<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemMenu extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_menu';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
