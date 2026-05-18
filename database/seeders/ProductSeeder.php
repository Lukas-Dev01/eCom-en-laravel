<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name'=>'LG Velvet 5G',
                "price"=>"200",
                "description"=>"A compact LG smartphone with a crisp display, 4GB RAM, and dependable everyday cameras.",
                "category"=>"mobile",
                "gallery"=>"https://www.lg.com/us/images/cell-phones/md07522101/gallery/desktop-01.jpg"
            ],
            [
                'name'=>'Oppo A52',
                "price"=>"300",
                "description"=>"A slim Oppo phone with smooth performance, generous memory, and a bright full-screen display.",
                "category"=>"mobile",
                "gallery"=>"https://cdn.tgdd.vn/Products/Images/42/220649/oppo-a52-den-1-org.jpg"
            ],
            [
                'name'=>'Panasonic 32 inch LED TV',
                "price"=>"400",
                "description"=>"A Panasonic flat-screen TV with clean picture quality, simple controls, and living-room ready styling.",
                "category"=>"tv",
                "gallery"=>"https://i.gadgets360cdn.com/products/televisions/large/1548154685_832_panasonic_32-inch-lcd-full-hd-tv-th-l32u20.jpg"
            ],
            [
                'name'=>'Soni Tv',
                "price"=>"500",
                "description"=>"A Sony-style Bravia TV with sharp 4K visuals, smart streaming, and a slim modern stand.",
                "category"=>"tv",
                "gallery"=>"https://sony.scene7.com/is/image/sonyglobalsolutions/TVFY24_Category_4KTV_Primary_image"
            ],
            [
                'name'=>'LG fridge',
                "price"=>"200",
                "description"=>"A stainless LG refrigerator with roomy storage, quiet cooling, and a polished kitchen-ready finish.",
                "category"=>"fridge",
                "gallery"=>"https://media.us.lg.com/transform/ecomm-PDPGalleryThumbnail-350x350/244b5165-5a87-4c84-9c7a-da42b288908d/Refrigerator_LRMVC2306D_gallery_01_5000x5000"
             ],
            [
                'name'=>'Samsung Galaxy A55',
                "price"=>"420",
                "description"=>"A polished 5G phone with a vivid AMOLED display, strong battery life, and a clean camera system.",
                "category"=>"mobile",
                "gallery"=>"https://images.samsung.com/is/image/samsung/p6pim/uk/sm-a556blvceub/gallery/uk-galaxy-a55-5g-sm-a556-sm-a556blvceub-thumb-540594112"
            ],
            [
                'name'=>'iPhone 15',
                "price"=>"799",
                "description"=>"A premium smartphone with a bright Super Retina display, powerful performance, and dependable cameras.",
                "category"=>"mobile",
                "gallery"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-finish-select-202309-6-1inch-blue"
            ],
            [
                'name'=>'OnePlus Nord 4',
                "price"=>"499",
                "description"=>"A fast everyday phone with smooth performance, rapid charging, and a modern metal design.",
                "category"=>"mobile",
                "gallery"=>"https://image01.oneplus.net/media/202406/19/ec64eb41f5ad57f76861e8ecfe4c0c8c.png"
            ],
            [
                'name'=>'Samsung 55 inch Crystal UHD TV',
                "price"=>"650",
                "description"=>"A 4K smart TV with crisp color, built-in streaming apps, and a slim living-room friendly profile.",
                "category"=>"tv",
                "gallery"=>"https://images.samsung.com/is/image/samsung/p6pim/uk/ue55du7100kxxu/gallery/uk-crystal-uhd-du7100-ue55du7100kxxu-540814337"
            ],
            [
                'name'=>'LG OLED C4 48 inch TV',
                "price"=>"1200",
                "description"=>"A premium OLED TV with deep contrast, fast motion handling, and cinematic picture quality.",
                "category"=>"tv",
                "gallery"=>"https://www.lg.com/content/dam/channel/wcms/uk/images/tvs/oled48c44la_aeu_eek_uk_c/gallery/OLED48C44LA-DZ-01.jpg"
            ],
            [
                'name'=>'Sony Bravia 65 inch Google TV',
                "price"=>"1100",
                "description"=>"A large 4K smart TV with Google TV, refined color processing, and immersive entertainment features.",
                "category"=>"tv",
                "gallery"=>"https://sony.scene7.com/is/image/sonyglobalsolutions/TVFY24_Category_4KTV_Primary_image"
            ],
            [
                'name'=>'Whirlpool Double Door Fridge',
                "price"=>"780",
                "description"=>"A spacious double door refrigerator with organized storage and efficient cooling for family use.",
                "category"=>"fridge",
                "gallery"=>"https://www.whirlpoolindia.com/media/catalog/product/cache/5d19b65ac524def04232243c5e1d9d79/2/0/205-impc-prm-3s-sapphire-flume.jpg"
            ],
            [
                'name'=>'Samsung Bespoke Fridge',
                "price"=>"1450",
                "description"=>"A modern refrigerator with flexible storage, refined styling, and dependable freshness control.",
                "category"=>"fridge",
                "gallery"=>"https://images.samsung.com/is/image/samsung/p6pim/uk/rb38c7b6ab1-eu/gallery/uk-combi-rb38c7b6ab1-eu-thumb-536655655"
            ],
            [
                'name'=>'Haier 320L Frost Free Fridge',
                "price"=>"620",
                "description"=>"A frost free refrigerator with balanced capacity, fast cooling, and a practical layout.",
                "category"=>"fridge",
                "gallery"=>"https://image.haier.com/in/refrigerators/W020230918565222733005.png"
            ],
            [
                'name'=>'Google Pixel 8a',
                "price"=>"549",
                "description"=>"A smart Android phone with helpful AI features, excellent photos, and a compact everyday feel.",
                "category"=>"mobile",
                "gallery"=>"https://lh3.googleusercontent.com/yJgW2qSc16c64H1ciY7uwWnpAn7ayAL5PUyB65vwjIt_ee1SH9bAVnD_rB0HUVZUKnVvQmcr1FcPMdKI5JvbVSLXxmJX6MSz"
            ],
            [
                'name'=>'MacBook Air 13 inch M3',
                "price"=>"1099",
                "description"=>"A thin and light Apple laptop with the M3 chip, all-day battery life, and a bright Liquid Retina display.",
                "category"=>"laptop",
                "gallery"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mba13-m3-midnight-gallery1-202402"
            ],
            [
                'name'=>'Samsung Galaxy S24 Ultra',
                "price"=>"1199",
                "description"=>"A premium Galaxy phone with a large display, advanced cameras, S Pen support, and fast performance.",
                "category"=>"mobile",
                "gallery"=>"https://images.samsung.com/is/image/samsung/p6pim/uk/sm-s928bzkgeub/gallery/uk-galaxy-s24-ultra-s928-sm-s928bzkgeub-thumb-539573014"
            ],
            [
                'name'=>'PlayStation 5 Slim Console',
                "price"=>"499",
                "description"=>"A compact PlayStation 5 console with fast loading, immersive graphics, and a large game library.",
                "category"=>"gaming",
                "gallery"=>"https://gmedia.playstation.com/is/image/SIEPDC/ps5-slim-dualsense-image-block-01-en-16nov23"
            ],
            [
                'name'=>'Bose QuietComfort Ultra Headphones',
                "price"=>"429",
                "description"=>"Premium noise-canceling headphones with immersive audio, plush comfort, and strong battery life.",
                "category"=>"audio",
                "gallery"=>"https://assets.bosecreative.com/transform/0e86a5f5-7697-4b12-baa8-e0b60a571b7e/QCUH24_Black_PDP_Ecom-Gallery-Img-1"
            ],
            [
                'name'=>'Ninja Foodi DualZone Air Fryer',
                "price"=>"229",
                "description"=>"A dual-basket air fryer that cooks two foods at once with independent zones and easy controls.",
                "category"=>"appliance",
                "gallery"=>"https://res.cloudinary.com/sharkninja-na/image/upload/c_scale,w_900/v1/SharkNinja-NA/Ninja/Product%20Images/DZ401/DZ401_01"
            ],
            [
                'name'=>'iPad Air 11 inch M2',
                "price"=>"599",
                "description"=>"A lightweight Apple tablet with the M2 chip, vivid display, and support for creative work on the go.",
                "category"=>"tablet",
                "gallery"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/ipad-air-finish-select-gallery-202405-11inch-blue"
            ],
            [
                'name'=>'AirPods Pro 2',
                "price"=>"249",
                "description"=>"Apple wireless earbuds with active noise cancellation, adaptive audio, and a compact charging case.",
                "category"=>"earbuds",
                "gallery"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83"
            ],
            [
                'name'=>'Google Pixel Watch 3',
                "price"=>"349",
                "description"=>"A sleek Google smartwatch with fitness tracking, helpful apps, and all-day wearable convenience.",
                "category"=>"wearable",
                "gallery"=>"https://lh3.googleusercontent.com/wh9fVfFZ2FE0IOuOOmFqddhlMiHzLoYfyKPkTL0VZ5KSUoGl30AkOAPqIBsEhH7aUJkW27aIYlSuuLu8dlM4yCBkkT4hnfUn3g"
            ],
            [
                'name'=>'GoPro HERO13 Black',
                "price"=>"399",
                "description"=>"A rugged action camera built for crisp video, stabilization, and adventure-ready shooting.",
                "category"=>"camera",
                "gallery"=>"https://gopro.com/content/dam/help/hero13-black/product-images/hero13-black.png"
            ],
            [
                'name'=>'Canon EOS R50 Camera',
                "price"=>"679",
                "description"=>"A compact mirrorless camera for sharp photos, 4K video, and flexible everyday content creation.",
                "category"=>"camera",
                "gallery"=>"https://www.usa.canon.com/dam/canon/product-assets/cameras/eos-r50/gallery/eos-r50-black-rf-s18-45mm-front-angle.png"
            ],
            [
                'name'=>'JBL Flip 6 Speaker',
                "price"=>"129",
                "description"=>"A portable waterproof Bluetooth speaker with bold sound, durable design, and long battery life.",
                "category"=>"audio",
                "gallery"=>"https://www.jbl.com/on/demandware.static/-/Sites-masterCatalog_Harman/default/dw0f74c31b/JBL_FLIP_6_HERO_BLACK_29391_x1.png"
            ],
            [
                'name'=>'Meta Quest 3 Headset',
                "price"=>"499",
                "description"=>"A mixed reality headset for immersive games, apps, fitness, entertainment, and virtual worlds.",
                "category"=>"gaming",
                "gallery"=>"https://scontent.oculuscdn.com/v/t64.5771-25/390424732_306445131987211_111863588504727357_n.png"
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['name' => $product['name']],
                array_merge($product, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }
    }
}
