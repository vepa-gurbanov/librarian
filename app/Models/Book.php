<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id', 'reader_id'];

    public $translatable = ['name', 'full_name', 'body', 'description'];

    protected $casts = [
        'written_at' => 'date',
        'published_at' => 'date',
    ];


    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str($obj->getTranslation('name', 'en'))->slug('_') . '_b:' . $obj->id . '_' . Str::random(8);
            $obj->full_name = implode(", ", $obj->authors()->pluck('name')->toArray()) . ' ' . $obj->name . ' (' . date_format($obj->written_at, 'Y') . ')';
            $obj->barcode = mt_rand(10000000, 99999999);
            $obj->book_code = strval(date_format(now(), 'Ymd')) . mt_rand(10, 99) . str_pad($obj->id, 4, '0', STR_PAD_LEFT);
        });
    }


    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }


    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }


    public function publishers(): BelongsToMany
    {
        return $this->belongsToMany(Publisher::class, 'book_publishers');
    }


    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'book_attribute_values')
            ->orderByPivot('sort_order');
    }


//    public function registrations()
//    {
//        return $this->hasMany(Registration::class);
//    }


    public function image(): string
    {
        return asset('img/book.jpg');
//        return $this->image
//            ? Storage::url('books/' . $this->id . '/' . $this->image)
//            : asset('assets/img/book.jpg');
    }


//    public function available(): bool
//    {
//        return $this->registrations()
//            ->where('reader_status', 'reading')
//            ->exists();
//    }
}
