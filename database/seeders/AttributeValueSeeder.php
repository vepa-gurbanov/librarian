<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            ['Cover', ['Softcover', 'Hardcover with ImageWrap', 'Hardcover with dust jacket']],
        ];

        foreach ($objs as $obj)
        {
            $attr = new Attribute();
            $attr->setTranslation('name', 'en', $obj[0]);
            $attr->slug = str($obj[0])->slug('_');
            $attr->save();
            foreach ($obj[1] as $objVal)
            {
                $attrValue = new AttributeValue();
                $attrValue->attribute_id = $attr->id;
                $attrValue->setTranslation('name', 'en', $objVal);
                $attrValue->slug = str($objVal)->slug('_');
                $attrValue->save();
            }
        }
    }
}
