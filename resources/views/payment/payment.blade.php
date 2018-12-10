@extends('master.index')

@section('content')
    
<div id="app">
  
<div class="container" style="margin:2rem auto">
        <section class="section-intro bg-img padding-y-lg">
            <div class="row">
                <div class="col-sm-6 mx-auto">
                    <article class="white text-center mb-5">
                        <h1 class="display-4">Select Payment Method</h1>
                    </article>
                </div>
            </div>
        </section>
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Address</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Payment Method</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Order Review</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <form action="#">
                                    <div class="block">
                                      <!-- Invoice Address-->
                                      <div class="block-header">
                                        <h6 class="text-uppercase mb-0">Invoice address                    </h6>
                                      </div>
                                      <div class="block-body">
                                        <div class="row">
                                          <div class="form-group col-md-6">
                                            <label for="fullname_invoice" class="form-label">Full Name</label>
                                            <input type="text" name="fullname_invoice" placeholder="Joe Black" id="fullname_invoice" class="form-control" v-model="invoice.fullname">
                                          </div>
                                         
                                          <div class="form-group col-md-6">
                                            <label for="emailaddress_invoice" class="form-label">Email Address</label>
                                            <input type="text" name="emailaddress_invoice" placeholder="joe.black@gmail.com" id="emailaddress_invoice" class="form-control" v-model="invoice.email_address">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="street_invoice" class="form-label">Street</label>
                                            <input type="text" name="street_invoice" placeholder="123 Main St." id="street_invoice" class="form-control" v-model="invoice.street">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="city_invoice" class="form-label">City</label>
                                            <input type="text" name="city_invoice" placeholder="City" id="city_invoice" class="form-control" v-model="invoice.city">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="zip_invoice" class="form-label">ZIP</label>
                                            <input type="text" name="zip_invoice" placeholder="Postal code" id="zip_invoice" class="form-control" v-model="invoice.zip">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="state_invoice" class="form-label">Barangay</label>
                                            <input type="text" name="barangay_invoice" placeholder="State" id="state_invoice" class="form-control" v-model="invoice.barangay">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for="phonenumber_invoice" class="form-label">Phone Number</label>
                                            <input type="text" name="phonenumber_invoice" placeholder="Phone Number" id="phonenumber_invoice" class="form-control" v-model="invoice.phone_number">
                                          </div>
                                          <!-- <div class="form-group col-12 mt-3">
                                            <div class="custom-control custom-checkbox">
                                              <input id="show-shipping-address" type="checkbox" name="clothes-brand" class="custom-control-input">
                                              <label for="show-shipping-address" data-toggle="collapse" data-target="#shippingAddress" aria-expanded="false" aria-controls="shippingAddress" class="custom-control-label align-middle">Use a different shipping address</label>
                                            </div>
                                          </div> -->
                                        </div>
                                        <!-- /Invoice Address-->
                                      </div>
                                      <!-- Shippping Address-->
                                      <div id="shippingAddress" aria-expanded="false" class="collapse">
                                        <div class="block">
                                          <div class="block-header">
                                            <h6 class="text-uppercase mb-0">Shipping address </h6>
                                          </div>
                                          <div class="block-body">
                                            <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="house_shipping" class="form-label">House detail</label>
                                                <input type="text" name="house_detail" placeholder="123 Main St." id="house_shipping" class="form-control" v-model="invoice.house_detail">
                                              </div>
                                              <div class="form-group col-md-6">
                                                <label for="street_shipping" class="form-label">Street</label>
                                                <input type="text" name="street_shipping" placeholder="123 Main St." id="street_shipping" class="form-control">
                                              </div>
                                              
                                              <div class="form-group col-md-6">
                                                <label for="city_shipping" class="form-label">City</label>
                                                <input type="text" name="city_shipping" placeholder="City" id="city_shipping" class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                <label for="zip_shipping" class="form-label">ZIP</label>
                                                <input type="text" name="zip_shipping" placeholder="Postal code" id="zip_shipping" class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                <label for="state_shipping" class="form-label">Barangay</label>
                                                <input type="text" name="barangay_shipping" placeholder="State" id="state_shipping" class="form-control">
                                              </div>
                                              <div class="form-group col-md-6">
                                                <label for="phonenumber_shipping" class="form-label">Phone Number</label>
                                                <input type="text" name="phonenumber_shipping" placeholder="Phone Number" id="phonenumber_shipping" class="form-control">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- /Shipping Address-->
                                      </div>
                                    </div>
                                    <!-- <div class="mb-5 d-flex justify-content-between flex-column flex-lg-row"><a href="cart.html" class="btn btn-link text-muted"> <i class="fa fa-angle-left mr-2"></i>Back </a><a href="checkout2.html" class="btn btn-dark">Choose delivery method<i class="fa fa-angle-right ml-2"></i></a></div> -->
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="mb-5">
                                    <div id="accordion" role="tablist">
                                      <!-- <div class="block mb-3">
                                        <div id="headingOne" role="tab" class="block-header"><strong><a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="accordion-link">Credit Card</a></strong></div>
                                        <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" class="collapse show">
                                          <div class="block-body">
                                            <form action="#">
                                              <div class="row">
                                                <div class="form-group col-md-6">
                                                  <label for="card-name" class="form-label">Name on Card</label>
                                                  <input type="text" name="card-name" placeholder="Name on card" id="card-name" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                  <label for="card-number" class="form-label">Card Number</label>
                                                  <input type="text" name="card-number" placeholder="Card number" id="card-number" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                  <label for="expiry-date" class="form-label">Expiry Date</label>
                                                  <input type="text" name="expiry-date" placeholder="MM/YY" id="expiry-date" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                  <label for="cvv" class="form-label">CVC/CVV</label>
                                                  <input type="text" name="cvv" placeholder="123" id="cvv" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                  <label for="zip" class="form-label">ZIP</label>
                                                  <input type="text" name="zip" placeholder="123" id="zip" class="form-control">
                                                </div>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div> -->
                                      <div class="block mb-3">
                                        <div id="headingTwo" role="tab" class="block-header"><strong><a data-toggle="collapse" href="#collapseStripe" aria-expanded="false" aria-controls="collapseTwo" class="accordion-link collapsed">Stripe</a></strong></div>
                                        <div id="collapseStripe" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" class="collapse">
                                          <div class="block-body py-5 d-flex align-items-center">
                                            <input type="radio" name="shippping" id="payment-method-1" value="stripe" v-model="paymentService">
                                          
                                            <label for="payment-method-1" class="ml-3"><strong class="d-block text-uppercase mb-2"><br> Pay with Stripe</strong></label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="block mb-3">
                                        <div id="headingTwo" role="tab" class="block-header"><strong><a data-toggle="collapse" href="#collapsePaypal" aria-expanded="false" aria-controls="collapseTwo" class="accordion-link collapsed">Paypal</a></strong></div>
                                        <div id="collapsePaypal" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" class="collapse">
                                          <div class="block-body py-5 d-flex align-items-center">
                                            <input type="radio" name="shippping" id="payment-method-2" value="paypal" v-model="paymentService">
                                        
                                            <label for="payment-method-1" class="ml-3"><strong class="d-block text-uppercase mb-2"><br> Pay with PayPal</strong></label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="block mb-3">
                                        <div id="headingThree" role="tab" class="block-header"><strong><a data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="accordion-link collapsed">Pay on delivery</a></strong></div>
                                        <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion" class="collapse">
                                          <div class="block-body py-5 d-flex align-items-center">
                                            <input type="radio" name="shippping" id="payment-method-3" value="cod" v-model="paymentService">
                      
                                           <label for="payment-method-2" class="ml-3"><strong class="d-block text-uppercase mb-2"><br>Pay on delivery</strong></label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="card">
                                    <div class="card-header text-center">
                                     <div class="row">
                                         <div class="col-5">
                                             Item
                                         </div>
                                         <div class="col-2">
                                             Price
                                         </div>
                                         <div class="col-2">
                                             Quantity
                                         </div>
                                         <div class="col-2">
                                             Total
                                         </div>
                                         <div class="col-1">
                                             
                                         </div>
                                     </div>
                                    </div>
                                    <div class="card-body">
                                            <div class="cart-item">
                                                    <div class="row d-flex align-items-center text-center" v-for="carts in cart">
                                                            <div class="col-5">
                                                              <div class="d-flex align-items-center"><img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+carts.options.image" alt="..." class="cart-item-img">
                                                                <div class="cart-title text-left"><a href="detail.html" class="text-uppercase text-dark"><strong>Guacamole</strong></a><br><span class="text-muted text-sm">Size: Large</span><br><span class="text-muted text-sm">Colour: Green</span>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-2">Php.@{{ numeral(carts.price).format('0.0') }}</div>
                                                            <div class="col-2">
                                                              <div class="d-flex align-items-center">
                                                                <div class="quantity d-flex align-items-center">
                                                                <div class="col-6"> @{{ carts.qty }} </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-2 text-center">Php.@{{ numeral(carts.qty * carts.price).format('0.0') }}</div>
                                                           
                                                          </div>
                                            </div>
                                            
                                                  
                                    </div>
                                  </div>
                            </div>
                          </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="box">
                        <b>Shipping Information</b>
                        <dl class="dlist-align">
                            <dt>Buyer's Name: </dt>
                            <dd class="text-right">@{{ invoice.fullname }}</dd>
                        </dl>
                        <dl class="dlist-align">
                       
                            <dt>Email:</dt>
                            <dd class="text-right">@{{ invoice.email_address }}</dd>
                        </dl>
                        <dl class="dlist-align">
                      
                            <dt>House Detail:</dt>
                            <dd class="text-right">@{{ invoice.house_detail }}</dd>
                            
                        </dl>
                        <dl class="dlist-align">
                      
                            <dt>Street:</dt>
                            <dd class="text-right">@{{ invoice.street }}</dd>
                            
                        </dl>
                        <dl class="dlist-align">
                      
                            <dt>City:</dt>
                            <dd class="text-right">@{{ invoice.city }}</dd>
                            
                        </dl>
                        <dl class="dlist-align">
                            <dt>Zip:</dt>
                            <dd class="text-right">@{{ invoice.zip }}</dd>
                            
                        </dl>
                        <dl class="dlist-align">
                        <dt>Barangay:</dt>
                            <dd class="text-right">@{{ invoice.barangay }}</dd>
                        </dl>
                        <hr>
                        <b>Order Summary</b>
                        <dl class="dlist-align">
                            <dt>
                                Subtotal <small>(@{{ cartCount }}&nbspitems)</small>
                            </dt>
                            <dd class="text-right">Php.@{{ numeral(cartSubtotal).format('0.0') }}</dd>
                        </dl>
                        <dl class="dlist-align">
                        <br>
                            <dt>Shipping Fee:</dt>
                            <dd class="text-right">Php.@{{ numeral(ship_fee).format('0.0') }}</dd>
                        </dl>
                        <dl class="dlist-align">
                      
                            <dt>Tax:</dt>
                            <dd class="text-right">Php.@{{ numeral(tax).format('0.0') }}</dd>
                        </dl>
                        <dl class="dlist-align">
                            <dt>Total cost: </dt>
                            <dd class="text-right">Php.@{{ numeral(total).format('0.0') }}</dd>
                        </dl>
                    </div>

                    <!-- box.// -->
                    <form action="{{ route('auth.paywithpaypal',['storeName' => $storeName]) }}" method="POST" v-show="paymentService == 'stripe'">
                      @csrf
                      
                      <input type="hidden" name="total_checkout" value="{{$total_checkout}}">
                        <input type="hidden" name="order_id" :value="orderId">
                        <button type="submit" class="btn btn-primary btn-block">Pay with stripe
                                </button>

                    </form>

                    <form action="{{ route('auth.paywithpaypal',['storeName' => $storeName]) }}" method="POST" v-show="paymentService == 'paypal'">
                      @csrf
                      
                      <input type="hidden" name="total_checkout" value="{{$total_checkout}}">
                        <input type="hidden" name="order_id" :value="orderId">
                        <button type="submit" class="btn btn-primary btn-block">Pay with paypal
                                </button>

                    </form>

                    <form action="{{ route('auth.selectCourier',['storeName' => $storeName]) }}" method="GET" v-show="paymentService == 'cod'">
                      <input type="hidden" name="fullname" :value="invoice.fullname">
                      <input type="hidden" name="email" :value="invoice.email_address">
                      <input type="hidden" name="house_detail" :value="invoice.house_detail">
                      <input type="hidden" name="street" :value="invoice.street">
                      <input type="hidden" name="city" :value="invoice.city">
                      <input type="hidden" name="zip" :value="invoice.zip">
                      <input type="hidden" name="barangay" :value="invoice.barangay">
                      <input type="hidden" name="phone_number" :value="invoice.phone_number">
                      <input type="hidden" name="order_id" :value="orderId">
                      <input type="hidden" name="total_checkout" value="{{$total_checkout}}">
                        <button type="submit" class="btn btn-primary btn-block">Pay with cod
                                </button>

                    </form>
                    <br>
                    <form action="{{ route('auth.viewcart',['storeName' => $storeName]) }}" method="GET">
                    <button type="submit" class="btn btn-danger btn-block">Cancel
                                </button>
                    </form>
                    <!-- <form action="{{ route('auth.paywithstripe',['storeName' => $storeName]) }}" method="POST">
                      @csrf
            <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_EG7E5FlwRDG69wlI4O0RBtMy"
                    data-amount="1999"
                    data-name="Stripe Demo"
                    data-description="Online course about integrating Stripe"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="usd">
            </script>
        </form> -->
                    
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@push('script')
<script>
  new Vue({
    el:'#app',
    data:{
      cart:[],
      transaction:[],
      orderId:0,
      cartCount:0,
      cartSubtotal:0,
      ship_fee:0,
      tax:0,
      total:0,
      cartLength:0,
      payment:'stripe,paypal',
      paymentService:'',
      invoice:{'fullname':'your name','email_address':'your email','house_detail':'your house detail','street':'your street','city':'your city','zip':'your zip','barangay':'your barangay','phone_number':'your number'}
    },
    created: function()
    {
        this.getStoreCredentials();
        this.getCartContentGet();
        this.getLastTransaction();
    },
    methods:{
      getStoreCredentials()
      {
          axios.get('/api/get-authenticated-store').then(response => {
              this.payment = response.data.payment;
              console.log(this.payment);
          }).catch(e => {
              console.log(e);
          });
      },
      getCartContentGet()
      {
          axios.get('/api/view-cart-get').then(response => {
              this.cart = response.data.content;
              this.cartCount = response.data.count;
              this.cartSubtotal = response.data.subtotal;
              newSubtotal = this.cartSubtotal.split(',').join('');
              var cartArray = Object.values(this.cart);   
              var sum = 0;
              for(let i = 0;i < cartArray.length;i++)
              {
                  this.ship_fee += cartArray[i]['options']['shipping_fee'];
                  this.tax += cartArray[i]['options']['tax'];
                  this.total = parseFloat(parseInt(newSubtotal) + this.ship_fee + this.tax);
              }
              this.cartLength = cartArray.length;
              console.log(this.cart);
          }).catch(e => {
              console.log(e);
          });
      },
      getLastTransaction()
      {
          axios.get('/api/get-last-transaction').then(response => {
            this.transaction = response.data;
            var transactionArray = Object.values(this.transaction);   
            if(transactionArray.length <= 0)
            {
                this.orderId = 1;
            }
            else
            {
              this.orderId = this.transaction.order_id; 
              this.orderId += 1;
            }
     
          }).catch(e => {
             console.log(e);
          });
      }
    }
  });
</script>
@endpush