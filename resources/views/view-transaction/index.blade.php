@extends('master.index')

@section('content')
<div id="app">
  <div class="container">
    <section class="hero">
      <div class="container">
        <!-- Breadcrumbs -->
        
        <!-- Hero Content-->
        
        <div class="hero-content pb-5 text-center">
          <h1 class="hero-heading">My Transaction</h1>
          <div class="row">
            <div class="col-xl-8 offset-xl-2">
            
            </div>
          </div>
          <a class="btn btn-primary" href="{{ route('auth.shops',['storeName' => $storeName]) }}">Back</a>
        </div>
      </div>
    </section>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
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
                    <tbody v-for="t in transaction">
                      <tr>
                        <td>
                          <img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+t.product_image.split(',')[0]" class="rounded mr-3"
                            height="64">
                          <p class="m-0 d-inline-block align-middle font-16">
                            <a href="apps-ecommerce-products-details.html" class="text-body">Unpowered aircraft</a>
                            <br>
                            <small class="mr-2"><b>Size:</b> Large </small>
                            <small><b>Color:</b> Orange </small>
                          </p>
                        </td>
                        <td>
                          Php.@{{ t.product_original_price }}
                        </td>
                        <td>
                          <div>@{{ t.quantity }}</div>
                        </td>
                        <td>
                          Php.@{{ t.quantity * t.product_original_price }}
                          
                        </td>
                        <td>
                          <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" @click="postTransactions(t.id)">More</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- end table-responsive-->

                
              </div>
              <!-- end col -->

             
            </div> <!-- end row -->
          </div> <!-- end card-body-->
        </div> <!-- end card-->
      </div> <!-- end col -->

    </div>

  </div>


  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">
                        <i class="fas fa-qrcode"></i>
                         <span>Order Number:3</span>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" v-for="t in modalTransactionData">
                <div class="container">

                  
                <textarea class="form-control form-control-light mb-2 mt-3" v-model="postFeedback.message" placeholder="Tell us what you thought about it"
                    id="example-textarea" rows="3"></textarea>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       v-model="postFeedback.title" placeholder="Give your review title">
                </div>

                <div class="starrating risingstar d-flex  flex-row-reverse">
            <input type="radio" id="star5" name="rating" value="5" @click="setStars(5,t.product_id)"/><label for="star5" title="5 star"></label>
            <input type="radio" id="star4" name="rating" value="4"  @click="setStars(4,t.product_id)"/><label for="star4" title="4 star"></label>
            <input type="radio" id="star3" name="rating" value="3"  @click="setStars(3,t.product_id)"/><label for="star3" title="3 star"></label>
            <input type="radio" id="star2" name="rating" value="2"  @click="setStars(2,t.product_id)"/><label for="star2" title="2 star"></label>
            <input type="radio" id="star1" name="rating" value="1"  @click="setStars(1,t.product_id)"/><label for="star1" title="1 star"></label>
                <p>Rate:</p>
  
       
                
                    <div class="btn-group mb-2">
                        <button type="button" class="btn btn-link btn-sm text-muted font-18"><i class="dripicons-paperclip"></i></button>
                    </div>
                                
                    <div class="btn-group mb-12 ml-12">
                    <div class="btn btn-primary w-35 ld-ext-right running" @click="createFeedback(t.product_id)">
 Send
  <div :class="goSpin"></div>
</div>
                        
                    </div>
                </div>
            </div>
        

            </div>
            </div>
</div>

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
      transaction:[],
      modalTransactionData:[],
      postFeedback:{'message':'','title':'','stars':0},
      goSpin:''
    },
    created: function () {
      this. getTransactions();
    },
    methods: {
     getTransactions()
     {
        axios.get('/api/get-transactions').then(response => {
            this.transaction = response.data;
            console.log(this.transaction);
        });
     },
     postTransactions(id)
     {
      axios.post('/api/post-transactions',{id:id}).then(response => {
          this.modalTransactionData = response.data;
          console.log(this.modalTransactionData);
        });
     },
     setStars(star,id)
     {
        this.postFeedback.stars = star;
        axios.post('/api/create-star',{
          product_id:id,
          star:star
        }).then(response => {
          console.log(response.data);
        }).catch(e => {
          console.log(e);
        });
     },
     createFeedback(id)
     {
      new Promise((resolve,reject) => {
                this.goSpin = 'ld ld-ring ld-spin';
                setTimeout(() => {
                resolve(1);
            },1000)
            }).then(() => {

              axios.post('/api/create-feedback',{
          product_id:id,
          message:this.postFeedback.message,
          title:this.postFeedback.title,
          star:this.postFeedback.stars
        }).then(response => {
          this.goSpin = '';
          console.log(response.data);
          if(response.data.success == true)
          {
            toastr.success('Success');
          }
          else
          {
            toastr.error('Failed');
          }
        }).catch(e => {
          this.goSpin = '';
          console.log(e);
        });

            });
        
     }
    }
  });
</script>
@endpush