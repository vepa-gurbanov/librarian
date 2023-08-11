<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) {
        $orderConfig = config()->get('settings.ordering');
        $validation = $request->validate([
            'q' => ['nullable', 'string', 'max:50'],
            'f_min_price' => ['nullable', 'integer', 'min:0',],
            'f_max_price' => ['nullable', 'integer', 'max:' . Book::orderByDesc('price')->first()->price,],
            'ordering' => ['nullable', 'string', 'in:' . implode(',', array_keys($orderConfig)),],
            'pub' => ['nullable','array'], // authors => pub
            'pub.*' => ['nullable','array'], // authors[] => pub.*
            'pub.*.*' => ['nullable','integer','min:1','distinct'], // authors[][] => pub.*.*
            'au' => ['nullable','array'], // authors => au
            'au.*' => ['nullable','array'], // authors[] => au.*
            'au.*.*' => ['nullable','integer','min:1','distinct'], // authors[][] => au.*.*
            'c' => ['nullable','array'], // categories => c
            'c.*' => ['nullable','array'], // categories[] => c.*
            'c.*.*' => ['nullable','integer','min:1','distinct'], // categories[][] => c.*.*
            'v' => ['nullable', 'array'], // values => v
            'v.*' => ['nullable', 'array'], // values[] => v.*
            'v.*.*' => ['nullable', 'integer', 'min:1', 'distinct'], // values[][] => v.*.*


        ]);

        $q = $request->has('q') ? $validation['q'] : null;
        $f_min_price = $validation['f_min_price'] ?? null;
        $f_max_price = $validation['f_max_price'] ?? null;
        $f_order = $validation['ordering'] ?? null;
        $f_publishers = $request->has('pub') ? $request->pub : [];
        $f_authors = $request->has('au') ? $request->au : [];
        $f_categories = $request->has('c') ? $request->c : [];
        $f_values = $request->has('v') ? $request->v : [];
        $price = [
            'min' => $f_min_price ?? Book::orderBy('price')->first()->price,
            'max' => $f_max_price ?? Book::orderByDesc('price')->first()->price,
        ];
        $order = isset($f_order) ?  $orderConfig[$f_order] : null;

        $books = Book::when($q, function ($query) use ($q) {
            $query->where('name', 'like', '%' . $q . '%');
            $query->orWhere('full_name', 'like', '%' . $q . '%');
            $query->orWhere('slug', 'like', '%' . $q . '%');
            $query->orWhere('barcode', 'like', '%' . $q . '%');
            $query->orWhere('book_code', 'like', '%' . $q . '%');
        })->when(($f_min_price or $f_max_price), function ($query) use ($price) {
            $query->whereBetween('price', [$price['min'], $price['max']]);
        })
            ->when($order, function ($query, $order) {
                return $query->orderBy($order[0], $order[1]);
            }, function ($query) {
                return $query->orderByDesc('id');
            })
            ->when($f_publishers, function ($query, $f_publishers) {
                return $query->where(function ($query1) use ($f_publishers) {
                    foreach ($f_publishers as $f_publisher) {
                        $query1->whereHas('publishers', function ($query2) use ($f_publisher) {
                            $query2->whereIn('id', $f_publisher);
                        });
                    }
                });
            })
            ->when($f_authors, function ($query, $f_authors) {
                return $query->where(function ($query1) use ($f_authors) {
                    foreach ($f_authors as $f_author) {
                        $query1->whereHas('authors', function ($query2) use ($f_author) {
                            $query2->whereIn('id', $f_author);
                        });
                    }
                });
            })
            ->when($f_categories, function ($query, $f_categories) {
                return $query->where(function ($query1) use ($f_categories) {
                    foreach ($f_categories as $f_category) {
                        $query1->whereHas('categories', function ($query2) use ($f_category) {
                            $query2->whereIn('id', $f_category);
                        });
                    }
                });
            })
            ->when($f_values, function ($query, $f_values) {
                return $query->where(function ($query1) use ($f_values) {
                    foreach ($f_values as $f_value) {
                        $query1->whereHas('attributeValues', function ($query2) use ($f_value) {
                            $query2->whereIn('id', $f_value);
                        });
                    }
                });
            })
            ->orderByDesc('id')
            ->with('categories:id,slug,name')
            ->paginate(24, ['id', 'name', 'slug', 'price', 'page', 'liked', 'image'])
            ->withQueryString();

        $maxPrice = Book::orderByDesc('price')->first()->price;
        $searchCategories = Category::orderBy('id')
            ->get(['id', 'name']);

        $searchAuthors = Author::orderBy('id')
            ->get(['id', 'name']);

        $searchPublishers = Publisher::orderBy('id')
            ->get(['id', 'name']);

        $searchAttrs = Attribute::orderBy('sort_order')
            ->orderBy('id')
            ->with('values:id,attribute_id,name')
            ->get(['id', 'name']);


        $data = [
            'q' => $q,
            'f_min_price' => $f_min_price,
            'f_max_price' => $f_max_price,
            'f_order' => $f_order,
            'f_categories' => collect($f_categories),
            'f_publishers' => collect($f_publishers),
            'f_authors' => collect($f_authors),
            'f_values' => collect($f_values)->collapse(),
            'maxPrice' => $maxPrice,
            'searchCategories' => $searchCategories,
            'searchAuthors' => $searchAuthors,
            'searchPublishers' => $searchPublishers,
            'searchAttrs' => $searchAttrs,
            'orderConfig' => $orderConfig,

            'books' => $books,
        ];

        return view('reader.book.index')
            ->with($data);
    }

    public function show(string $slug) {
        $book = Book::where('slug', $slug)
            ->with('ratedReaders', 'attributeValues.attribute', 'options', 'reviews.reader', 'notes.reader')->first();

        $data = [
            'book' => $book,
        ];

//        return $book->notes->count();

        return view('reader.book.show')->with($data);
    }


    public function rate($id, $rating): \Illuminate\Http\RedirectResponse|JsonResponse
    {
        if (!auth('reader')->check()) {
            return response()->json(['error' => 'needs-authentication'], 403);
        }

        try {
            $book = Book::findOrFail($id);
            $book->rate(id: auth('reader')->id(), rating: $rating);
            return response()->json(['success' => 'Rating succeed']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function reviewAndNote(Request $request, $slug): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'review' => ['sometimes', 'string', 'max:2550'],
            'note' => ['sometimes', 'string', 'max:2550'],
        ]);

        try {
            Review::create([
                'book_id' => Book::query()->where('slug', $slug)->firstOrFail()->id,
                'reader_id' => auth('reader')->id(),
                'review' => $request->has('review') ? $request->review : null,
                'note' => $request->has('note') ? $request->note : null,
            ]);
            return back()->with('success', $request->has('note') ? 'note' : 'review' . ' added!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
