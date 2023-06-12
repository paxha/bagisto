{!! view_render_event('bagisto.shop.products.view.reviews.after', ['product' => $product]) !!}

<v-product-review :product-id="{{ $product->id }}"></v-product-review>

@pushOnce('scripts')
    <script type="text/x-template" id="v-product-review-template">
        <div>
            <!-- Write Review Section -->
            <div class="w-full" v-if="canReview">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form
                        class="rounded mb-4 grid grid-cols-[auto_1fr] max-md:grid-cols-[1fr] gap-[40px] justify-center"
                        @submit="handleSubmit($event, store)"
                    >
                        <div>
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.control
                                    type="image"
                                    name="title"
                                    :value="old('title')"
                                    class="shadow text-[14px] appearance-none border rounded-[12px] w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rules="required"
                                    :label="trans('shop::app.products.title')"
                                    :placeholder="trans('shop::app.products.title')"
                                >
                                </x-shop::form.control-group.control>
                            </x-shop::form.control-group>
                        </div>

                        <div>
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="block text-gray-700 text-[12px] font-medium mb-2">
                                    @lang('shop::app.products.rating')
                                </x-shop::form.control-group.label>

                                <x-shop::products.star-rating
                                    name="rating"
                                    :value="old('rating') ?? 5"
                                    :disabled="false"
                                    rules="required"
                                    :label="trans('shop::app.products.rating')"
                                >
                                </x-shop::products.star-rating>

                                <x-shop::form.control-group.error
                                    control-name="rating"
                                >
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>

                            <x-shop::form.control-group class="mb-4 mt-[15px]">
                                <x-shop::form.control-group.label class="block text-gray-700 text-[12px] font-medium mb-2">
                                    @lang('shop::app.products.title')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="text"
                                    name="title"
                                    :value="old('title')"
                                    class="shadow text-[14px] appearance-none border rounded-[12px] w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rules="required"
                                    :label="trans('shop::app.products.title')"
                                    :placeholder="trans('shop::app.products.title')"
                                >
                                </x-shop::form.control-group.control>

                                <x-shop::form.control-group.error
                                    control-name="title"
                                >
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>

                            <x-shop::form.control-group class="mb-4 mt-[15px]">
                                <x-shop::form.control-group.label class="block text-gray-700 text-[12px] font-medium mb-2">
                                    @lang('shop::app.products.comment')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="textarea"
                                    rows="12"
                                    name="comment"
                                    :value="old('comment')"
                                    class="shadow text-[14px] appearance-none border rounded-[12px] w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rules="required"
                                    :label="trans('shop::app.products.comment')"
                                    :placeholder="trans('shop::app.products.comment')"
                                >
                                </x-shop::form.control-group.control>

                                <x-shop::form.control-group.error
                                    control-name="comment"
                                >
                                </x-shop::form.control-group.error>
                            </x-shop::form.control-group>

                            <button
                                class="m-0 ml-[0px] block mx-auto w-full bg-navyBlue text-white text-[16px] max-w-[374px] font-medium py-[16px] px-[43px] rounded-[18px] text-center"
                                type='submit'
                            >
                                @lang('shop::app.products.submit-review')
                            </button>
                        </div>
                    </form>
                </x-shop::form>
            </div>

            <!-- Review List Section -->
            <div v-if="! canReview">
                <div class="flex items-center justify-between gap-[15px] max-sm:flex-wrap">
                    <h3 class="font-dmserif text-[30px] max-sm:text-[22px]">
                        @lang('shop::app.products.customer-review')
                    </h3>

                    <div
                        class="flex gap-x-[15px] items-center rounded-[12px] border border-navyBlue px-[15px] py-[10px]"
                        @click="canReview = true"
                    >
                        <span class="icon-pen text-[24px]"></span>

                        @lang('shop::app.products.write-a-review')
                    </div>
                </div>

                <div class="flex justify-between items-center gap-[15px] mt-[30px] max-w-[365px] max-sm:flex-wrap">
                    <p class="text-[30px] font-medium max-sm:text-[16px]">{{ number_format($avgRatings, 1) }}</p>

                    <x-shop::products.star-rating :value="$avgRatings"></x-shop::products.star-rating>

                    <p class="text-[12px] text-[#858585]">
                        (@{{ meta.total }} @lang('shop::app.products.customer-review'))
                    </p>
                </div>

                <div class="flex gap-x-[20px] items-center">
                    <div class="flex gap-y-[18px] max-w-[365px] mt-[10px] flex-wrap">
                        @for ($i = 5; $i >= 1; $i--)
                            <div class="flex gap-x-[25px] items-center max-sm:flex-wrap">
                                <div class="text-[16px] font-medium">{{ $i }} Stars</div>
                                <div class="h-[16px] w-[275px] max-w-full bg-[#E5E5E5] rounded-[2px]">
                                    <div class="h-[16px] bg-[#FEA82B] rounded-[2px]" style="width: {{ $percentageRatings[$i] }}%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="grid grid-cols-[1fr_1fr] mt-[60px] gap-[20px] max-1060:grid-cols-[1fr]">
                    <!-- Single card review -->
                    <div
                        v-for='review in reviews'
                        class="flex gap-[20px] border border-[#e5e5e5] rounded-[12px] p-[25px] max-sm:flex-wrap"
                    >
                        <div class="min-h-[100px] min-w-[100px] max-sm:hidden">
                            <img
                                class="rounded-[12px]"
                                src='{{ bagisto_asset("images/review-man.png") }}'
                                title=""
                                alt=""
                            >
                        </div>

                        <div>
                            <div class="flex justify-between">
                                <p
                                    class="text-[20px] font-medium max-sm:text-[16px]"
                                    v-text="review.name"
                                >
                                </p>

                                <div class="flex items-center">
                                    <x-shop::products.star-rating ::name="review.name" ::value="review.rating"></x-shop::products.star-rating>
                                </div>
                            </div>

                            <p
                                class="text-[14px] font-medium mt-[10px] max-sm:text-[12px]"
                                v-text="review.created_at"
                            >
                            </p>

                            <p
                                class="text-[16px] text-[#7D7D7D] mt-[20px] max-sm:text-[12px]"
                                v-text="review.comment"
                            >
                            </p>

                            <div class="flex justify-between items-center mt-[20px] flex-wrap gap-[10px]">
                                <div class="flex gap-x-[10px]">
                                    <p class="text-[16px] text-[#7D7D7D] max-sm:text-[12px]">
                                        @lang('shop::app.products.was-this-helpful')
                                    </p>

                                    <div class="flex gap-[8px] text-[#7D7D7D]">
                                        <span class="icon-like text-[24px] text-[#D1D1D1]"></span>

                                        <span>0</span>
                                    </div>

                                    <div class="flex gap-[8px] text-[#7D7D7D]">
                                        <span class="icon-dislike text-[24px] text-[#D1D1D1]"></span>

                                        <span>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    class="block mx-auto text-navyBlue text-base w-max font-medium py-[11px] px-[43px] border rounded-[18px] border-navyBlue bg-white mt-[60px] text-center"
                    v-if="links?.next"
                    @click="get()"
                >
                    @lang('shop::app.products.load-more')
                </button>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-product-review', {
            template: '#v-product-review-template',

            props: ['productId'],

            data() {
                return {
                    canReview: false,

                    reviews: [],

                    links: {
                        next: '{{ route("shop.products.reviews.index", $product->id) }}',
                    },

                    meta: {},
                }
            },

            mounted() {
                this.get();
            },

            methods: {
                get() {
                    if (this.links?.next) {
                        this.$axios.get(this.links.next)
                            .then(response => {
                                this.reviews = [...this.reviews, ...response.data.data];

                                this.links = response.data.links;

                                this.meta = response.data.meta;
                            })
                            .catch(error => {});
                    }
                },

                store(params) {
                    this.$axios.post('{{ route("shop.products.reviews.store", $product->id) }}', params)
                        .then(response => {
                            alert(response.data.data.message);
                        })
                        .catch(error => {});
                },
            }
        });
    </script>
@endPushOnce

{!! view_render_event('bagisto.shop.products.view.reviews.after', ['product' => $product]) !!}
