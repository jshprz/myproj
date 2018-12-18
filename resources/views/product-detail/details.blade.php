@extends('master.index')


@section('content')
<div id="app">
@include('includes.navbar')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10 ">
                <div class="card" style="background:white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <!-- Product image -->
                                <a href="images/items/1.jpg" class="text-center d-block mb-4">
                                    <img src="https://res.cloudinary.com/hrwjn43y4/image/upload/{{ $exploded_images[0] }}" class="img-fluid"
                                        style="max-width: 280px;" alt="Product-img">
                                </a>

                                
                            </div> <!-- end col -->
                            <div class="col-lg-7">
                                <div class="pl-lg-4">
                                    <!-- Product title -->
                                    <h3 class="mt-0">{{ $products->product_name }}<a href="apps-ecommerce-add-products.html"
                                            class="text-muted"><i class="mdi mdi-square-edit-outline ml-2"></i></a>
                                    </h3>
                                    <p class="font-16">
                                        <span class="text-warning mdi mdi-star"></span>
                                        <span class="text-warning mdi mdi-star"></span>
                                        <span class="text-warning mdi mdi-star"></span>
                                        <span class="text-warning mdi mdi-star"></span>
                                        <span class="text-warning mdi mdi-star"></span>
                                    </p>

                                    <!-- Product stock -->
                                     <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                                    <div class="mt-3">
                                        <h4><span class="badge badge-success-lighten">Instock</span></h4>
                                    </div>

                                    <!-- Product description -->
                                    <div class="mt-4">
                                        <h6 class="font-14">Retail Price:</h6>
                                        <h3>
                                        @{{ numeral(productPrice).format('0.0') }}</h3>

                                        <h6 class="font-14">Remaining Stock:</h6>
                                        <h3>
                                        {{ $products->product_quantity }}</h3>
                                    </div>
                                    
                                    <!-- Product description -->
                                    <div class="mt-4">
                                        <h6 class="font-14">Description:</h6>
                                        <p>{{ $products->product_description }}</p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="mt-4">
                                        <h6 class="font-14">Quantity</h6>
                                        <div class="d-flex">
                                            <input type="number" class="form-control" v-model="quantity" placeholder="Qty"
                                                style="width: 90px;">
                                            @auth
                                            <form action="{{ route('auth.addcart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="item_quantity" :value="quantity">
                                                <input type="hidden" name="item_id" value="{{ $products->id }}">
                                                <input type="hidden" name="item_image" value="{{ $exploded_images[0] }}">
                                                <input type="hidden" name="item_name" value="{{ $products->product_name }}">
                                                <input type="hidden" name="item_price" value="{{ $products->product_original_price }}">
                                                <input type="hidden" name="item_shipping_fee" value="{{ $products->shipping_fee }}">
                                                <input type="hidden" name="item_tax" value="{{ $products->tax }}">
                                                <button type="submit" href="#" class="btn  btn-primary ml-2"><i class="fas fa-shopping-cart"></i>
                                                    Add to cart </button>
                                            </form>
                                            @endauth

                                            @guest
                                            <form action="{{ route('guest.user-login') }}" method="GET">
                                                @csrf
                                                <button type="submit" href="#" class="btn  btn-primary ml-2"><i class="fas fa-shopping-cart"></i>
                                                    Add to cart </button>
                                            </form>
                                            @endguest
                                        </div>
                                    </div>

                                    
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div> <!-- end card-body-->
                </div>
            </div>
        </div>
        

        <div class="row justify-content-center mt-3
        ">
            

                <div class="col-md-6">
                @foreach($product_feedback as $p)
                <div class="card">
                
                    <div class="card-body">
                        <div class="media mt-2">
                            <div class="media-body">
                                <h6 class="mt-0">{{ $p->firstname }} {{ $p->lastname }}</h6>
                                <span>{{ $p->message }}</span>
                            </div>
                        </div>

            

                    </div> <!-- end card-body-->
                    @endforeach
                </div>
            </div>
        

        <div class="related" style="margin: 18px 0;">
            <div class="-related-content" style="
    padding: 17px 0;
">
                <h3>Similar Products</h3>
                <div class="row">

                    <div class="col-md-3" v-for="similar in similarProductData">
                        <figure class="card card-sm card-product">
                            <!-- <span class="badge-new">SALE </span> -->
                            <div class="img-wrap">
                                <img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+similar.product_image.split(',')[0]" width="250">
                                
                            </div>
                            <figcaption class="info-wrap">
                                <a href="#" class="title">@{{ similar.product_name }}</a>
                                <div class="action-wrap">
                                @auth
                                <form action="{{route('auth.details')}}" method="GET">
                                    <input type="hidden" name="product_id" :value="similar.id">
                                    <button type="submit" class="btn btn-primary btn-sm float-right">
                                        <i class="fa fa-search-plus"></i>
                                        Quick view

                                    </button>
                                </form>
                                @endauth

                                @guest
                                <form action="{{route('guest.details')}}" method="GET">
                                    <input type="hidden" name="product_id" :value="similar.id">
                                    <button type="submit" class="btn btn-primary btn-sm float-right">
                                        <i class="fa fa-search-plus"></i>
                                        Quick view

                                    </button>
                                </form>
                                @endguest
                                   
                                    <div class="price-wrap h5">
                                        <span class="price-new">Php.@{{ similar.product_original_price }}</span>
                                        <!-- <del class="price-old">$1980</del> -->
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('script')
<script>
    new Vue({
        el: '#app',
        data: {
            similarProductData: [],
            quantity: 1,
            cartCounts: 0,
            productPrice: '{{ $products->product_original_price }}'
        },
        created: function () {
            this.getSimilarProductData();
            this.cartCount();
        },
        methods: {
            getSimilarProductData() {
                axios.post('/api/get-similar-product', { product_id: '{{ $products->id }}', product_category_id: '{{ $product_category->id }}' }).then(response => {
                    this.similarProductData = response.data;
                }).catch(error => {
                    console.log(error.response);
                });
            },
            cartCount() {
        axios.get('/api/view-cart-get').then(response => {
          this.cartCounts = response.data.count;
          console.log(this.cartCounts);
        }).catch(e => {
          console.log(e);
        });
      }
        }
    });
</script>
@endpush