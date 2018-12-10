@extends('master.index')

@section('content')
<div id="app">
  <div class="container">
    <section class="hero">
      <div class="container">
        <!-- Breadcrumbs -->
        <ol class="breadcrumb justify-content-center">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Shopping Carts</li>
        </ol>
        <!-- Hero Content-->
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading">Shopping Carts</h1>
          <div class="row">
            <div class="col-xl-8 offset-xl-2">
              <p class="lead text-muted">You have @{{ cartCount }} items in your shopping cart</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8">
                <div class="table-responsive">
                  <table class="table table-borderless table-centered mb-0">
                    <thead class="thead-light">
                      <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th style="width: 50px;"></th>
                      </tr>
                    </thead>
                    <tbody v-for="carts in cart">
                      <tr>
                        <td>
                          <img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+carts.options.image" class="rounded mr-3"
                            height="64">
                          <p class="m-0 d-inline-block align-middle font-16">
                            <a href="apps-ecommerce-products-details.html" class="text-body">Unpowered aircraft</a>
                            <br>
                            <small class="mr-2"><b>Size:</b> Large </small>
                            <small><b>Color:</b> Orange </small>
                          </p>
                        </td>
                        <td>
                          Php.@{{ carts.price }}
                        </td>
                        <td>
                          <input type="number" min="0" :value="carts.qty" class="form-control" placeholder="Qty" style="width: 90px;"
                            @change="getCartContentPost(carts,this.event)">
                        </td>
                        <td>
                          Php.@{{ carts.qty * carts.price }}
                        </td>
                        <td>
                          <a href="javascript:void(0);" class="action-icon" @click="removeItem(carts)"> <i class="fas fa-times"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- end table-responsive-->

                <div class="row mt-4">
                  <div class="col-sm-6">
                    <a href="{{ route('auth.shops',['storeName' => $storeName]) }}" class="btn text-muted d-none d-sm-inline-block btn-link font-weight-semibold">
                      <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                  </div> <!-- end col -->
                  <div class="col-sm-6">
                    <div class="text-sm-right">
                      <form action="{{route('auth.checkout',['storeName' => $storeName])}}" method="POST">
                        @csrf
                        <input type="hidden" name="total_checkout" :value="total">
                        <input type="hidden" name="cart[]" v-for="ct in cart" :value="ct.id+'-'+ct.qty+'-'+ct.price">
                        <input type="hidden" name="cart_length" :value="cartLength">
                        <button type="submit" class="btn btn-primary" href="{{route('auth.checkout',['storeName' => $storeName])}}"
                          v-show="cartLength > 0">Proceed to checkout</button>

                      </form>
                    </div>
                  </div> <!-- end col -->
                </div> <!-- end row-->
              </div>
              <!-- end col -->

              <div class="col-lg-4">
                <div class="border p-3 mt-4 mt-lg-0 rounded">
                  <h4 class="header-title mb-3">Orders Summary</h4>

                  <div class="table-responsive">
                    <table class="table mb-0">
                      <tbody>
                        <tr>
                          <td>Grand Total :</td>
                          <td>Php. @{{
                            numeral(cartSubtotal).format('Php.0.0') }}</td>
                        </tr>
                        <tr>
                          <td>Shipping Charge :</td>
                          <td>Php.@{{
                            numeral(ship_fee).format('Php.0.0') }}</td>
                        </tr>
                        <tr>
                          <td>Estimated Tax : </td>
                          <td>Php.@{{ numeral(tax).format('Php.0.0') }}</td>
                        </tr>
                        <tr>
                          <th>Total :</th>
                          <th>Php.@{{
                            numeral(total).format('Php.0.0') }}</th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- end table-responsive -->
                </div>

              </div> <!-- end col -->

            </div> <!-- end row -->
          </div> <!-- end card-body-->
        </div> <!-- end card-->
      </div> <!-- end col -->
              </section>

    </div>

  </div>
</div>
@endsection
@push('script')
<script>
  new Vue({
    el: '#app',
    data: {
      cart: {},
      cartCount: 0,
      cartSubtotal: 0,
      ship_fee: 0,
      tax: 0,
      total: 0,
      cartLength: 0
    },
    created: function () {
      this.getCartContentGet();
    },
    methods: {
      getCartContentPost(cart, e) {
        console.log(e.target.value);
        axios.post('/api/view-cart', {
          row_id: cart.rowId,
          quantity: e.target.value
        }).then(response => {
          this.cart = response.data.content;
          this.cartCount = response.data.count;
          this.cartSubtotal = response.data.subtotal;
          var cartArray = Object.values(this.cart);
          for (let i = 0; i < cartArray.length; i++) {

            if (cart['id'] == cartArray[i]['id']) {
              cartArray[i]['qty'] = cart['qty'];
            }
            cartArray[i]['totalPrice'] = cartArray[i]['price'] * cartArray[i]['qty'];
          }
          this.getCartContentGet();
          this.ship_fee = 0;
          this.tax = 0;
          console.log(cartArray);
        }).catch(e => {
          console.log(e);
        });
      },
      getCartContentGet() {
        axios.get('/api/view-cart-get').then(response => {
          this.cart = response.data.content;
          this.cartCount = response.data.count;
          this.cartSubtotal = response.data.subtotal;
          newSubtotal = this.cartSubtotal.split(',').join('');
          var cartArray = Object.values(this.cart);
          var sum = 0;
          for (let i = 0; i < cartArray.length; i++) {
            this.ship_fee += cartArray[i]['options']['shipping_fee'];
            this.tax += cartArray[i]['options']['tax'];
            this.total = parseFloat(parseInt(newSubtotal) + this.ship_fee + this.tax);
          }
          this.cartLength = cartArray.length;

        }).catch(e => {
          console.log(e);
        });
      },
      removeItem(cart) {
        axios.post('/api/remove-item-cart', {
          row_id: cart.rowId
        }).then(response => {
          console.log(response.data);
          this.getCartContentGet();
        }).catch(e => {
          console.log(e);
        });
      }
    }
  });
</script>
@endpush