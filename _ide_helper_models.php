<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $recipient_name
 * @property string $recipient_phone_number
 * @property string $city
 * @property string $postal_code
 * @property string $full_address
 * @property string|null $additional_instructions
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $combined_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shipping> $shippings
 * @property-read int|null $shippings_count
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAdditionalInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereRecipientPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $message
 * @property int|null $related_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereRelatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllNotification whereUpdatedAt($value)
 */
	class AllNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $status
 * @property int $is_popup
 * @property string|null $show_from
 * @property string|null $show_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $is_show
 * @property-read mixed $show_date
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel byActive()
 * @method static \Database\Factories\CarouselFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereIsPopup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereShowFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereShowUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereUpdatedAt($value)
 */
	class Carousel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $promo_id
 * @property string $name
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductCategories> $productCategories
 * @property-read int|null $product_categories_count
 * @property-read \App\Models\Promo|null $promo
 * @method static \Database\Factories\CategoriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories wherePromoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereUpdatedAt($value)
 */
	class Categories extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $products
 * @property string $destination
 * @property string $payment_receipt
 * @property string $promo
 * @property int $total_raw
 * @property int $total_final
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @method static \Database\Factories\CustomerHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory wherePaymentReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory wherePromo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereTotalFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereTotalRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerHistory whereUserId($value)
 */
	class CustomerHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $promo_id
 * @property string $status
 * @property int $total
 * @property int $total_final
 * @property string $billed_at
 * @property string|null $paid_at
 * @property string|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\Promo|null $promo
 * @property-read \App\Models\Shipping|null $shipping
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBilledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePromoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $product_detail_id
 * @property int $product_price
 * @property int $quantity
 * @property int $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CustomerHistory|null $customerHistory
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\ProductDetail|null $productDetail
 * @method static \Database\Factories\OrderDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereProductDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereUpdatedAt($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $payment_receipt
 * @property int $total
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $already_sold
 * @property-read mixed $check_order_status
 * @property-read mixed $price_range
 * @property-read mixed $stock_per_unit_types
 * @property-read mixed $total_sold
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductCategories> $productCategories
 * @property-read int|null $product_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductDetail> $productDetails
 * @property-read int|null $product_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RestockLog> $restockLogs
 * @property-read int|null $restock_logs_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Categories|null $category
 * @property-read \App\Models\Product|null $product
 * @method static \Database\Factories\ProductCategoriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategories whereUpdatedAt($value)
 */
	class ProductCategories extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $promo_id
 * @property string $unit_type
 * @property int $price
 * @property int $quantity
 * @property int $min_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RestockFromWarehouseLogs> $convertedToProducts
 * @property-read int|null $converted_to_products_count
 * @property-read mixed $first_image
 * @property-read mixed $product_promo
 * @property-read mixed $promo_detail
 * @property-read mixed $promo_price
 * @property-read mixed $sold
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RestockFromWarehouseLogs> $openedProducts
 * @property-read int|null $opened_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Promo|null $promo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShoppingCart> $shoppingCarts
 * @property-read int|null $shopping_carts_count
 * @method static \Database\Factories\ProductDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail ofUnitType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereMinOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail wherePromoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetail whereUpdatedAt($value)
 */
	class ProductDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $promo_code
 * @property string $type
 * @property int $amount
 * @property int|null $max_amount
 * @property string $valid_from
 * @property string $valid_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Categories> $categories
 * @property-read int|null $categories_count
 * @property-read mixed $active
 * @property-read mixed $promo_detail
 * @property-read mixed $tag
 * @property-read mixed $valid_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductDetail> $productDetails
 * @property-read int|null $product_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Promo byActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo byPromoCode($promoCode)
 * @method static \Database\Factories\PromoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Promo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereValidUntil($value)
 */
	class Promo extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $opened_product_id
 * @property int $converted_to_product_id
 * @property int $opened_amount
 * @property int $received_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductDetail|null $convertedToProduct
 * @property-read \App\Models\ProductDetail|null $openedProduct
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\RestockFromWarehouseLogsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereConvertedToProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereOpenedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereOpenedProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereReceivedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockFromWarehouseLogs whereUserId($value)
 */
	class RestockFromWarehouseLogs extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property string $unit_type
 * @property int $before_restock
 * @property int $after_restock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\RestockLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereAfterRestock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereBeforeRestock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RestockLog whereUserId($value)
 */
	class RestockLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $address_id
 * @property string $shipping_number
 * @property string|null $type
 * @property int $subtotal
 * @property string $status
 * @property string|null $proof_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read mixed $shipping_type
 * @property-read \App\Models\Order|null $order
 * @method static \Database\Factories\ShippingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereProofImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereShippingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipping whereUpdatedAt($value)
 */
	class Shipping extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_detail_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductDetail|null $productDetail
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ShoppingCartFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereProductDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingCart whereUserId($value)
 */
	class ShoppingCart extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $phone
 * @property string $role
 * @property string|null $profile_image
 * @property string|null $birth_date
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomerHistory> $customerHistories
 * @property-read int|null $customer_histories_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShoppingCart> $shoppingCarts
 * @property-read int|null $shopping_carts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

