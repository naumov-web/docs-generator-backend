<?php

namespace App\Models;

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
final class DocumentTemplate extends BaseModel
{
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
