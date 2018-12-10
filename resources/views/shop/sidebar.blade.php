<aside class="col-sm-3">
        <div class="card card-filter">
            <article class="card-group-item">
                <header class="card-header">
                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
                        <h6 class="title">By Category</h6>
                    </a>
                </header>
                <div class="filter-content collapse show" id="collapse22">
                    <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" placeholder="Search" type="text" v-model="searchInput">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" @click="getProductCategory">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        <ul class="list-unstyled list-lg">
                            <li v-for="categories in category">
                                <a href="#" @click="getProducts(categories.category_name)">
                                        @{{ categories.category_name }} <span class="float-right badge badge-light round">@{{ categories.product.length }}</span>
                                </a>
                            </li>
                
                        </ul>
                    </div>
                </div>
            </article>
            <article class="card-group-item">
                <header class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse33" aria-expanded="true" class="">
                        <h6 class="title">By Price  </h6>
                    </a>
                </header>
                <div class="filter-content collapse show" id="collapse33" style="">
                    <div class="card-body">
                       <center>0 - @{{ numeral(priceRange).format('0.0') }}</center>
                        <input type="range" class="custom-range" min="0" max="10000" name="" v-model="priceRange" @change="searchBySlider()">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Min</label>
                                <input class="form-control" placeholder="$0" type="number" v-model="minimum">
                            </div>
                            <div class="form-group text-right col-md-6">
                                <label>Max</label>
                                <input class="form-control" placeholder="$1,0000" type="number" v-model="maximum">
                            </div>
                        </div>
                        <button class="btn btn-block btn-outline-primary" @click="searchByPriceRange">Apply</button>
                    </div>
                </div>
            </article>
        </div>
</aside>