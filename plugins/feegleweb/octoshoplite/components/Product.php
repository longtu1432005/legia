<?php namespace Feegleweb\OctoshopLite\Components;

use Cms\Classes\ComponentBase;
use Feegleweb\OctoshopLite\Models\Category as ShopCategory;
use Feegleweb\OctoshopLite\Models\Order;
use Feegleweb\OctoshopLite\Models\Product as ShopProduct;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ntn\Configuration\Models\Configuration;
use October\Rain\Support\Facades\Flash;

class Product extends ComponentBase
{
    public $slug;
    public $idProduct;
    public $basket;
    public $mainImageSize;
    public $subImageSize;
    public $product;

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Product',
            'description' => 'Display a single product',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'default' => '{{ :slug }}',
                'type' => 'string',
            ],
            'id' => [
                'title' => 'Id',
                'default' => '{{ :id }}',
                'type' => 'string',
            ],
            'basket' => [
                'title' => 'Basket container element',
                'description' => 'Basket container element to update when adding products to cart',
            ],
            'mainImageSize' => [
                'title' => 'Main Image Size',
            ],
            'subImageSize' => [
                'title' => 'Thumbnail Size',
            ],
        ];
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->product = $this->page['product'] = $this->loadProduct();
        $categories = $this->product->categories;

        if (count($categories)) {
            $categories = $categories->toArray();
            $lastCategory = end($categories);
            $this->page['categoryOfProductBreadcrumb'] =
                count($categories) ? ShopCategory::getParentCategoryNested($lastCategory['slug']) : null;

            //these products are same category

            $this->page['sameCategoryProducts'] = ProductList::getSameCategoryProducts($lastCategory['id'], $this->idProduct);
            $this->page['categoriesOfProduct'] = $categories;
        }
    }

    public function prepareVars()
    {
        $this->slug = $this->page['slug'] = $this->property('slug');
        $this->idProduct = $this->page['idProduct'] = $this->property('id');
        $this->basket = $this->page['basket'] = $this->property('basket');
        $this->mainImageSize = $this->page['mainImageSize'] = $this->property('mainImageSize');
        $this->subImageSize = $this->page['subImageSize'] = $this->property('subImageSize');
    }

    public function loadProduct()
    {
        return ShopProduct::whereId($this->idProduct)
            ->with([
                'images' => function ($query) {
                    $query->orderBy('sort_order', 'asc');
                }
            ])
            ->first();
    }

    public function onSubmitOrder()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'username' => ['required', 'between:1,255'],
                'address' => ['required', 'between:1,255'],
                'phone' => ['required', 'between:1,255'],
                'product_id' => ['required', 'numeric'],
                'quantity' => ['required', 'numeric'],
            ]);
        if (! $validator->fails()) {
            $productId = (int)Input::get('product_id');
            $product = ShopProduct::whereId($productId)->first();
            if ($product) {
                $order = new Order();
                $order->username = strip_tags(Input::get('username'));
                $order->address = strip_tags(Input::get('address'));
                $order->phone = strip_tags(Input::get('phone'));
                $order->product_id = $productId;
                $order->quantity = (int)Input::get('quantity');

                $sizeAndColor = '';
                if (Input::has('size')) {
                    $sizeAndColor .= 'Size: ' . strip_tags(Input::get('size')) . "\n";
                }

                if (Input::has('color')) {
                    $sizeAndColor .= 'Color: ' . strip_tags(Input::get('color')) . "\n";
                }

                if ($sizeAndColor) {
                    $sizeAndColor .= "-----------------------------------\n";
                }
                $userNote = strip_tags(Input::get('note'));
                $order->note = $sizeAndColor . $userNote;
                $order->status = false;

                $order->price = $product->getPrice();
                $order->discount = $product->discount;

                $order->save();

                self::sendEmail($order);

                return [
                    'status' => true,
                    'order' => $order
                ];
            }
        }

        return [
            'status' => false,
            'messages' => $validator->messages()
        ];
    }

    public static function sendEmail(Order $order)
    {
        $recipientEmail = Configuration::getValueByKey('RECIPIENT_EMAIL_ORDER');
        Mail::send('feegleweb.octoshoplite::mail.new-order',
            [
                'order' => $order,
                'total' => $order->getTotalAttribute()
            ], function ($message) use ($recipientEmail) {

                $message->to($recipientEmail)
                    ->subject('Đơn đặt hàng');
            }
        );

    }
}
