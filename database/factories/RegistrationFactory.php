<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Book;
use App\Models\Reader;
use App\Models\ReaderBank;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Registration $registration) {
            //
        })->afterCreating(function (Registration $registration) {
            $payment = $registration->payment_type;
            $price = $registration->book->reader_id
                ? $registration->book->price / 2
                : $registration->book->price;


            if ($registration->returned_at)
            {
                $total = Carbon::parse($registration->took_at)->diffInDays($registration->returned_at);
                $registration->total_price = $total * $price;
                $registration->update();
            }


            $bank = Bank::create([
                'registration_id' => $registration->id,
                'electron' => $payment !== 'cash' ? $price : 0,
                'cash' => $payment == 'cash' ? $price : 0,
                'created_at' => now(),
            ]);


            if ($registration->book->reader_id)
            {
                ReaderBank::create([
                    'bank_id' => $bank->id,
                    'reader_id' => $registration->book->reader_id,
                    'electron' => $payment !== 'cash' ? $price : 0,
                    'cash' => $payment == 'cash' ? $price : 0,
                    'created_at' => now(),
                ]);
            }
        });
    }


    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $reader = Reader::inRandomOrder()->first();
        $book = Book::inRandomOrder()->first();
        $took = now()->subDays(rand(1,20));
        $rand = $took->addDays(rand(1,20));
        $returned = $rand < now() ? $rand : null;
        return [
            'user_id' => $user->id,
            'reader_id' => $reader->id,
            'book_id' => $book->id,
            'price' => $book->price,
            'took_at' => $took,
            'returned_at' => $rand,
            'reader_status' => $returned ? 'completed' : 'reading',
            'book_status' => 'good',
            'cash_flowed' => (bool)$returned,
            'payment_type' => Arr::random(['online', 'terminal', 'cash']),
            'created_at' => $took,
        ];
    }
}
