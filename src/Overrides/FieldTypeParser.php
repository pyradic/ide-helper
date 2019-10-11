<?php

namespace Pyro\IdeHelper\Overrides;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

class FieldTypeParser extends \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser
{

    /**
     * Return the parsed relation.
     *
     * @param AssignmentInterface $assignment
     * @return string
     */
    public function relation(AssignmentInterface $assignment)
    {
        $type      = $assignment->getFieldType();
        $fieldSlug = $assignment->getFieldSlug();
        $fieldName = humanize($fieldSlug);
        $method    = camel_case($fieldSlug);

        $returnTag     = [ '\Illuminate\Database\Eloquent\Relations\Relation' ];
        $returnComment = '';
        if ($type instanceof MultipleFieldType) {
            $returnTag[] = '\Illuminate\Database\Eloquent\Relations\BelongsToMany';
            try {
                $relatedModel  = get_class($type->getRelatedModel());
                $returnComment = "// return \$this->belongsToMany(\\{$relatedModel}::class);";
            }
            catch (\Throwable $e) {
            }
        } elseif ($type instanceof RelationshipFieldType) {
            $returnTag[] = '\Illuminate\Database\Eloquent\Relations\BelongsTo';
            try {
                $relatedModel  = get_class($type->getRelatedModel());
                $returnComment = "// return \$this->belongsTo(\\{$relatedModel}::class);";
            }
            catch (\Throwable $e) {
            }
        }

        $returnTag = implode('|', $returnTag);

        return "
    /**
     * The {$fieldName} relation
     *
     * @return {$returnTag}
     */
    public function {$method}()
    {
        {$returnComment}
        return \$this->getFieldType('{$fieldSlug}')->getRelation();
    }
";
    }

}
