<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            ['Aşgabat', 'Ashgabat', [
                ['Arzuw', null, 15],
                ['Atatürk köç', 'Ataturk street', 15],
                ['Arçabil şaýoly', 'Archabil shayoly', 15],
                ['Bagyr', null, 15],
                ['Berzeňňi', 'Berzenni', 15],
                ['Bekrewe', null, 15],
                ['Bedew', null, 15],
                ['Bitarap Türkmenistan şaýoly (Podwoýski köçe)', 'Bitarap Turkmenistan shayoly (Podwoyski street)', 15],
                ['Büzmeýin', 'Buzmeyin', 15],
                ['Büzmeýin GRES', 'Buzmeyin GRES', 15],
                ['Çandybil şaýoly', 'Chandybil shayoly', 15],
                ['1 mkr', null, 15],
                ['2 mkr', null, 15],
                ['3 mkr', null, 15],
                ['4 mkr', null, 15],
                ['5 mkr', null, 15],
                ['6 mkr', null, 15],
                ['7 mkr', null, 15],
                ['8 mkr', null, 15],
                ['9 mkr', null, 15],
                ['10 mkr', null, 15],
                ['11 mkr', null, 15],
                ['30 mkr', null, 15],
                ['Howdan "A"', null, 15],
                ['Howdan "B"', null, 15],
                ['Howdan "W"', null, 15],
                ['Türkmenbaşy şaýoly', 'Turkmenbashy shayoly', 15],
                ['Aýtakow (Oguzhan köç)', 'Aytakow (Oguzhan street)', 15],
                ['14-nji tapgyr (Sowhozny köç)', '14-th stage (Sowhozny street)', 15],
                ['15-nji tapgyr', '15-th stage', 15],
                ['Moskowskiý köç. (10 ýyl Abadançylyk şaýoly)', 'Moskowsky street. (10 years of Abadanchylyk shayoly)', 15],
                ['Nebitgaz (Andalib-Ankara köç.)', 'Nebitgaz (Andalib-Ankara street)', 15],
                ['Olimpiýa şäherçesi', 'Olympic town', 15],
                ['Sowetskiý köç. (Garaşsyzlyk şaýoly)', 'Sovetsky street (Garashsyzlyk shayoly)', 15],
                ['Garadamak', null, 15],
                ['Garadamak Şor', 'Garadamak Shor', 15],
                ['Gökje', 'Gokje', 15],
                ['G.Kuliýew köç. (Obýezdnoý)', 'G.Kuliyew street (Obyezdnoy)', 15],
                ['Gurtly', null, 15],
                ['Dosaaf', null, 15],
                ['Kim raýon', 'Kim rayon', 15],
                ['Köpetdag şaýoly', 'Kopetdag shayoly', 15],
                ['Köşi', 'Koshi', 15],
                ['Parahat 1', null, 15],
                ['Parahat 2', null, 15],
                ['Parahat 3', null, 15],
                ['Parahat 4', null, 15],
                ['Parahat 5', null, 15],
                ['Parahat 6', null, 15],
                ['Parahat 7', null, 15],
                ['Parahat 8', null, 15],
                ['Gagarin köç, köne Howa menzili', 'Gagarin street, Old airport', 15],
                ['Gypjak', null, 15],
                ['Ruhabat (90-njy razýezd)', 'Ruhabat (90-th resolution)', 15],
                ['Täze zaman', 'Taze zaman', 15],
                ['Çoganly', 'Choganly', 15],
                ['Hitrowka', 'Hitrowka', 15],
                ['Herrikgala', 'Herrikgala', 15],
                ['Şor daça', 'Shor dacha', 15],
                ['Ýalkym', 'Yalkym', 15],
                ['Ýanbaş', 'Yanbash', 15],
            ]],
            ['Ahal', 'Akhal', [
                ['Ak bugdaý etraby', 'Ak bugday district', 30],
                ['Ýaşlyk', 'Yashlyk', 30],
                ['Bäherden', 'Baherden', 30],
                ['Babadaýhan', 'Babadayhan', 30],
                ['Gökdepe', 'Gokdepe', 30],
                ['Kaka', null, 30],
                ['Änew', 'Anew', 30],
                ['Tejen', null, 30],
                ['Sarahs', null, 30],
            ]],
            ['Balkan', 'Balkan', [
                ['Magtymguly', null, 40],
                ['Bereket', null, 40],
                ['Etrek', null, 40],
                ['Esenguly', null, 40],
                ['Gumdag', null, 40],
                ['Balkanabat', null, 40],
                ['Garabogaz', null, 40],
                ['Hazar', null, 40],
                ['Serdar', null, 40],
                ['Türkmenbaşy', 'Turkmenbashy', 40],
                ['Jebel', null, 40],
            ]],
            ['Mary', 'Mary', [
                ['Ýolöten', 'Yoloten', 30],
                ['Murgap', null, 30],
                ['Mary', null, 30],
                ['Sakarçäge', 'Sakarchage', 30],
                ['Serhetabat (Guşgy)', 'Serhetabat (Gushgy)', 30],
                ['Tagtabazar', null, 30],
                ['Türkmengala', 'Turkmengala', 30],
                ['Oguz han', null, 30],
                ['Şatlyk', 'Shatlyk', 30],
                ['Baýramaly', 'Bayramaly', 30],
                ['Wekilbazar', null, 30],
                ['Garagum etraby', 'Garagum district', 30],
            ]],
            ['Lebap', 'Lebap', [
                ['Darganata', null, 50],
                ['Farap', null, 50],
                ['Gazojak', null, 50],
                ['Dänew', 'Danew', 50],
                ['Türkmenabat', 'Turkmenabat', 50],
                ['Garabekewül', 'Garabekewul', 50],
                ['Dostluk', null, 50],
                ['Hojombaz', null, 50],
                ['Köýtendag', 'Koytendag', 50],
                ['Magdanly', null, 50],
                ['Kerki', null, 50],
                ['Sakar', null, 50],
                ['Saýat', 'Sayat', 50],
                ['Seýdi', 'Seydi', 50],
                ['Çärjew', 'Charjew', 50],
                ['Halaç', 'Halach', 50],
            ]],
            ['Daşoguz', 'Dashoguz', [
                ['Akdepe', null, 50],
                ['Gurbansoltan Eje', null, 50],
                ['Boldumsaz', null, 50],
                ['Daşoguz', 'Dashoguz', 50],
                ['Gubadag', null, 50],
                ['Görogly (Tagta)', 'Gorogly (Tagta)', 50],
                ['Türkmenbaşy etraby ', 'Turkmenbashy district', 50],
                ['Ruhubelent etraby', 'Ruhubelent district', 50],
                ['Köneürgenç', 'Koneurgench', 50],
                ['S.A. Nyýazow etraby', 'S.A. Nyyazow district', 50],
            ]],
        ];

        for ($i = 0; $i < count($objs); $i++) {
            $location = Location::create([
                'name' => [
                    'tm' => $objs[$i][0],
                    'en' => $objs[$i][1]
                ],
                'sort_order' => $i + 1,
            ]);

            for ($j = 0; $j < count($objs[$i][2]); $j++) {
                Location::create([
                    'parent_id' => $location->id,
                    'name' => [
                        'tm' => $objs[$i][2][$j][0],
                        'en' => $objs[$i][2][$j][1],
                    ],
                    'delivery_fee' => $objs[$i][2][$j][2],
                    'sort_order' => $j + 1,
                ]);
            }
        }
    }
}
