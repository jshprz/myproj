import PulseLoader from './PulseLoader.vue'
import GridLoader from './GridLoader.vue'
import ClipLoader from './ClipLoader.vue'
import RiseLoader from './RiseLoader.vue'
import BeatLoader from './BeatLoader.vue'
import SyncLoader from './SyncLoader.vue'
import RotateLoader from './RotateLoader.vue'
import FadeLoader from './FadeLoader.vue'
import PacmanLoader from './PacmanLoader.vue'
import SquareLoader from './SquareLoader.vue'
import ScaleLoader from './ScaleLoader.vue'
import SkewLoader from './SkewLoader.vue'
import MoonLoader from './MoonLoader.vue'
import RingLoader from './RingLoader.vue'
import BounceLoader from './BounceLoader.vue'
import DotLoader from './DotLoader.vue'


Vue.config.debug = true

new Vue({
	el: '#app',
	components: {
    PulseLoader,
    GridLoader,
    ClipLoader,
    RiseLoader,
    BeatLoader,
    SyncLoader,
    RotateLoader,
    FadeLoader,
    PacmanLoader,
    SquareLoader,
    ScaleLoader,
    SkewLoader,
    MoonLoader,
    RingLoader,
    BounceLoader,
    DotLoader
  },
  data: {
   		color: '#5dc596',
      size: '15px',
      margin: '2px',
      radius: '100%',
      product_title: '',
      product_price: '',
      product_sales_price: '',
      product_description: '',
      product_inventory_control: '',
      product_stocks: '',
      product_manufacturer: '',
      product_shipping: ''
  },
  methods:{
    sendPostAddProduct()
    {
        this.loading = true;
        axios.post('localhost:8000/createproduct',
        {   
            product_title:this.product_title,
            product_price:this.product_price,
            product_sales_price:this.product_sales_price,
            product_description:this.product_description,
            product_inventory_contro:this.product_inventory_control,
            product_stocks:this.product_stocks,
            product_manufacturer:this.product_manufacturer,
            product_shipping:this.product_shipping
        }
    ).then(response => {
        console.log(response.data);
    });
    }
}
})

