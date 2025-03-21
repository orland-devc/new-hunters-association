<?php

namespace App\Models\Traits;

use App\Support\Segment;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait SegmentAble
{
    /**
     * Magic method to handle dynamic property access.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists(self::class, 'getSegmentColumn') && $name === $this->getSegmentColumn()) {
            return $this->segment;
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (method_exists(self::class, 'getSegmentColumn') && $name === 'segment') {

            $name = $this->getSegmentColumn();
            $value = Segment::toRaw($value);
        }

        return parent::__set($name, $value);
    }

    /**
     * Overwrite the segment if custom implementation is needed.
     */
    protected function segment(): Attribute
    {
        $column = $this->getSegmentColumn();

        return Attribute::make(
            get: function () use ($column) {
                return Segment::toDisplay($this->attributes[$column]);
            },
            set: function (string $value) use ($column) {
                $this->attributes[$column] = Segment::toRaw($value);
            }
        );
    }

    public static function bootSegmentAble()
    {
        static::saving(function ($model) {
            $model->segment = Segment::toRaw($model->segment);
        });
    }
}
