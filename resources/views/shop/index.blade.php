@extends('buyer-side.master.index')

@section('content')

<div id="app">

  <section class="section-content bg padding-y">
    <div class="container">
      @include('buyer-side.includes.navbar')

      <section class="hero">
        <div class="container">
          <!-- Breadcrumbs -->
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">@{{ atTheMomentProductCategory }}</li>
          </ol>
          <!-- Hero Content-->
          <div class="hero-content pb-5 text-center">
            <h1 class="hero-heading">@{{ atTheMomentProductCategory }}</h1>
            <div class="row">
              <div class="col-xl-8 offset-xl-2">
               
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="row">
        @include('buyer-side.shop.sidebar')
        @include('buyer-side.shop.content')
      </div>
    </div>
    <div class="py-6 bg-gray-300 text-muted mt-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-5 mb-lg-0">
          <a class="blog-header-logo text-dark" href="{{ route('auth.mytransaction',['storeName' => $storeName]) }}">My transactions</a>
            <!-- <div class="font-weight-bold text-uppercase text-lg text-dark mb-3">Sell<span class="text-primary">.</span></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p> -->
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#" target="_blank" title="twitter" class="text-muted text-hover-primary"><i
                    class="fab fa-twitter"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="facebook" class="text-muted text-hover-primary"><i
                    class="fab fa-facebook"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="instagram" class="text-muted text-hover-primary"><i
                    class="fab fa-instagram"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="pinterest" class="text-muted text-hover-primary"><i
                    class="fab fa-pinterest"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="vimeo" class="text-muted text-hover-primary"><i
                    class="fab fa-vimeo"></i></a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
            <h6 class="text-uppercase text-dark mb-3">Shop</h6>
            <ul class="list-unstyled">
              <li> <a href="#" class="text-muted">For Women</a></li>
              <li> <a href="#" class="text-muted">For Men</a></li>
              <li> <a href="#" class="text-muted">Stores</a></li>
              <li> <a href="#" class="text-muted">Our Blog</a></li>
              <li> <a href="#" class="text-muted">Shop</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
            <h6 class="text-uppercase text-dark mb-3">Company</h6>
            <ul class="list-unstyled">
              <li> <a href="#" class="text-muted">Login </a></li>
              <li> <a href="#" class="text-muted">Register </a></li>
              <li> <a href="#" class="text-muted">Wishlist </a></li>
              <li> <a href="#" class="text-muted">Our Products </a></li>
              <li> <a href="#" class="text-muted">Checkouts </a></li>
            </ul>
          </div>
          <div class="col-lg-4">
            <h6 class="text-uppercase text-dark mb-3">Daily Offers &amp; Discounts</h6>
      
            <form action="#" id="newsletter-form">
              <div class="input-group mb-3">
                <input type="email" placeholder="Your Email Address" aria-label="Your Email Address" class="form-control bg-transparent border-secondary border-right-0">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-outline-secondary border-left-0"> <i class="fa fa-paper-plane text-lg text-dark"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </section>

</div>


@endsection
@push('script')
<script>
  new Vue({
    el: '#app',
    data: {
      data: [],
      category: [],
      atTheMomentProductCategory: '',
      pagination: [],
      searchInput: '',
      priceRange: 0,
      minimum: 0,
      maximum: 0,
      cartCounts: 0
    },
    created: function () {
      this.getProductCategory();
      this.cartCount();
    },
    methods: {
      getProducts(productCategory, url) {

        url = url || '/api/products-tobe-displayed';
        axios.post(url, {
          storeName: '{{ $storeName }}',
          productCategory: productCategory,
          searchProduct: this.searchInput
        }).then(response => {
          this.data = response.data.data;
          this.atTheMomentProductCategory = this.data[0].product_category.category_name;
          this.pagination = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            from_page: response.data.from,
            to_page: response.data.to,
            total_page: response.data.total,
            path_page: response.data.path + "?page=",
            first_link: response.data.first_page_link,
            last_link: response.data.last_page_link,
            prev_link: response.data.prev_page_url,
            next_link: response.data.next_page_url
          };
          console.log(this.data);
        }).catch((e) => {
          console.log(e);
        });
        this.pagination = {};
      },
      getProductCategory() {
        axios.post('/api/product-category-tobe-displayed', {
          storeName: '{{ $storeName }}'
        }).then(response => {
          this.category = response.data;
          this.getProducts(this.category[0].category_name);
          console.log(this.category);
        }).catch((e) => {
          console.log(e);
        });
      },
      searchByPriceRange() {
        axios.post('/api/search-by-price-range', {storeName:'{{ $storeName }}', minimum: this.minimum, maximum: this.maximum }).then(response => {
          this.data = response.data;
        }).catch(error => {
          console.log(error);
        })
      },
      cartCount() {
        axios.get('/api/view-cart-get').then(response => {
          this.cartCounts = response.data.count;
        }).catch(e => {
          console.log(e);
        });
      },
      searchBySlider() {
        axios.post('/api/search-by-slider',{
          storeName:'{{ $storeName }}',
          price:this.priceRange
        }).then(response => {
          this.data = response.data;
        }).catch(e => {
          console.log(e);
        });
      }
    }
  });
</script>
@endpush