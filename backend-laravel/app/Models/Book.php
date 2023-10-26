<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use Searchable;
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'author','publisher','description','genre','isbn','published'
    ];

    /**
     * The "booted" method of the model.
     * Auto generating uuid
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->title,
            'title' => $this->title,
            'author' => $this->author,
            'publisher' => $this->content,
            'genre' => $this->content,
            'isbn' => $this->content,
            'published' => $this->updated_at,
        ];
    }

}