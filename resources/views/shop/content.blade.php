<main class="col-sm-9">
    <div class="container">
        <div class="row">
            <div class="col-md-4" v-for="datas in data">
                <div class="card">
                    <div class="card-body text-center">
                       

                         <img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+datas.product_image.split(',')[0]" width="250">
                        <div class="title">@{{ datas.product_name }} <span class="icon-basket float-right"></span></div>
                        <span class="price-new">@{{ numeral(datas.product_original_price).format('0.0') }}</span>
                        <form action="{{route('auth.details',['storeName' => $storeName])}}" method="GET">

                            <input type="hidden" name="product_id" :value="datas.id">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search-plus"></i>
                                Quick view
                            </button>
                        </form>
                    </div>
                    <div class="footer p-15">

                    </div>
                </div>
                <!--<figure class="card card-sm card-product">
                        <div class="img-wrap">
                            <img :src="'https://res.cloudinary.com/hrwjn43y4/image/upload/'+datas.product_image.split(',')[0]">
                        <form action="route('auth.details',['storeName' => $storeName])}}" method="GET">
                        <input type="hidden" name="product_id" :value="datas.id">
                        <button type="submit" class="btn-overlay">
                                <i class="fa fa-search-plus"></i>
                                Quick view
                            
                            </button>
                            </form>
                        </div>
                        <figcaption class="info-wrap">
                            <a href="#" class="title"></a>
                            <div class="action-wrap">
                                <div class="price-wrap h5">
                                    <span class="price-new">{ numeral(datas.product_original_price).format('$0.0') }}</span>
                                </div>
                                        <div class="ratings">
                                            <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        </div>
                            </div>
                        </figcaption>
                    </figure>-->
            </div>

        </div>


        <nav aria-label="Page navigation example" v-show="pagination.current_page > 0">

            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{disabled:!pagination.first_link}"><a class="page-link" href="#" @click="getProducts(category[0].category_name,pagination.from_page)">&laquo</a></li>
                <li class="page-item" :class="{disabled:!pagination.prev_link}"><a class="page-link" href="#" @click="getProducts(category[0].category_name,pagination.prev_link)">&lt</a></li>
                <li class="page-item" v-for="n in pagination.last_page" :class="{active: pagination.current_page == n}"><a
                        class="page-link" href="#" @click="getProducts(category[0].category_name,pagination.path_page + n)">@{{n}}</a></li>
                <li class="page-item" :class="{disabled:!pagination.next_link}"><a class="page-link" href="#" @click="getProducts(category[0].category_name,pagination.next_link)">&gt</a></li>
                <li class="page-item" :class="{disabled:!pagination.last_link}"><a class="page-link" href="#" @click="getProducts(category[0].category_name,pagination.last_page)">&raquo</a></li>

            </ul>
        </nav>
</main>