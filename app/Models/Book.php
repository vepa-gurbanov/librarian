<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{
    use HasFactory, HasTranslations;

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


    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
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
        return $this->belongsToMany(Publisher::class, 'book_publishers')
            ->withPivot('published_country_' . app()->getLocale());
    }


    public function publishedCountries(): array
    {
        $book = Book::where('id', $this->id)
            ->with('publishers')
            ->first(['id', 'name', 'slug']);
        $array = [];
        foreach ($book->publishers as $publisher) {
            $array[] = $publisher->pivot['published_country_' . app()->getLocale()];
        }

        return array_unique($array);
    }


    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'book_attribute_values')
            ->orderByPivot('sort_order');
    }


    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }


    public function options(): HasMany
    {
        return $this->hasMany( Option::class);
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)
            ->whereNotNull('review')
            ->orderByDesc('id');
    }


    public function notes(): HasMany
    {
        return $this->hasMany(Review::class)
            ->where('reader_id', auth('reader')->id())
            ->whereNotNull('note')
            ->orderByDesc('id');
    }


    public function ratedReaders(): BelongsToMany
    {
        return $this->belongsToMany(Reader::class, 'book_ratings')
            ->withPivot('rating');
    }


    public function ratedReader($id): ?bool
    {
        return isset($id) ?
            Reader::query()
                ->where('id', $id)
                ->whereHas('ratedBooks', function (Builder $query) {
                    $query->where('book_id', $this->id);
                })->exists()
            : null;
    }


    public function averageRating() {
        return DB::table('book_ratings')
            ->where('book_id', $this->id)
            ->average('rating') ?? number_format(0, '1');
    }


    public function totalRatings() {
        return DB::table('book_ratings')
            ->where('book_id', $this->id)
            ->sum('rating');
    }


    public function rating($id) {
        return DB::table('book_ratings')
            ->where('book_id', $this->id)
            ->where('reader_id', $id)
            ->first('rating')->rating ?? number_format(0, '1');
    }


    public function rate($id, $rating): bool
    {
        return DB::table('book_ratings')
            ->where('book_id', $this->id)
            ->updateOrInsert(
                [
                    'book_id' => $this->id,
                    'reader_id' => $id,
                ],
                ['rating' => $rating]
            );

    }


    public function image(): string
    {
        return $this['image']
            ? Storage::url('books/' . $this->id . '/' . $this->image)
            : asset('img/book.jpg');
    }


    public function available(): bool
    {
        return $this->registrations()
            ->where('reader_status', 'reading')
            ->exists();
    }


    public function setOptions($type, $format, $price, $source)
    {
        return DB::table('options')->updateOrInsert([
            'book_id' => $this->id,
            'type' => $type,
        ], [
            'format' => $format,
            'price' => $price,
            'source' => $source,
        ]);
    }


//    public function putOptions($type, array $val) {
//        foreach (json_decode($this->options) as $key => $option) {
//            if ($this->option->->type === $type) {
//                if (isset($val['src'])) $option->src = $val['src'];
//                if (isset($val['price'])) $option->price = $val['price'];
//                $this->update();
//            }
//        }
//        return $this->update();
//    }

}
