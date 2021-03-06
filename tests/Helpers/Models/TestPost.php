<?php
namespace Czim\DataStore\Test\Helpers\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TestPost
 *
 * @property integer $id
 * @property integer $genre_id
 * @property string $title
 * @property string $body
 */
class TestPost extends Model
{
    protected $fillable = ['title', 'body'];

    public function authors()
    {
        return $this->belongsToMany(TestAuthor::class);
    }

    public function comments()
    {
        return $this->hasMany(TestComment::class, 'test_post_id');
    }

    public function genre()
    {
        return $this->belongsTo(TestGenre::class, 'test_genre_id');
    }

    public function tags()
    {
        return $this->morphMany(TestTag::class, 'taggable');
    }

    
    public function someOtherRelationMethod()
    {
        return $this->belongsTo(TestGenre::class, 'test_genre_id');
    }

    public function commentHasOne()
    {
        return $this->hasOne(TestComment::class, 'test_has_one_post_id');
    }

    public function specials()
    {
        return $this->hasMany(TestSpecial::class, 'test_post_id');
    }

    public function tagMorphOne()
    {
        return $this->morphOne(TestTag::class, 'taggable');
    }

    public function morphTags()
    {
        return $this->morphToMany(TestTag::class, 'taggable', 'taggables');
    }

    public function unsupported()
    {
        return $this->hasManyThrough(TestTag::class, TestComment::class);
    }

    public function notARelation()
    {
        return $this;
    }
}
