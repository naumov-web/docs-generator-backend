<?php

namespace App\Models;

use App\Models\Contracts\IHasOwner;
use App\Models\Traits\HasOwner;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class DocumentTemplate
 * @package App\Models
 *
 * @property-read int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $name
 *
 * @property File $file
 */
final class DocumentTemplate extends BaseModel implements IHasOwner
{
    use HasOwner;

    /**
     * File relation
     *
     * @return MorphOne
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'owner');
    }
}
